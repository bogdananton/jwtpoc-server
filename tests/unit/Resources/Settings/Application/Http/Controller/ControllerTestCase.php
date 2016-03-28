<?php
namespace JWTPOCUnitTests\Resources\Settings\Application\Http\Controller;

use JWTPOC\Resources\Settings\Application\Http\Controller;
use JWTPOC\Resources\Settings\Domain\Service;
use JWTPOC\Resources\Settings\Presentation\Factory;

class ControllerTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var \Mockery\Mock|Service */
    protected $service;

    /** @var \Mockery\Mock|Factory */
    protected $factory;

    /** @var \Mockery\Mock|Controller */
    protected $controller;

    public function __construct()
    {
        $this->service = \Mockery::mock(Service::class);
        $this->factory = \Mockery::mock(Factory::class)->makePartial();

        $this->controller = \Mockery::mock(Controller::class, [
            $this->service,
            $this->factory
        ])->makePartial();
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
