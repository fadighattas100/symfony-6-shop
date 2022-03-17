<?php


namespace App\DataTransferObjects\Requests;

use Symfony\Component\Serializer\Annotation\Groups;

class ProductRequestDto
{
    #[Groups(["product:r", "product:w"])]
    public ?string $code = null;

    #[Groups(["product:r", "product:w"])]
    public ?string $title = null;

    #[Groups(["product:r", "product:w"])]
    public ?float $price = null;

    #[Groups(["product:r", "product:w"])]
    public ?int $category_id = null;
}