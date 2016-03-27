<?php
namespace JWTPOCUnitTests\Resources\Persistence\Repository;

use JWTPOC\Resources\Settings\Domain\Factory;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Persistence\GatewayInterface;
use JWTPOC\Resources\Settings\Persistence\Repository;

class FindByNameTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Repository|\Mockery\MockInterface */
    protected $repository;

    /** @var  GatewayInterface|\Mockery\MockInterface */
    protected $gateway;

    /** @var  Factory|\Mockery\MockInterface */
    protected $factory;

    public function setUp()
    {
        $this->factory = \Mockery::mock(Factory::class)->makePartial();
        $this->gateway = \Mockery::mock(GatewayInterface::class)->makePartial();

        $args = [
            $this->gateway,
            $this->factory,
        ];

        $this->repository = \Mockery::mock(Repository::class, $args)->makePartial();
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * When entry is found then return item.
     */
    public function testWhenEntryIsFoundThenReturnItem()
    {
        $name = 'item-name';
        $description = 'item-description';
        $value = 'item-value';

        $this->factory
            ->shouldReceive('buildSettingsItem')
            ->once()
            ->with($name, $description, $value)
            ->passthru();

        $foundEntry = (object) [
            'name' => 'item-name',
            'description' => 'item-description',
            'value' => 'item-value',
        ];

        $otherEntry = (object) [
            'name' => 'some name',
            'description' => 'some description',
            'value' => 'some value',
        ];

        $list = [
            $otherEntry,
            $foundEntry,
        ];

        $this->gateway
            ->shouldReceive('all')
            ->andReturn($list);

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

        $this->gateway
            ->shouldReceive('all')
            ->andReturn($list);

        $response = $this->repository->findByName($name);
        static::assertNull($response);
    }
}
