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
        
        $sql="select * from doc where doc_name LIKE :filtre0";
        $params['filtre0']='%'.$researchTag[0].'%';

        for ($i = 1; $i <count($researchTag) ; $i++) {
            print(' '.$researchTag[$i]);
            $params['filtre'.$i]='%'.$researchTag[$i].'%';
            $sql=$sql." OR doc_name LIKE :filtre".$i;
        }
        print_r($params);
        
        for($i = 0; $i <count($researchTag) ; $i++){
            $sql=$sql." OR doc_tags LIKE :filtre".$i;

        }
        
        
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