<?php
namespace JWTPOC\Resources\Keys\Presentation;

use JWTPOC\Resources\Keys\Presentation\Models\Item;
use JWTPOC\Resources\Keys\Presentation\Models\Collection;

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
