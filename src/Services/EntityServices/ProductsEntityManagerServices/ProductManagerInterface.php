<?php


namespace App\Services\EntityServices\ProductsEntityManagerServices;


use App\Entity\Product;

interface ProductManagerInterface
{
    /**
     * @param Product $product
     * @param Product $newProduct
     *
     * @return Product
     */
    public function updateProduct(Product $product, Product $newProduct): Product;
}