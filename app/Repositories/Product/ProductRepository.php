<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::find($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return true;
    }
}
