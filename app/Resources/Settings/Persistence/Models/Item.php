<?php
namespace JWTPOC\Resources\Settings\Persistence\Models;

class Item
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $description;

    /** @var  string */
    protected $value;

    /** @var  string */
    protected $type;

    /** @var  bool */
    protected $isPublic;

    /** @var  bool */
    protected $isAdmin;

    /** @var  bool */
    protected $isWritable;

    public function __construct(
        $name,
        $description,
        $value,
        $type,
        $public,
        $admin,
        $writable
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->value = $value;
        $this->type = $type;
        $this->isPublic = $public;
        $this->isAdmin = $admin;
        $this->isWritable = $writable;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isPublic()
    {
        return $this->isPublic;
    }

    public function isKey()
    {
        return ($this->getType() == 'pub' || $this->getType() == 'prv');
    }
}
