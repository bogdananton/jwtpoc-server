<?php
namespace JWTPOC\Resources\Settings\Presentation;

use JWTPOC\Resources\Settings\Presentation\Models\Collection;
use JWTPOC\Resources\Settings\Presentation\Models\Item;

class Factory
{
    /**
     * @param string $name
     * @param string $description
     * @param string $value
     * @return Item
     */
    public function buildItem($name, $description, $value)
    {
        return new Item($name, $description, $value);
    }
    
    public function buildCollection($entries = [])
    {
        return new Collection($entries);
    }
}
