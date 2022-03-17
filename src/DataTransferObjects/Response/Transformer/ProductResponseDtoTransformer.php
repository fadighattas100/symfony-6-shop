<?php


namespace App\DataTransferObjects\Response\Transformer;

use App\DataTransferObjects\Response\CustomerResponseDto;
use App\DataTransferObjects\Response\ProductResponseDto;
use App\Entity\Customer;
use App\Entity\Product;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class ProductResponseDtoTransformer extends AbstractResponseDtoTransformer
{

    /**
     * @param $object
     * @return ProductResponseDto
     */
    public function transformFromObject($object): ProductResponseDto
    {
        if (!$object instanceof Product) {
            throw new UnexpectedTypeException($object, \get_class($object));
        }

        $dto = new ProductResponseDto();
        $dto->code = $object->getCode();
        $dto->title = $object->getTitle();
        $dto->price = $object->getPrice();
        return $dto;
    }
}