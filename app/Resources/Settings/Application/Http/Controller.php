<?php
namespace JWTPOC\Resources\Settings\Application\Http;

use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Domain\Service;
use JWTPOC\Resources\Settings\Presentation\Factory;

class Controller
{
    /** @var Service  */
    protected $service;

    /** @var  Factory */
    protected $factory;

    /**
     * Controller constructor.
     * @param Service $service
     * @param Factory $factory
     */
    public function __construct(Service $service, Factory $factory)
    {
        $this->service = $service;
        $this->factory = $factory;
    }

    /**
     * @return \JWTPOC\Resources\Settings\Presentation\Models\Collection
     */
    public function getListing()
    {
        $entries = [];

        /** @var Item $entry */
        foreach ($this->service->getEntries() as $entry) {
            if ($entry->isPublic()) {
                $item = $this->factory->buildItem(
                    $entry->getName(),
                    $entry->getDescription(),
                    $entry->getValue()
                );
                
                $entries[] = $item;
            }
        }

        $collection = $this->factory->buildCollection($entries);
        return $collection;
    }
}
