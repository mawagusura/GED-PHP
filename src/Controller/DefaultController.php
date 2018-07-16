<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 28/06/2018
 * Time: 22:39
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    public function index()
    {
        return $this->render('pages/index.html.twig', [
        'title' => "Accueil GED"
        ]);
    }

    /**
     * @return Response
     */
    public function home(Request $request){

        $rootID = $request->query->get('folderID');
        if($rootID == NULL) {
            $rootID = 1;
        }
        $root = $this->getDoctrine()->getRepository('App:Folder')->find($rootID);

        // Fetch the list of the parents
        $parents = $root->getAllParents();

        // Fetch all files and directories
        $folders = $root->getChildrens();
        $files = $root->getFiles();

        return $this->render('pages/home.html.twig',[
            'title' => 'Navigation',
            'connected' => true,
            'root_folder' => $root,
            'parents' => $parents,
            'listFolder'=> $folders,
            'listFile' => $files
        ]);
    }
}