<?php
namespace JWTPOC\Resources\Clients\Persistence\Models;


class Collection extends \Illuminate\Support\Collection
{
    public function toArray()
    {
        return $this->map(function (Item $item) {
            return $item->toArray();
        });
    }
}
