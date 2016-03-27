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

        foreach ($entries as $entry) {
            if ($entry->name === $name) {
                // @todo again, use a mapper
                if ($entry->type == 'pub' || $entry->type == 'prv') {
                    $value = $this->keysGateway->getContents($entry->value);
                } else {
                    $value = $entry->value;
                }

                return $this->factory->buildSettingsItem(
                    $entry->name,
                    $entry->description,
                    $value
                );
            }
        }
    }
}
