<?php
namespace JWTPOC\Resources\Clients\Infrastructure;

use JWTPOC\Contracts\Clients\Gateway as ClientsGateway;
use JWTPOC\Resources\Clients\Persistence\Factory as ClientsFactory;
use JWTPOC\Contracts\Keys\Gateway as KeysGateway;
use JWTPOC\Resources\Keys\Persistence\Factory as KeysFactory;
use JWTPOC\Resources\Keys\Persistence\Models\Item;

class Repository
{
    /** @var ClientsGateway */
    protected $clientsGateway;

    /** @var KeysGateway */
    protected $keysGateway;

    /** @var ClientsFactory */
    protected $clientsFactory;

    /** @var KeysFactory */
    protected $keysFactory;

    public function __construct(
        ClientsGateway $clientsGateway,
        KeysGateway $keysGateway,
        ClientsFactory $clientsFactory,
        KeysFactory $keysFactory
    ) {
        $this->clientsGateway = $clientsGateway;
        $this->clientsFactory = $clientsFactory;

        $this->keysGateway = $keysGateway;
        $this->keysFactory = $keysFactory;
    }

    /**
     * @param string $name
     * @return Item|null
     */
    public function findByName($name)
    {
        $entries = $this->clientsGateway->all();

        /** @var \JWTPOC\Resources\Clients\Persistence\Models\Item $entry */
        foreach ($entries as $entry) {
            if ($entry->getName() === $name) {
                $item = $this->buildItem($name, $entry);
                return $item;
            }
        }
    }

    /**
     * @return Item[]
     */
    public function getEntries()
    {
        $response = [];
        $entries = $this->clientsGateway->all();

        foreach ($entries as $entry) {
            $response[] = $this->buildItem($entry);
        }

        return $this->clientsFactory->buildCollection($response);
    }

    /**
     * @param $name
     * @param $entry
     * @return Models\Item
     */
    protected function buildItem($name, $entry)
    {
        $keysFactory = $this->keysFactory;

        $keyList = $keysFactory->buildCollection(array_map(function ($entry) use ($keysFactory) {
            return $keysFactory->buildItem(
                $entry->name,
                $entry->file, // @todo expand to include public / private pair
                $entry->alg,
                $entry->bits,
                $entry->created_at,
                $entry->expires_at
            );
        }), $this->keysGateway->getByOwner($name));

        $item = $this->clientsFactory->buildItem(
            $entry->getName(),
            $entry->getDescription(),
            $entry->getCallbackUrl(),
            $keyList
        );
        return $item;
    }
}
