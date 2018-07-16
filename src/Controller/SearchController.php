<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SearchController extends Controller
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
        $researchTag=preg_split("/[,]+/",$filtre);


        
        $result = $this->getDoctrine()->getRepository("App:File")->createQueryBuilder('c')
            ->orWhere('c.name LIKE :filtre0')
            ->orWhere('c.tags LIKE :filtre0');
            

        $params['filtre0']='%'.$researchTag[0].'%';

        for ($i = 1; $i <count($researchTag) ; $i++) {
            $params['filtre'.$i]='%'.$researchTag[$i].'%';
            $result = $result->orWhere('c.name LIKE :filtre'.$i)
                ->orWhere('c.tags LIKE :filtre'.$i);
                
            
        }
        $result = $result->andWhere('c.folder <>4');
        
        for($i = 0; $i <count($researchTag) ; $i++){
            $result = $result->setParameter('filtre'.$i, $params['filtre'.$i]);

        }
        $result = $result->getQuery()
            ->getResult();
        
        


        return $this->render('pages/search.html.twig',[
            'title' => "Recherche d'un fichier",
            'connected' => true,
            'listFile' => $result,
            'listFolder' => array(),
            'listWord' => $filtre
            ]);
    }

}