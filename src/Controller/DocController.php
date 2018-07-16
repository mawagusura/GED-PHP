<?php
/**
 * Created by PhpStorm.
 * User: LUCASMasson
 * Date: 13/07/2018
 * Time: 15:19
 */

namespace App\Controller;


use App\Entity\File;
use App\Entity\Folder;
use App\Form\DocForm;
use App\Form\FolderForm;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocController extends Controller
{

    /**
     * @param int $id
     * @return Response
     */
    public function getDocumentDetails(int $id):Response
    {
        $doc=$this->getDoctrine()->getRepository('App:File')->find($id);
        return $this->render('pages/doc-details.html.twig',array(
            'doc'=>$doc,
            'connected'=> true,
            'title'=>"Document détails",
            'blob' => base64_encode(stream_get_contents($doc->getData()))
        ));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function showDocument(int $id):Response
    {
        $doc =$this->getDoctrine()->getRepository('App:File')->find($id);
        if(!$doc){
            throw new ResourceNotFoundException();
        }
        $file = $doc->getData();

        $response = new StreamedResponse(function () use ($file) {
            echo stream_get_contents($file);
        });

        switch ($doc->getType()->getExtension()) {
            case 'png':
                $response->headers->set('Content-Type', 'image/png');
                $response->headers->set('Content-Disposition', 'inline;filename='.$doc->getName());
                break;
            case 'pdf':
                $response->headers->set('Content-Type', 'application/pdf');
                break;
            case 'jpg':
                $response->headers->set('Content-Type', 'image/jpg');
                $response->headers->set('Content-Disposition', 'inline;filename='.$doc->getName());
                break;
            default:
                break;
        }

        return $response;
    }

    /**
     * @return Response
     */
    public function stats():Response
    {
        $types=$this->getDoctrine()->getRepository('App:DocType')->findAll();
        $value=array();
        $name=array();
        
        for($i=0;$i<count($types);$i++){
            $name[$i]=$types[$i]->getTypeName() . '/' . $types[$i]->getExtension();
        }

        
        
        for($i=0;$i<count($types);$i++) {
           $value[$i]=count($this->getDoctrine()->getRepository('App:File')->findBy(array('type' => $types[$i])));

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
     * @param Request $request
     * @return Response
     */
    public function createDocument(Request $request) :Response
    {
        $doc= new File();
        $form = $this->createForm(DocForm::class,$doc);

        $form->handleRequest($request);

        $rootID = $request->query->get('folderID');
        if($rootID == NULL) {
            $rootID = 1;
        }

        // Si le formulaire est envoyé
        if ($form->isSubmitted() && $form->isValid()) {

            // vérification du formulaire
            $file = $form['data']->getData();
            $extension = $file->guessExtension();
            $type = $this->getDoctrine()->getRepository('App:DocType')->findOneBy(array('extension' =>$extension));

            if (!$extension || !$type) {
                // extension cannot be guessed
                // TODO Throw erreur
                print("Type de fichier non reconnu non reconnu");
            }
            else {
                // on récupère le user
                $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
                $user = $this->getUser();

                $doc->setAuthor($user);
                $doc->setFolder( $this->getDoctrine()->getRepository('App:Folder')->find($rootID));
                $doc->setSize( $file->getSize());
                $doc->setData(file_get_contents($file));
                $doc->setType($type);
                $doc->setName($file->getClientOriginalName());

                // Doctrine persist to base
                $em = $this->getDoctrine()->getManager();
                $em->persist($doc);
                $em->flush();
            }
        }
        else if($form->isSubmitted()){
            throw new \InvalidArgumentException($form->getErrors());
        }
        return $this->redirectToRoute('home', array(
            'folderID' => $rootID
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

        return $this->redirectToRoute('home');
    }


    /**
     * @param int $id
     * @return Response
     */
    public function deleteFolder(int $id): Response
    {
        $folder= $this->getDoctrine()->getRepository('App:Folder')->find($id);
        $folderCorb=$this->getDoctrine()->getRepository('App:Folder')->find(4);
        $folder->setParent($folderCorb);
        $em = $this->getDoctrine()->getManager();
        $em->persist($folder);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createFolder(Request $request) :Response
    {
        $folder = new Folder();
        $form = $this->createForm(FolderForm::class, $folder);

        $form->handleRequest($request);

        $rootID = $request->query->get('folderID');
        if($rootID == NULL) {
            $rootID = 1;
        }

        // Si le formulaire est envoyé
        if ($form->isSubmitted() && $form->isValid()) {

            $folder->setName($form->getData()->getName());


            $parent = $this->getDoctrine()->getRepository('App:Folder')->find($rootID);
            $folder->setParent($parent);

            $em = $this->getDoctrine()->getManager();
            $em->persist($folder);
            $em->flush();

        }
        else if($form->isSubmitted()){
            throw new \InvalidArgumentException($form->getErrors());
        }

        return $this->redirectToRoute('home', array(
            'folderID' => $rootID
        ));

    }
}