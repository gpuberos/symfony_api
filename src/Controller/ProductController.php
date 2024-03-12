<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    private ProductService $productService;
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager)
    {
        $this->productService = new ProductService($entityManager);
        $this->serializer = $serializer;
    }

    #[Route('/api/products', methods: ['GET'])]
    public function getAllProducts()
    {
        return new Response($this->serializer->serialize($this->productService->getAllProducts(), 'json'));
    }

    #[Route('/api/products/{id}', methods: ['GET'])]
    public function getProduct(int $id) {
        return new Response($this->serializer->serialize($this->productService->getProduct($id), 'json'));
    }

    #[Route('/api/products', methods: ['POST'])]
    public function createProduct(#[MapRequestPayload] Product $product): Response
    {
        return new Response($this->serializer->serialize($this->productService->createProduct($product), 'json'));
    }
}
