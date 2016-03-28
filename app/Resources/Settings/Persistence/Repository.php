<?php
namespace JWTPOC\Resources\Settings\Persistence;

use JWTPOC\Contracts\Keys\Gateway as KeysGateway;
use JWTPOC\Contracts\Settings\Gateway as SettingsGateway;
use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Domain\Factory;

/**
 * @note this and the settings service should be moved to the infrastructure layer
 */
class Repository
{
    /** @var SettingsGateway */
    protected $settingsGateway;

    /** @var KeysGateway */
    protected $keysGateway;

    /** @var Factory */
    protected $factory;

    /**
     * Settings constructor.
     *
     * @param SettingsGateway $settingsGateway
     * @param KeysGateway $keysGateway
     * @param Factory $factory
     */
    public function __construct(
        SettingsGateway $settingsGateway,
        KeysGateway $keysGateway,
        Factory $factory
    ) {
        $this->settingsGateway = $settingsGateway;
        $this->keysGateway = $keysGateway;
        $this->factory = $factory;
    }

    /**
     * @note this method knows too much.
     * @see main class note
     *
     * @param string $name
     * @return Item|null
     */
    public function findByName($name)
    {
        $entries = $this->settingsGateway->all();

        /** @var \JWTPOC\Resources\Settings\Persistence\Models\Item $entry */
        foreach ($entries as $entry) {
            if ($entry->getName() === $name) {

                $item = $this->buildItem(
                    $entry->getName(),
                    $entry->getDescription(),
                    $entry->getValue(),
                    $entry->isPublic(),
                    $entry->isKey()
                );

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
        $entries = $this->settingsGateway->all();

        foreach ($entries as $entry) {
            $item = $this->buildItem(
                $entry->getName(),
                $entry->getDescription(),
                $entry->getValue(),
                $entry->isPublic(),
                $entry->isKey()
            );

            $response[] = $item;
        }

        return $response;
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $value
     * @param bool $isPublic
     * @param bool $isKey
     * @return Item
     */
    protected function buildItem(
        $name,
        $description,
        $value,
        $isPublic,
        $isKey
    ) {
        $value = $isKey
            ? $this->keysGateway->getContents($value)
            : $value;

        $item = $this->factory->buildItem(
            $name,
            $description,
            $value,
            $isPublic
        );

        return $item;
    }
}
