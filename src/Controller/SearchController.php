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
        
        $sql="select * from file left join user on user.id=file.author_id left join doc_type on doc_type.id=file.type_id where folder_id <> 4 and name LIKE :filtre0";
        $params['filtre0']='%'.$researchTag[0].'%';

        for ($i = 1; $i <count($researchTag) ; $i++) {
            $params['filtre'.$i]='%'.trim($researchTag[$i]).'%';
            $sql=$sql." OR name LIKE :filtre".$i;
        }
        
        for($i = 0; $i <count($researchTag) ; $i++){
            $sql=$sql." OR tags LIKE :filtre".$i;

        }
        
        
        $stmt = $this->getDoctrine()->getManager();
        $stmt=$stmt->getConnection()->prepare($sql);
        $stmt->execute($params);
        $result=$stmt->fetchAll();


        return $this->render('pages/search.html.twig',[
            'title' => "Recherche d'un fichier",
            'connected' => true,
            'listFile' => $result,
            'listFolder' => array(),
            'listWord' => $filtre
            ]);
    }

}