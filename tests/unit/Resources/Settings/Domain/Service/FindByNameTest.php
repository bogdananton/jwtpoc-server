<?php
namespace JWTPOCUnitTests\Resources\Settings\Domain\Service;

use JWTPOC\Resources\Settings\Domain\Service;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Persistence\Repository;

class FindByNameTest extends ServiceTestCase
{
    /**
     * When no entry is found then throw exception.
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testWhenNoEntryIsFoundThenThrowException()
    {
        $name = 'setting-that-will-not-be-found';
        $response = null;

        $this->repository->shouldReceive('findByName')
            ->once()
            ->with($name)
            ->andReturn($response);

        $this->service->findByName($name);
    }

    /**
     * When an entry is found then return it as a setting domain item.
     */
    public function testWhenAnEntryIsFoundThenReturnItAsASettingDomainItemWithTheGivenName()
    {
        $name = 'setting-that-will-be-found';
        $response = \Mockery::mock(Item::class);

        $this->repository->shouldReceive('findByName')
            ->once()
            ->with($name)
            ->andReturn($response);

        $actual = $this->service->findByName($name);
        static::assertSame($response, $actual);
    }
}
