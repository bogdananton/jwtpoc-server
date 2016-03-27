<?php
namespace JWTPOC\Resources\Settings\Persistence;

use JWTPOC\Resources\Settings\Domain\Models\Item;
use JWTPOC\Resources\Settings\Domain\Factory;

class Repository
{
    /** @var GatewayInterface */
    protected $gateway;

    /** @var Factory */
    protected $factory;

    /**
     * Settings constructor.
     *
     * @param GatewayInterface $gateway
     * @param Factory $factory
     */
    public function __construct(GatewayInterface $gateway, Factory $factory)
    {
        $this->gateway = $gateway;
        $this->factory = $factory;
    }

    /**
     * @param string $name
     * @return Item|null
     */
    public function findByName($name)
    {
        $entries = $this->gateway->all();

        foreach ($entries as $entry) {
            if ($entry->name === $name) {
                return $this->factory->buildSettingsItem(
                    $entry->name,
                    $entry->description,
                    $entry->value
                );
            }
        }
    }
}
