<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 28/06/2018
 * Time: 22:39
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function home(){

        return $this->render('pages/home.html.twig',[
            'title' => 'Home',
            'connected' => true,
            'list' => $this->getDoctrine()->getRepository('App:File')->findAll()
        ]);
    }
}