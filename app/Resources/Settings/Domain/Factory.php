<?php
namespace JWTPOC\Resources\Settings\Domain;

use JWTPOC\Resources\Settings\Domain\Models\Item;

class Factory
{
    /**
     * @param string $name
     * @param string $description
     * @param string $value
     * @return Item
     */
    public function buildSettingsItem($name, $description, $value)
    {
        // @todo convert input to attributes before building
        $item = new Item($name, $description, $value);

        return $item;
    }
}