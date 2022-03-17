<?php


namespace App\DataTransferObjects\Response\Transformer;

use App\DataTransferObjects\Response\CustomerResponseDto;
use App\Entity\Customer;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class CustomerResponseDtoTransformer extends AbstractResponseDtoTransformer
{

    /**
     * @param $object
     * @return CustomerResponseDto
     */
    public function transformFromObject($object): CustomerResponseDto
    {
        if (!$object instanceof Customer) {
            throw new UnexpectedTypeException($object, \get_class($object));
        }

        $dto = new CustomerResponseDto();
        $dto->name = $object->getName();
        $dto->email = $object->getEmail();
        $dto->phoneNumber = $object->getPhoneNumber();

        return $dto;
    }
}