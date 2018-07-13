<?php
/**
 * Created by PhpStorm.
 * User: LUCASMasson
 * Date: 13/07/2018
 * Time: 15:19
 */

namespace App\Controller;


use App\Entity\Docs;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocController extends Controller
{

    /**
     * @Route("/doc/details/{id}",name="doc_details")
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

    /**
     * @return Response
     */
    public function getStatsDocument():Response
    {
        $types=$this->getDoctrine()->getRepository('AppBundle:DocTypes')->findAll();
        $res=array(count($types));
        for($i=0;$i<count($types);$i++){
            array_push($res,$types[$i]->getTypeName(),count($this->getDoctrine()->getRepository('AppBundle:Docs')->findBy(array('$doc_doc_type_id'=>$types($i)->getTypeId()))));
        }
        $docs=$this->getDoctrine()->getRepository('AppBundle:Docs')->findAll();
        $sizeTotal=0;
        foreach($docs as $doc){
            $sizeTotal=$doc->getDocSize();
        }
        return $this->render('view',array(
            'sizeTotal'=>$sizeTotal,
            'typeFile'=>$res
        ));
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function createDocument(Request $request):Response
    {
        $doc=new Docs();
        $form = $this->createForm(UserType::class,$doc);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($doc);
            $em->flush();
        }


    }
}