<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    #[Route('/ListerProduit', name: 'listerProduit')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listProduit = $entityManager->getRepository('App\Entity\Produit')->findAll();

        return $this->render('produit/index.html.twig', [
            'controller_name' => 'ProduitController',
            'listProduit' => $listProduit,
        ]);
    }
    /* 
    add
     */

    #[Route('/AjouterProduit', name: 'ajouterProduit')]
    public function addProduit(EntityManagerInterface $entityManager): Response
    {
        $Categorie = $entityManager->getRepository('App\Entity\Categorie')->findAll();
        return $this->render('produit/ajouter.html.twig', [
            'controller_name' => 'ProduitController',
            'listCategorie' => $Categorie,
            
        ]);
    }


    /*  */

    #[Route('/AddProduit', name: 'addProduit')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        if(isset($categorie)) {
            $produit = new Produit();
            $produit->setLibelle($libelle);
            $produit->setStock($stock);
            $Categorie = $entityManager->getRepository('App\Entity\Categorie')->find($categorie);
            $produit->setCategorie($Categorie);
            $entityManager->persist($produit);
            $entityManager->flush();
            $listProduit = $entityManager->getRepository('App\Entity\Produit')->findAll();
            return $this->render('produit/index.html.twig', [
                'controller_name' => 'ProduitController',
                'listProduit' => $listProduit,
            ]);
        }else {
            return $this ->  addProduit($entityManager);
        }
    }
}
