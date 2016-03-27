<?php
namespace JWTPOC\Resources\Settings\Persistence;

interface GatewayInterface
{
    /**
     * @return array
     */
    public function all();
}