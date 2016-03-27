<?php
namespace JWTPOC\Resources\Settings\Domain\Models;

class Item
{
    protected $name;
    protected $value;

    public function __construct($name, $description, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }
}
