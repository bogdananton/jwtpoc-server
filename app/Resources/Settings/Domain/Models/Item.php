<?php
namespace JWTPOC\Resources\Settings\Domain\Models;

class Item
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $description;

    /** @var  string */
    protected $value;

    /** @var  bool */
    protected $isPublic;

    public function __construct($name, $description, $value, $isPublic)
    {
        $this->name = $name;
        $this->description = $description;
        $this->value = $value;
        $this->isPublic = $isPublic;
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

    public function isPublic()
    {
        return $this->isPublic;
    }
}
