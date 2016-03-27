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
                $item = $this->buildItem($entry);
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
            $response[] = $this->buildItem($entry);
        }

        return $response;
    }

    /**
     * @param \JWTPOC\Resources\Settings\Persistence\Models\Item $entry
     * @return string
     */
    protected function getEntryValueContents($entry)
    {
        if ($entry->isKey()) {
            $value = $this->keysGateway->getContents($entry->getValue());

        } else {
            $value = $entry->getValue();
        }

        return $value;
    }

    /**
     * @param \JWTPOC\Resources\Settings\Persistence\Models\Item $entry
     * @return Item
     */
    protected function buildItem($entry)
    {
        $value = $this->getEntryValueContents($entry);

        $item = $this->factory->buildSettingsItem(
            $entry->getName(),
            $entry->getDescription(),
            $value,
            $entry->isPublic()
        );

        return $item;
    }
}
