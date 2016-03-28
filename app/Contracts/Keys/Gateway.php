<?php
namespace JWTPOC\Contracts\Keys;

interface Gateway
{
    /**
     * @return string
     */
    public function getContents($filename);

    /**
     * @param $name
     * @return Key[]
     */
    public function getByOwner($name);
}
