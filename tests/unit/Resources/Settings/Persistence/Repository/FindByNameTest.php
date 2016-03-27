<?php
namespace JWTPOCUnitTests\Resources\Persistence\Repository;

use JWTPOC\Resources\Settings\Domain\Factory;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Contracts\Settings\Gateway as SettingsGateway;
use JWTPOC\Contracts\Keys\Gateway as KeysGateway;
use JWTPOC\Resources\Settings\Persistence\Repository;

class FindByNameTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Repository|\Mockery\MockInterface */
    protected $repository;

    /** @var  SettingsGateway|\Mockery\MockInterface */
    protected $settingsGateway;

    /** @var  KeysGateway|\Mockery\MockInterface */
    protected $keyGateway;

    /** @var  Factory|\Mockery\MockInterface */
    protected $factory;

    public function setUp()
    {
        $this->settingsGateway = \Mockery::mock(SettingsGateway::class)->makePartial();
        $this->keyGateway = \Mockery::mock(KeysGateway::class)->makePartial();
        $this->factory = \Mockery::mock(Factory::class)->makePartial();

        $args = [
            $this->settingsGateway,
            $this->keyGateway,
            $this->factory,
        ];

        $this->repository = \Mockery::mock(Repository::class, $args)->makePartial();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * When regular (string) entry is found then return item.
     */
    public function testWhenRegularStringEntryIsFoundThenReturnItem()
    {
        $name = 'base-url';
        $description = 'The base URL for self. Will be used as the issuer identity.';
        $value = 'http://localhost:20000';

        $this->factory
            ->shouldReceive('buildSettingsItem')
            ->once()
            ->with($name, $description, $value)
            ->passthru();

        $settingsSamplePath = RES_PATH . 'persistence/settings-sample.json';
        $list = json_decode(file_get_contents($settingsSamplePath));

        $this->settingsGateway
            ->shouldReceive('all')
            ->andReturn($list);

        $this->keyGateway
            ->shouldReceive('getContents')
            ->never();

        $response = $this->repository->findByName($name);
        static::assertInstanceOf(Item::class, $response);

        static::assertEquals($name, $response->getName());
        static::assertEquals($value, $response->getValue());
    }

    /**
     * When public key item is found then return item with key contents as value.
     */
    public function testWhenPublicKeyItemIsFoundThenReturnItemWithKeyContentsAsValue()
    {
        $name = 'public-key';
        $description = 'RSA256 public key.';
        $value = '--public-key-contents--';

        $this->factory
            ->shouldReceive('buildSettingsItem')
            ->once()
            ->with($name, $description, $value)
            ->passthru();

        $settingsSamplePath = RES_PATH . 'persistence/settings-sample.json';
        $list = json_decode(file_get_contents($settingsSamplePath));

        $this->settingsGateway
            ->shouldReceive('all')
            ->andReturn($list);

        $this->keyGateway
            ->shouldReceive('getContents')
            ->once()
            ->with('mine/default.pub')
            ->andReturn($value);

        $response = $this->repository->findByName($name);
        static::assertInstanceOf(Item::class, $response);

        static::assertEquals($name, $response->getName());
        static::assertEquals($value, $response->getValue());
    }

    /**
     * When not found then return null.
     */
    public function testWhenNotFoundThenReturnNull()
    {
        $name = 'item-name';

        $this->factory
            ->shouldReceive('buildSettingsItem')
            ->never();

        $otherEntry = (object) [
            'name' => 'some name',
            'description' => 'some description',
            'value' => 'some value',
        ];

        $list = [
            $otherEntry,
        ];

        $this->settingsGateway
            ->shouldReceive('all')
            ->andReturn($list);

        $response = $this->repository->findByName($name);
        static::assertNull($response);
    }
}
