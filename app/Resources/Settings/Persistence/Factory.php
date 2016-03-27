<?php
namespace JWTPOC\Resources\Settings\Persistence;

use JWTPOC\Resources\Settings\Persistence\Models\Item;

class Factory
{
    public function buildItem(
        $name,
        $description,
        $value,
        $type,
        $public,
        $admin,
        $writable
    ) {
        $item = new Item(
            $name,
            $description,
            $value,
            $type,
            $public,
            $admin,
            $writable
        );
        
        return $item;
    }
}
