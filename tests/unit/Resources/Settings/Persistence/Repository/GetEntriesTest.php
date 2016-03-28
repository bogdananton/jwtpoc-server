<?php
namespace JWTPOCUnitTests\Resources\Settings\Persistence\Repository;


use JWTPOC\Resources\Settings\Domain\Models\Item as DomainItem;
use JWTPOC\Resources\Settings\Persistence\Models\Item as PersistenceItem;

class GetEntriesTest extends RepositoryTestCase
{
    /**
     * When no entries are found in the gateway then return empty array.
     */
    public function testWhenNoEntriesAreFoundInTheGatewayThenReturnEmptyArray()
    {
        $this->settingsGateway
            ->shouldReceive('all')
            ->once()
            ->andReturn([]);

        $response = $this->repository->getEntries();
        static::assertSame([], $response);
    }

    /**
     * When entries are found then return an array of domain items using the factory.
     */
    public function testWhenEntriesAreFoundThenReturnAnArrayOfDomainItemsUsingTheFactory()
    {
        $item0 = new PersistenceItem(
            'name-0',
            'description-0',
            'value-0',
            'string',
            true,
            true,
            true
        );

        $item1 = new PersistenceItem(
            'name-1',
            'description-1',
            'file-1',
            'pub',
            true,
            true,
            true
        );

        $this->settingsGateway
            ->shouldReceive('all')
            ->once()
            ->andReturn([
                $item0,
                $item1,
            ]);

        $this->keyGateway
            ->shouldReceive('getContents')
            ->once()
            ->with('file-1')
            ->andReturn('--pub-contents-1--');
        
        $this->factory->shouldReceive('buildItem')
            ->twice()
            ->passthru();

        $response = $this->repository->getEntries();
        static::assertEquals(2, count($response));

        /** @var DomainItem $itemOut0 */
        $itemOut0 = $response[0];
        static::assertEquals('name-0', $itemOut0->getName());
        static::assertEquals('description-0', $itemOut0->getDescription());
        static::assertEquals('value-0', $itemOut0->getValue());
        static::assertEquals(true, $itemOut0->isPublic());

        /** @var DomainItem $itemOut1 */
        $itemOut1 = $response[1];
        static::assertEquals('name-1', $itemOut1->getName());
        static::assertEquals('description-1', $itemOut1->getDescription());
        static::assertEquals('--pub-contents-1--', $itemOut1->getValue());
        static::assertEquals(true, $itemOut1->isPublic());
    }
}

