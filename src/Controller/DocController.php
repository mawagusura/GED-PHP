<?php
/**
 * Created by PhpStorm.
 * User: LUCASMasson
 * Date: 13/07/2018
 * Time: 15:19
 */

namespace App\Controller;


use App\Entity\File;
use App\Form\DocForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
        $doc=$this->getDoctrine()->getRepository('AppBundle:Doc')->find($id);
        return $this->render('pages/doc-details.html.twig',array(
            'doc'=>$doc
        ));
    }

    /**
     * @return Response
     */
    public function getStatsDocument():Response
    {
        $types=$this->getDoctrine()->getRepository('AppBundle:DocType')->findAll();
        $res=array(count($types));
        for($i=0;$i<count($types);$i++){
            array_push($res,$types[$i]->getTypeName(),count($this->getDoctrine()->getRepository('AppBundle:Doc')->findBy(array('$doc_doc_type_id'=>$types($i)->getTypeId()))));
        }
        $docs=$this->getDoctrine()->getRepository('AppBundle:Doc')->findAll();
        $sizeTotal=0;
        foreach($docs as $doc){
            $sizeTotal+=$doc->getSize();
        }
        return $this->render('pages/stats.html.twig',array(
            'sizeTotal'=>$sizeTotal,
            'typeFile'=>$res
        ));
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function createDocument(Request $request) :Response
    {
        $doc= new File();
        $form = $this->createForm(DocForm::class,$doc);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($doc);
            $em->flush();
        }

        return $this->redirectToRoute('doc_details');
    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteDocument(int $id): Response
    {
        $doc = $this->getDoctrine()->getRepository('AppBundle:Doc')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($doc);
        $em->flush();
        return $this->redirectToRoute('pages/search.html.twig');
    }
}