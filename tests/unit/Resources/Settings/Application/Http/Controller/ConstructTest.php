<?php
namespace JWTPOCUnitTests\Resources\Settings\Application\Http\Controller;

use JWTPOC\Resources\Settings\Application\Http\Controller;

class ConstructTest extends ControllerTestCase
{
    /**
     * Will store the service to self.
     */
    public function testWillStoreTheServiceToSelf()
    {
        $this->controller = new Controller($this->service, $this->factory);

        static::assertSame(
            $this->service,
            \PHPUnit_Framework_Assert::readAttribute($this->controller, "service")
        );
    }

    /**
     * Will store the factory to self.
     */
    public function testWillStoreTheFactoryToSelf()
    {
        $this->controller = new Controller($this->service, $this->factory);

        static::assertSame(
            $this->factory,
            \PHPUnit_Framework_Assert::readAttribute($this->controller, "factory")
        );
    }
}
