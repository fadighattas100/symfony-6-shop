<?php


namespace App\DataTransferObjects\Response\Transformer;


interface ResponseDtoTransformerInterface
{
    public function transformFromObject($object);

    public function transformFromObjects(iterable $objects): iterable;
}