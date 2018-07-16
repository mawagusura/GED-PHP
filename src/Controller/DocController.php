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
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DocController extends Controller
{

    /**
     * @Route("/doc/details/{id}",name="doc_details")
     * @param int $id
     * @return Response
     */
    public function getDocumentDetails(int $id):Response
    {
        $doc=$this->getDoctrine()->getRepository('App:File')->find($id);
        return $this->render('pages/doc-details.html.twig',array(
            'doc'=>$doc,
            'connected'=> true,
            'title'=>"Details"
        ));
    }

    /**
     * @return Response
     */
    public function stats():Response
    {
        $types=$this->getDoctrine()->getRepository('App:DocType')->findAll();
        $name=array(count($types));
        $value=array(count($types));

        for($i=0;$i<count($types);$i++){
            $name[$i]=$types[$i]->getTypeName();
        }
        for($i=0;$i<count($types);$i++) {
            $value[$i]= count($this->getDoctrine()->getRepository('App:File')->findBy(array('type_id' => $types($i)->getId())));
        }
        $docs=$this->getDoctrine()->getRepository('App:File')->findAll();
        $sizeTotal=0;
        foreach($docs as $doc){
            $sizeTotal+=$doc->getSize();
        }
        return $this->render('pages/stats.html.twig',array(
            'title'=>"Stats",
            'connected'=>true,
            'sizeTotal'=>$sizeTotal,
            'names'=>$name,
            'values'=>$value
        ));
    }


    /**
     * @Route("/doc/create", name="doc_create")
     * @param Request $request
     * @return Response
     */
    public function createDocument(Request $request) :Response
    {
        $doc= new File();
        $form = $this->createForm(DocForm::class,$doc);

        $form->handleRequest($request);

        // Si le formulaire est envoyé
        if ($form->isSubmitted() && $form->isValid()) {

            // vérification du formulaire
            $file = $form['data']->getData();
            $extension = $file->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }

            // on récupère le user
            $securityContext = $this->container->get('security.authorization_checker');
            if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $user = $this->get('security.context')->getToken()->getUser();
                $doc->setAuthor($user);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($doc);
            $em->flush();
        }

        return $this->render('pages/form.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function deleteDocument(int $id): Response
    {
        $doc = $this->getDoctrine()->getRepository('App:File')->find($id);
        $folder=$this->getDoctrine()->getRepository('App:Folder')->find(4);
        $doc->setFolder($folder);
        $em = $this->getDoctrine()->getManager();
        $em->persist($doc);
        $em->flush();
        return $this->render('pages/home.html.twig');
    }
}