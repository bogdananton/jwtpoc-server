<?php
namespace JWTPOCUnitTests\Resources\Settings\Application\Http\Controller;

use JWTPOC\Resources\Settings\Presentation\Models\Item as PresentationItem;
use JWTPOC\Resources\Settings\Domain\Models\Item as DomainItem;

class GetItemTest extends ControllerTestCase
{
    /**
     * When not found will throw an exception.
     *
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testWhenNotFoundWillThrowAnException()
    {
        $name = 'not-found-item';
        $this->willFindItemByName($name, null);

        $this->controller->getItem($name);
    }

    /**
     * When the entry is found then return mapped presentation item.
     */
    public function testWhenTheEntryIsFoundThenReturnMappedPresentationItem()
    {
        $name = 'name-1';
        $domainItem = new DomainItem('name-1', 'description-1', 'value-1', true);

        $this->willFindItemByName($name, $domainItem);
        $response = $this->controller->getItem($name);

        static::assertInstanceOf(PresentationItem::class, $response);
        static::assertEquals('name-1', $response->getName());
        static::assertEquals('description-1', $response->getDescription());
        static::assertEquals('value-1', $response->getValue());
    }

    /**
     * When the item isn't public then throw not found exception.
     *
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testWhenTheItemIsnTPublicThenThrowNotFoundException()
    {
        $name = 'name-1';
        $domainItem = new DomainItem('name-1', 'description-1', 'value-1', false);
        $this->willFindItemByName($name, $domainItem);

        $this->controller->getItem($name);
    }

    /**
     * @param $name
     * @param $response
     */
    protected function willFindItemByName($name, $response)
    {
        $this->service
            ->shouldReceive('findByName')
            ->once()
            ->with($name)
            ->andReturn($response);
    }
}