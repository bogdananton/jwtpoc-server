<?php
namespace JWTPOCUnitTests\Resources\Settings\Persistence\Repository;

use JWTPOC\Resources\Settings\Domain\Factory as DomainFactory;
use JWTPOC\Resources\Settings\Persistence\Factory as PersistenceFactory;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Contracts\Settings\Gateway as SettingsGateway;
use JWTPOC\Contracts\Keys\Gateway as KeysGateway;
use JWTPOC\Resources\Settings\Persistence\Repository;
use JWTPOC\Resources\Settings\Persistence\Models\Item as PersistenceItem;

class RepositoryTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var  Repository|\Mockery\MockInterface */
    protected
    $repository;

    /** @var  SettingsGateway|\Mockery\MockInterface */
    protected
    $settingsGateway;

    /** @var  KeysGateway|\Mockery\MockInterface */
    protected
    $keyGateway;

    /** @var  DomainFactory|\Mockery\MockInterface */
    protected
    $factory;

    public
    function setUp()
    {
        $this->settingsGateway = \Mockery::mock(SettingsGateway::class)->makePartial();
        $this->keyGateway = \Mockery::mock(KeysGateway::class)->makePartial();
        $this->factory = \Mockery::mock(DomainFactory::class)->makePartial();

        $args = [
            $this->settingsGateway,
            $this->keyGateway,
            $this->factory,
        ];

        $this->repository = \Mockery::mock(Repository::class, $args)->makePartial();
    }

    public
    function tearDown()
    {
        \Mockery::close();
    }
}