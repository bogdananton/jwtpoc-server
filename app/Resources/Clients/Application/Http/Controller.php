<?php
namespace JWTPOC\Resources\Clients\Application\Http;


use JWTPOC\Resources\Clients\Infrastructure\Service;

class Controller
{
    /** @var Service  */
    protected $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function getListing()
    {
        return $this->service->getEntries();
    }

    /**
     * Retrieve a client entry.
     *
     * @param string $name
     * @return \JWTPOC\Resources\Clients\Infrastructure\Item|null
     */
    public function getItem($name)
    {
        return $this->service->findByName($name);
    }
}