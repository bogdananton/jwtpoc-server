<?php
namespace JWTPOC\Resources\Settings\Presentation\Models;

class Item
{
    protected $name;
    protected $description;
    protected $value;

    public function __construct($name, $description, $value)
    {
        $this->name = $name;
        $this->description = $description;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'value' => $this->getValue(),
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
