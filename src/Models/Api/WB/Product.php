<?php

namespace Src\Models\Api\WB;

class Product
{
    public $id;

    public $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}