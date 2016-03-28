<?php
namespace JWTPOCUnitTests\Resources\Settings\Persistence\Repository;


use JWTPOC\Resources\Settings\Persistence\Factory as PersistenceFactory;
use JWTPOC\Resources\Settings\Domain\Models\Item;

class FindByNameTest extends RepositoryTestCase
{
    /**
     * When regular (string) entry is found then return item.
     */
    public function testWhenRegularStringEntryIsFoundThenReturnItem()
    {
        $name = 'base-url';
        $value = 'http://localhost:20000';

        $this->factory
            ->shouldReceive('buildItem')
            ->passthru();

        $settingsSamplePath = RES_PATH . 'persistence/settings-sample.json';
        $list = json_decode(file_get_contents($settingsSamplePath));

        $itemList = $this->mapListFromRaw($list);

        $this->settingsGateway
            ->shouldReceive('all')
            ->andReturn($itemList);

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
        $value = '--public-key-contents--';

        $this->factory
            ->shouldReceive('buildItem')
            ->once()
            ->passthru();

        $settingsSamplePath = RES_PATH . 'persistence/settings-sample.json';
        $list = json_decode(file_get_contents($settingsSamplePath));

        $itemList = $this->mapListFromRaw($list);

        $this->settingsGateway
            ->shouldReceive('all')
            ->andReturn($itemList);

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
            ->shouldReceive('buildItem')
            ->never();

        $list = [];

        $this->settingsGateway
            ->shouldReceive('all')
            ->andReturn($list);

        $response = $this->repository->findByName($name);
        static::assertNull($response);
    }

    /**
     * @param $list
     * @return mixed
     */
    protected function mapListFromRaw($list)
    {
        $factory = new PersistenceFactory();

        $itemList = array_map(function ($entry) use ($factory) {
            return $factory->buildItem(
                $entry->name,
                $entry->description,
                $entry->value,
                $entry->type,
                $entry->public,
                $entry->admin,
                $entry->writable
            );
        }, $list);

        return $itemList;
    }
}
