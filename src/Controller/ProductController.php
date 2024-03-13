<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/v1/products')]
class ProductController extends AbstractController
{
    private ProductService $productService;
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->productService = new ProductService($entityManager);
        $this->serializer = $serializer;
    }

    #[Route(name: "get_all_products", methods: ['GET'])]
    public function getAllProducts()
    {
        return new Response($this->serializer->serialize($this->productService->getAllProducts(), 'json'));
    }

    #[Route('/{id}', name: "get_product", methods: ['GET'])]
    public function getProduct(int $id)
    {
        return new Response($this->serializer->serialize($this->productService->getProduct($id), 'json'));
    }

    #[Route(name: "add_product", methods: ['POST'])]
    public function createProduct(#[MapRequestPayload] Product $product): Response
    {
        return new Response($this->serializer->serialize($this->productService->createProduct($product), 'json'));
    }

    #[Route('/{id}', name: "delete_product", methods: ['DELETE'])]
    public function deleteProduct(int $id): Response
    {
        $message = $this->productService->deleteProduct($id);
        return new Response($message);
    }

    #[Route("/{id}", name: "put_product", methods: ['PUT'])]
    public function putProduct(int $id, #[MapRequestPayload] Product $product): Response
    {
        $message = $this->productService->putProduct($id, $product);
        return new Response($message);
    }

    #[Route("/{id}", name: "patch_product", methods: ['PATCH'])]
    public function patchProduct(int $id, #[MapRequestPayload] Product $product): Response
    {
        $message = $this->productService->patchProduct($id, $product);
        return new Response($message);
    }
}
