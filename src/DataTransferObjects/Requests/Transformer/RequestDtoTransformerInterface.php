<?php


namespace App\DataTransferObjects\Requests\Transformer;


interface RequestDtoTransformerInterface
{
    public function transformFromObject($object);

    public function transformFromObjects(iterable $objects): iterable;
}