<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/ListerUser', name: 'listerUser')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'listUser' => $listUser,
        ]);
    }
/* 
 */
    #[Route('/AjouterUser', name: 'ajouterUser')]
    public function addUser(EntityManagerInterface $entityManager): Response
    {
        $listRole = $entityManager->getRepository('App\Entity\Role')->findAll();
        return $this->render('user/ajouter.html.twig', [
            'controller_name' => 'UserController',
            'listRole' => $listRole,
        ]);
    }


    /* Admin */

    #[Route('/Admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('user/admin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /* 
    user
     */
    #[Route('/User', name: 'user')]
    public function user(): Response
    {
        return $this->render('user/utilisateur.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /*  */

    #[Route('/Adduser', name: 'adduser')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        extract($_POST);
        $user = new User();
        $user -> setNom($nom);
        $user -> setPrenom($prenom);
        $user -> setPassword(md5($password));
        $user -> setEmail($email);
        $roles = $entityManager->getRepository('App\Entity\Role')->find($role);
        $user -> setRole($roles);
        $trouve = false;
        $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
        foreach ($listUser as $value) {
            if($value -> getEmail() == $email) {
                $trouve = true;
                $listRole = $entityManager->getRepository('App\Entity\Role')->findAll();
                return $this->render('user/add.html.twig', [
                    'controller_name' => 'UserController',
                    'listRole' => $listRole,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'password' => $password,
                    'email' => $email,
                    'error' => 'E-mail deja utiliser !',
                ]);
            }
        }
        if(!$trouve) {
            $entityManager->persist($user);
            $entityManager->flush();
            $listUser = $entityManager->getRepository('App\Entity\User')->findAll();
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'listUser' => $listUser,
            ]);
        }
    }

    
}
