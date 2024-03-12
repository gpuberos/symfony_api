<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Product;
        $product->setName('The Witcher');
        $product->setPrice(7.99);
        $product->setDescription('Incarnez le sorceleur Geralt de Riv, le légendaire tueur de monstre, happé dans une mystérieuse toile tissée par les forces luttant pour contrôler le monde. Prenez des décisions difficiles et assumez leurs conséquences dans un jeu qui vous plongera dans une aventure exceptionnelle.');

        $entityManager->persist($product);

        $entityManager->flush();

        return new Response("Saved new product with id: {$product->getId()}");
    }
}
