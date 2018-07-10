<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SearchController extends AbstractController
{
    public function search(AuthenticationUtils $helper): Response
    {
        return $this->render('pages/search.html.twig',[
            'title' => "Recherche d'un fichier",
            'connected' => true,
            'fichiers' => 'aucune recherche'
            ]);
    }
    public function displayResearch(): Response
    {
        return $this->render('pages/search.html.twig',[
            'title' => "Recherche d'un fichier",
            'connected' => true,
            'fichiers' => 'recherche en cours'
            ]);
    }

}