<?php
namespace JWTPOCUnitTests\Resources\Settings\Domain\Service;

use JWTPOC\Resources\Settings\Domain\Service;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Persistence\Repository;

class GetEntriesTest extends ServiceTestCase
{
    /**
     * Will return response from repository.
     */
    public function testWillReturnResponseFromRepository()
    {
        $response = [
            'repo-response'
        ];

        $this->repository->shouldReceive('getEntries')
            ->once()
            ->andReturn($response);

        $actual = $this->service->getEntries();
        static::assertEquals($response, $actual);
    }
}
