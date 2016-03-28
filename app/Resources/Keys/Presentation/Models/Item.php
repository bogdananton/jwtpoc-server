<?php
namespace JWTPOC\Resources\Keys\Presentation\Models;

class Item
{
    protected $name;
    protected $file;
    protected $alg;
    protected $bits;
    protected $created_at;
    protected $expires_at;

    public function __construct(
        $name,
        $file,
        $alg,
        $bits,
        $created_at,
        $expires_at
    ) {
        $this->name = $name;
        $this->file = $file;
        $this->alg = $alg;
        $this->bits = $bits;
        $this->created_at = $created_at;
        $this->expires_at = $expires_at;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getAlg()
    {
        return $this->alg;
    }

    public function getBits()
    {
        return $this->bits;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function getExpires_at()
    {
        return $this->expires_at;
    }
}
