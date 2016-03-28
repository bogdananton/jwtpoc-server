<?php
namespace JWTPOC\Resources\Clients\Persistence\Models;

class Item
{
    /** @var  string */
    protected $name;

    /** @var  string */
    protected $description;

    /** @var  string */
    protected $callbackUrl;

    public function __construct(
        $name,
        $description,
        $callbackUrl
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->callbackUrl = $callbackUrl;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }
}
