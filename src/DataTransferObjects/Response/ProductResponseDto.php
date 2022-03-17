<?php


namespace App\DataTransferObjects\Response;

use JMS\Serializer\Annotation as Serialization;

class ProductResponseDto
{
    /**
     * @Serialization\Type("string")
     */
    public string $code;

    /**
     * @Serialization\Type("string")
     */
    public string $title;

    /**
     * @Serialization\Type("float")
     */
    public string $price;

    //TODO add Category DTO
}