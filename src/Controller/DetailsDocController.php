<?php
/**
 * Created by PhpStorm.
 * User: LUCASMasson
 * Date: 13/07/2018
 * Time: 15:19
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DetailsDocController extends Controller
{

    /**
     * @Route("/doc/{id}",name="doc_details")
     * @param int $id
     * @return Response
     */
    public function getDocumentDetails(int $id):Response
    {
        $doc=$this->getDoctrine()->getRepository('AppBundle:Docs')->find($id);
        $doc_type=$this->getDoctrine()->getRepository('AppBundle:DocTypes')->find($doc->getDocDocTypeId());
        $doc_dos=$this->getDoctrine()->getRepository('AppBundle:Dossier')->find($doc->getDocDosId());
        $user=$this->getDoctrine()->getRepository('AppBundle:Dossier')->find($doc->getDocUserId());
        return $this->render('view',array(
            'doc'=>$doc,
            'type'=>$doc_type->getTypeName(),
            'dossier'=>$doc_dos->getDosName(),
            'username'=>$user->getUsername()
        ));
    }

}