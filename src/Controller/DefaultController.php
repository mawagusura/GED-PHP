<?php
/**
 * Created by PhpStorm.
 * User: Amaury
 * Date: 28/06/2018
 * Time: 22:39
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    public function index(){

        $list[] = array("prenom"=>"Kilian", "nom"=>"Chollet", "note"=>6.3);
        $list[] = array("prenom"=>"Lucas", "nom"=>"Masson", "note"=>10.3);
        $list[] = array("prenom"=>"Thomas", "nom"=>"Nouvellon", "note"=>5);
        $list[] = array("prenom"=>"Clément", "nom"=>"Jaworski", "note"=>11);
        $list[] = array("prenom"=>"Amaury / Dieu", "nom"=>"Lucas", "note"=>11.3);

        return $this->render('pages/home.html.twig',[
            'title' => 'Home',
            'connected' => false,
            'list' => $list
        ]);
    }
}