<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 09/07/2018
 * Time: 15:32
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function login(AuthenticationUtils $helper) : Response
    {
        return $this->render('pages/login.html.twig', [
            'title' => "Connexion",
            "connected" => false,
            // dernier username saisi (si il y en a un)
            'last_username' => $helper->getLastUsername(),
            // La derniere erreur de connexion (si il y en a une)
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * Should never be reached
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}