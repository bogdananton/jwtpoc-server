<?php
namespace JWTPOC\Contracts\Settings;

use JWTPOC\Resources\Settings\Persistence\Models\Item;

interface Gateway
{
    /**
     * @return Item[]
     */
    public function all();
}
