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
        $researchTag=preg_split("/[\s,]+/",$filtre);
        
        for ($i = 0; $i <count($researchTag) ; $i++) {
            print(' '.$researchTag[$i]);
            $params['test'.$i]='%'.$researchTag[$i].'%';
        }
        print_r($params);
        $sql="select * from doc where doc_name LIKE :test"."0 ". "or doc_name LIKE :test1";
        
        
        
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