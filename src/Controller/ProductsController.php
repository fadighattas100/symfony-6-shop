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

#[Route('/products')]
class ProductsController extends AbstractApiController
{
    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;
    private ProductManagerInterface $productManager;

    #[Pure] public function __construct(
        ProductRepository $productRepository,
        ProductRequestDtoTransformer $productRequestDtoTransformer,
        ProductResponseDtoTransformer $productResponseDtoTransformer,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        ProductManagerInterface $productManager
    )
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->productManager = $productManager;

        parent::__construct(
            $serializer,
            $validator,
            $productRequestDtoTransformer,
            $productResponseDtoTransformer
        );
    }

    #[Route(name: 'app_products_index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $products = $this->productRepository->findAll();

        //TODO make better error handler
        return new JsonResponse(
            $this->responseDtoTransformerInterface->transformFromObjects($products),
            Response::HTTP_OK
        );
    }

    #[Route(name: 'app_products_new', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {

        //Get the data form the request
        /** @var ProductRequestDto $productsRequestDto */
        $productsRequestDto = $this->serializer->deserialize(
            $request->getContent(),
            ProductRequestDto::class,
            JsonEncoder::FORMAT,
            ['groups' => ['product:w']]
        );

        $product = $this->requestDtoTransformerInterface->transformFromObject($productsRequestDto);

        //Validate data by Entity constraints constraints annotation
        $violations = $this->validator->validate($product, null, 'product:c');

        //if there some error just give the first one,
        //TODO make better error handler
        if ($violations->count() > 0) {
            $firstViolation = $violations->get(0);
            return new JsonResponse(
                ['errors' => [[$firstViolation->getPropertyPath() => [$firstViolation->getMessage()]]]],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->productRepository->add($product);

        //TODO make better response handler
        return new JsonResponse(
            $this->responseDtoTransformerInterface->transformFromObject($product),
            Response::HTTP_CREATED
        );
    }

    #[Route('/{id}', name: 'app_products_show', requirements: ["id" => "\d+"], methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        //TODO make better response handler
        return new JsonResponse(
            $this->responseDtoTransformerInterface->transformFromObject($product),
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'app_products_edit', methods: ['PUT'])]
    public function edit(Request $request, Product $product): JsonResponse
    {
        //Get the data form the request
        /** @var ProductRequestDto $productsRequestDto */
        $productsRequestDto = $this->serializer->deserialize(
            $request->getContent(),
            ProductRequestDto::class,
            JsonEncoder::FORMAT,
            ['groups' => ['product:w']]
        );

        $newProduct = $this->requestDtoTransformerInterface->transformFromObject($productsRequestDto);

        //Validate data by Entity constraints constraints annotation
        $violations = $this->validator->validate($newProduct);

        //if there some error just give the first one,
        //TODO make better error handler
        if ($violations->count() > 0) {
            $firstViolation = $violations->get(0);
            return new JsonResponse(
                ['errors' => [[$firstViolation->getPropertyPath() => [$firstViolation->getMessage()]]]],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->productManager->updateProduct($product, $newProduct);
        $this->entityManager->flush();

        //TODO make better response handler
        return new JsonResponse(
            $this->responseDtoTransformerInterface->transformFromObject($product),
            Response::HTTP_OK
        );
    }

    #[Route('/{id}', name: 'app_products_delete', methods: ['DELETE'])]
    public function delete(Request $request, Product $product): JsonResponse
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        //TODO make better response handler
        return new JsonResponse(
            [],
            Response::HTTP_NO_CONTENT
        );
    }
}
