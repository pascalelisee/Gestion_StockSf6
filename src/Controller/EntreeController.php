<?php

namespace App\Controller;

use App\Entity\Entree;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EntreeController extends AbstractController
{
    #[Route('/ListerEntree', name: 'listeEntree')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listEntree = $entityManager->getRepository('App\Entity\Entree')->findAll();
        return $this->render('entree/index.html.twig', [
            'controller_name' => 'EntreeController',
            'listEntree' => $listEntree,
       
        ]);
    }

    /* add
     */
    #[Route('/AjouterEntree', name: 'ajouterEntree')]
    public function addEntree(EntityManagerInterface $entityManager): Response
    {
        $produit = $entityManager->getRepository('App\Entity\Produit')->findAll();

        return $this->render('entree/ajouter.html.twig', [
            'controller_name' => 'EntreeController',
            'listProduit' => $produit,
        ]);
    }

    /*  */

    #[Route('/AddEntree', name: 'addEntree')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        if(isset($product)) {
            $entree = new Entree();
            $entree->setQuantite($quantite);
            $entree->setPrix($prix);
            $entree->setDate($date);
            $produit = $entityManager->getRepository('App\Entity\Produit')->find($product);
            $entree->setProduit($produit);
            $entityManager->persist($entree);
            $entityManager->flush();
            //produit
            $produit->setStock($quantite + $produit->getStock());
            $entityManager->persist($produit);
            $entityManager->flush();
            $listEntree = $entityManager->getRepository('App\Entity\Entree')->findAll();
            return $this->render('entree/index.html.twig', [
                'controller_name' => 'EntreeController',
                'listEntree' => $listEntree,
            ]);
        }else {
            return $this ->  addEntree($entityManager);
        }
    }
}
