<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/ListerCategorie', name: 'listerCategorie')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listCategorie = $entityManager->getRepository('App\Entity\Categorie')->findAll();

        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'listCategorie' => $listCategorie,
        ]);
    }

    /* add
     */

    #[Route('/AjouterCategorie', name: 'ajouterCategorie')]
    public function addCategorie(): Response
    {

        return $this->render('categorie/ajouter.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }


    /*  */

    #[Route('/Addcategorie', name: 'addcategorie')]
    public function add(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        $categorie = new Categorie();
        $categorie -> setNom($nom);
        $entityManager->persist($categorie);
        $entityManager->flush();
        $listCategorie = $entityManager->getRepository('App\Entity\Categorie')->findAll();
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'listCategorie' => $listCategorie,
        ]);
    }
}
