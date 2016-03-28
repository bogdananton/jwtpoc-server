<?php
namespace JWTPOCUnitTests\Resources\Settings\Domain\Service;

use JWTPOC\Resources\Settings\Domain\Service;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Persistence\Repository;

class ServiceTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var  Repository|\Mockery\MockInterface */
    protected $repository;

    /** @var  Service|\Mockery\MockInterface */
    protected $service;

    public function setUp()
    {
        $this->repository = \Mockery::mock(Repository::class)->makePartial();
        $this->service = \Mockery::mock(Service::class, [$this->repository])->makePartial();
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
