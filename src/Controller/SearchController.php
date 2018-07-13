<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
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
    public function displayResearch(Request $req): Response
    {

        
        $filtre=$req->request->get('filtre');
        print_r($filtre);


        $sql="select * from doc where doc_name LIKE :doc_name;";
        $params['doc_name'] ='%'.$filtre.'%';
        $stmt = $this->getDoctrine()->getManager();
        $stmt=$stmt->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result=$stmt->fetchAll();
        print_r($result);
        return $this->render('pages/search.html.twig',[
            'title' => "Recherche d'un fichier",
            'connected' => true,
            'fichiers' => 'recherche en cours'
            ]);
    }

}