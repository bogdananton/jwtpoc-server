<?php
namespace JWTPOC\Resources\Keys\Presentation\Models;


class Collection extends \Illuminate\Support\Collection
{
    public function toArray()
    {
        return $this->map(function (Item $item) {
            return $item->toArray();
        });
    }
}
