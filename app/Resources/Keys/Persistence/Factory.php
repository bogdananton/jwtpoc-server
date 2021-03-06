<?php
namespace JWTPOC\Resources\Keys\Persistence;

use JWTPOC\Resources\Keys\Persistence\Models\Item;
use JWTPOC\Resources\Keys\Persistence\Models\Collection;

class Factory
{
    public function buildItem(
        $name,
        $file,
        $alg,
        $bits,
        $created_at,
        $expires_at
    ) {
        $item = new Item(
            $name,
            $file,
            $alg,
            $bits,
            $created_at,
            $expires_at
        );

        return $item;
    }

    public function buildCollection($entries = [])
    {
        return new Collection($entries);
    }
}
