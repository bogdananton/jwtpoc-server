<?php
namespace JWTPOC\Resources\Clients\Persistence;

use JWTPOC\Resources\Clients\Persistence\Models\Item;
use JWTPOC\Resources\Clients\Persistence\Models\Collection;

class Factory
{
    public function buildItem(
        $name,
        $description,
        $callbackUrl
    ) {
        $item = new Item(
            $name,
            $description,
            $callbackUrl
        );
        
        return $item;
    }

    public function buildCollection($entries = [])
    {
        return new Collection($entries);
    }
}
