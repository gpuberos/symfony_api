<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    // Déclare de la propriété entityManager
    // entityManager : sert à mapper les identités vers la bdd (récupérer et d'envoyer dans les 2 sens)
    private EntityManagerInterface $entityManager;

    // Déclare le constructeur de la class ProductService qui prend un paramètre
    // de type EntityManagerInterface et initialise une propriété $entityManager
    // Paramètres : c'est quand on définit quand on crée la fonction function(int $param) est typé
    // Arguments : c'est quand on définit quand on utilise la fonction function(3) n'est pas typé
    // entityManager c'est le gestionnaire des entités
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllProducts(): array
    {
        // entityManager est une classe qui a différente méthode qui te permet de jouer avec la base de données
        // On récupère l'entityManager de ce contexte là (l'entityManager de ProductService), et tu récupères le Repository de la classe product et tu récupères tout dans la table correspondante
        // Tu utilises l'entityManager pour récupérer le Repository correspondant à l'entité passé en paramètre et tu récupères toutes les occurences dans la table correspondante.
        return $this->entityManager->getRepository(Product::class)->findAll();
    }

    public function getProduct(int $id): Product
    {
        return $this->entityManager->getRepository(Product::class)->find($id);
    }
    
    public function createProduct(Product $product)
    {
        // Création de la nouvelle instance produit
        $newProduct = new Product;
        // On attribue une valeur nom, prix et description
        $newProduct
            ->setName($product->getName())
            ->setPrice($product->getPrice())
            ->setDescription($product->getDescription());

        $this->entityManager->persist($newProduct);

        $this->entityManager->flush();

        return $newProduct;
    }
}
