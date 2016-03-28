<?php
namespace JWTPOC\Contracts\Clients;

interface Gateway
{
    /**
     * @return Item[]
     */
    public function all();
}