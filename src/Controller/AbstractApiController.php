<?php


namespace App\Controller;

use App\DataTransferObjects\Requests\Transformer\RequestDtoTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DataTransferObjects\Response\Transformer\ResponseDtoTransformerInterface;

abstract class AbstractApiController extends AbstractController
{
    protected SerializerInterface $serializer;
    protected ValidatorInterface $validator;
    protected ?RequestDtoTransformerInterface $requestDtoTransformerInterface;
    protected ?ResponseDtoTransformerInterface $responseDtoTransformerInterface;

    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ?RequestDtoTransformerInterface $requestDtoTransformerInterface = null,
        ?ResponseDtoTransformerInterface $responseDtoTransformerInterface = null,
    )
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->requestDtoTransformerInterface = $requestDtoTransformerInterface;
        $this->responseDtoTransformerInterface = $responseDtoTransformerInterface;
    }

}