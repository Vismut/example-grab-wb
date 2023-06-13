<?php

namespace Src\Models\Graber;

use Src\Models\Api\WB\Product;

class WB
{
    public $products = [];

    public function addProduct(int $id, string $name): void
    {
        $product = new Product($id, $name);

        if (!isset($this->products[spl_object_hash($product)])) {
            $this->products[spl_object_hash($product)] = $product;
        } else {
            throw new \Exception('duplicate object with id: ' . $id . ' and name: ' . $name);
        }
    }
}