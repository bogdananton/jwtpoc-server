<?php
namespace JWTPOC\Resources\Clients\Infrastructure;


use JWTPOC\Resources\Clients\Infrastructure\Repository as ClientsRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Service
{
    /** @var ClientsRepository  */
    protected $repository;

    public function __construct(ClientsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function findByName($name)
    {
        $item = $this->repository->findByName($name);

        if ($item instanceof Item) {
            return $item;
        }

        throw new NotFoundResourceException();
    }

    /**
     * @return Models\Item[]
     */
    public function getEntries()
    {
        return $this->repository->getEntries();
    }
}
