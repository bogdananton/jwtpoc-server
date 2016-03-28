<?php
namespace JWTPOCUnitTests\Resources\Settings\Application\Http\Controller;

use JWTPOC\Resources\Settings\Presentation\Models\Collection;
use JWTPOC\Resources\Settings\Presentation\Models\Item as PresentationItem;
use JWTPOC\Resources\Settings\Domain\Models\Item as DomainItem;

class GetListingTest extends ControllerTestCase
{
    /**
     * When not entries found then will return empty presentation collection.
     */
    public function testWhenNotEntriesFoundThenWillReturnEmptyPresentationCollection()
    {
        $this->willReturnItems([]);

        $collection = $this->controller->getListing();

        static::assertInstanceOf(Collection::class, $collection);
        static::assertEquals(0, $collection->count());
    }

    /**
     * When when public entries are found then get as presentation item collection.
     */
    public function testWhenWhenPublicEntriesAreFoundThenGetAsPresentationItemCollection()
    {
        $domainItem0 = new DomainItem('name-0', 'description-0', 'value-0', true);
        $domainItem1 = new DomainItem('name-1', 'description-1', 'value-1', true);
        $domainItemHidden = new DomainItem('name-2', 'description-2', 'value-2', false);

        $this->willReturnItems([
            $domainItem0,
            $domainItemHidden,
            $domainItem1,
        ]);

        $collection = $this->controller->getListing();

        static::assertInstanceOf(Collection::class, $collection);
        static::assertEquals(2, $collection->count());

        static::assertInstanceOf(PresentationItem::class, $collection->get(0));
        static::assertEquals('name-0', $collection->get(0)->getName());
        static::assertEquals('description-0', $collection->get(0)->getDescription());
        static::assertEquals('value-0', $collection->get(0)->getValue());

        static::assertInstanceOf(PresentationItem::class, $collection->get(1));
        static::assertEquals('name-1', $collection->get(1)->getName());
        static::assertEquals('description-1', $collection->get(1)->getDescription());
        static::assertEquals('value-1', $collection->get(1)->getValue());
    }

    protected function willReturnItems(array $entries)
    {
        $this->service
            ->shouldReceive('getEntries')
            ->once()
            ->andReturn($entries);
    }
}