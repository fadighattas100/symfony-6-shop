<?php


namespace App\DataTransferObjects\Response;

use JMS\Serializer\Annotation as Serialization;

class CustomerResponseDto
{
    /**
     * @Serialization\Type("string")
     */
    public string $name;

    /**
     * @Serialization\Type("string")
     */
    public string $email;

    /**
     * @Serialization\Type("string")
     */
    public string $phoneNumber;
}