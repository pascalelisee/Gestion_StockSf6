<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SortieController extends AbstractController
{
    #[Route('/ListerSortie', name: 'listerSortie')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listSortie = $entityManager->getRepository('App\Entity\Sortie')->findAll();

        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
            'listSortie' => $listSortie,
            
        ]);
    }
    /* add
     */

    #[Route('/AjouterSortie', name: 'ajouterSortie')]
    public function addSortie(EntityManagerInterface $entityManager): Response
    {
        $produit = $entityManager->getRepository('App\Entity\Produit')->findAll();

        return $this->render('sortie/ajouter.html.twig', [
            'controller_name' => 'SortieController',
            'listProduit' => $produit,
        ]);
    }

    /*  */

     /*  */

     #[Route('/AddSortie', name: 'addSortie')]
     public function add(EntityManagerInterface $entityManager): Response
     {
         extract($_POST);
         if(isset($product)) {
             $sortie = new Sortie();
             $sortie->setQuantite($quantite);

            // $entree = $entityManager->getRepository('App\Entity\Entree')->findAll();

            // $sortie->setPrix($entree->getPrix()*$quantite);
             $sortie->setPrix($prix);
             $sortie->setDate($date);
             $produit = $entityManager->getRepository('App\Entity\Produit')->find($product);
             $sortie->setProduit($produit);
             $entityManager->persist($sortie);
             $entityManager->flush();
             //produit
             $produit->setStock( $produit ->getStock()-$quantite);
             $entityManager->persist($produit);
             $entityManager->flush();
             $listSortie = $entityManager->getRepository('App\Entity\Sortie')->findAll();
             return $this->render('sortie/index.html.twig', [
                 'controller_name' => 'SortieController',
                 'listSortie' => $listSortie,
             ]);
         }else {
             return $this ->  addSortie($entityManager);
         }
     }
}
