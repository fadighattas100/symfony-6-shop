<?php


namespace App\Services\EntityServices\ProductsEntityManagerServices;


use App\Entity\Product;

class ProductManager implements ProductManagerInterface
{
    /**
     * @inheritDoc
     */
    public function updateProduct(Product $product, Product $newProduct): Product
    {
        return $product
            ->setCode($newProduct->getCode() ?: $product->getCode()) //not null
            ->setTitle($newProduct->getTitle() ?: $product->getTitle()) //not null
            ->setPrice($newProduct->getPrice() ?: $product->getPrice()) //not null
            ->setCategory($newProduct->getCategory());
    }
}