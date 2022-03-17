<?php

namespace App\Controller;

use App\Entity\Product;

use JetBrains\PhpStorm\Pure;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use App\DataTransferObjects\Requests\ProductRequestDto;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\DataTransferObjects\Requests\Transformer\ProductRequestDtoTransformer;
use App\DataTransferObjects\Response\Transformer\ProductResponseDtoTransformer;
use App\Services\EntityServices\ProductsEntityManagerServices\ProductManagerInterface;

#[Route('/products/page')]
class ProductsDataGridController extends AbstractApiController
{
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;

    #[Pure] public function __construct(
        ProductRepository $productRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        ProductManagerInterface $productManager
    )
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;

        parent::__construct(
            $serializer,
            $validator,
        );
    }

    #[Route(name: 'app_products_page_index', methods: ['GET'])]
    public function indexx(Request $request): JsonResponse
    {
        $products = $this->productRepository->findProducts(1, 2);

//        dd($products);
//        //TODO make better error handler
//        return new JsonResponse(
//            $this->responseDtoTransformerInterface->transformFromObjects($products),
//            Response::HTTP_OK
//        );
    }
}
