<?php

namespace App\Controller;

use App\DataTransferObjects\Response\Transformer\CustomerResponseDtoTransformer;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/customers')]
class CustomersController extends AbstractApiController
{
    private CustomerRepository $customerRepository;
    private CustomerResponseDtoTransformer $customerResponseDtoTransformer;

    /**
     * CustomersController constructor.
     *
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param CustomerRepository $customerRepository
     * @param CustomerResponseDtoTransformer $customerResponseDtoTransformer
     */
    #[Pure] public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        CustomerRepository $customerRepository,
        CustomerResponseDtoTransformer $customerResponseDtoTransformer
    )
    {

        $this->customerRepository = $customerRepository;
        $this->customerResponseDtoTransformer = $customerResponseDtoTransformer;

        parent::__construct($serializer, $validator);
    }

    #[Route(name: 'get.customers', methods: ['GET'])]
    public function index(
        CustomerRepository $customerRepository
    ): Response
    {
        $customers = $this->customerRepository->findAll();

        $customersDto = $this->customerResponseDtoTransformer->transformFromObjects($customers);

        return new JsonResponse($customersDto, Response::HTTP_OK);
    }

    #[Route(name: 'create.customers', methods: ['POST'])]
    public function create(
        Request $request,
    ): Response
    {
        //Get the data form the request
        /** @var Customer $customer */
        $customer = $this->serializer->deserialize(
            $request->getContent(),
            Customer::class,
            'json',
            ['groups' => ['customer:w']]
        );

        //Validate data by Entity constraints constraints annotation
        $violations = $this->validator->validate($customer);

        //if there some error just give the first one,
        //TODO make better error handler
        if ($violations->count() > 0) {
            $firstViolation = $violations->get(0);
            return new JsonResponse(
                ['errors' => [[$firstViolation->getPropertyPath() => [$firstViolation->getMessage()]]]],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->customerRepository->add($customer);

        $customerDto = $this->customerResponseDtoTransformer->transformFromObject($customer);

        //TODO make better response handler
        return new JsonResponse($customerDto, Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_customers_show', methods: ['GET'])]
    public function show(Customer $customer): Response
    {
        return $this->render('customers/show.html.twig', [
            'customer' => $customer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_customers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Customer $customer, CustomerRepository $customerRepository): Response
    {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customerRepository->add($customer);
            return $this->redirectToRoute('app_customers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('customers/edit.html.twig', [
            'customer' => $customer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_customers_delete', methods: ['POST'])]
    public function delete(Request $request, Customer $customer, CustomerRepository $customerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $customer->getId(), $request->request->get('_token'))) {
            $customerRepository->remove($customer);
        }

        return $this->redirectToRoute('app_customers_index', [], Response::HTTP_SEE_OTHER);
    }
}
