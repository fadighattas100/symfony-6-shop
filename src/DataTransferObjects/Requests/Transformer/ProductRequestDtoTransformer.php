<?php


namespace App\DataTransferObjects\Requests\Transformer;


use App\DataTransferObjects\Requests\ProductRequestDto;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ProductRequestDtoTransformer extends AbstractRequestDtoTransformer
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $object
     * @return Product
     */
    public function transformFromObject($object): Product
    {
        if (!$object instanceof ProductRequestDto) {
            throw new UnexpectedTypeException($object, \get_class($object));
        }

        $product = new Product();
        $product->setCode($object->code);
        $product->setTitle($object->title);
        $product->setPrice($object->price);

        $product->setCategory($this->categoryRepository->find($object->category_id));

        return $product;
    }
}