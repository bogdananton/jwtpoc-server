<?php
namespace JWTPOC\Resources\Settings\Domain;


use JWTPOC\Resources\Settings\Persistence\Repository as SettingsRepository;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class Service
{
    protected $repository;

    public function __construct(SettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns a setting structure for the given identifier.
     *
     * @throws NotFoundResourceException when there is no resource with the given name.
     * @param string $name
     * @return \JWTPOC\Resources\Settings\Domain\Models\Item
     */
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