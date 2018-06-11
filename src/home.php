<?php
/**
 * Created by PhpStorm.
 * User: kilianchollet
 * Date: 11/06/2018
 * Time: 10:00
 */

require_once("../_lib/vendor/autoload.php");

$loader = new \Twig_Loader_Filesystem(__DIR__.'/..');
$twig = new \Twig_Environment($loader);

// Set a title
$message = "It works !";

$list[] = array("prenom"=>"Kilian", "nom"=>"Chollet", "note"=>6.3);
$list[] = array("prenom"=>"Lucas", "nom"=>"Masson", "note"=>10.3);
$list[] = array("prenom"=>"Thomas", "nom"=>"Nouvellon", "note"=>5);
$list[] = array("prenom"=>"Clément", "nom"=>"Jaworski", "note"=>11);
$list[] = array("prenom"=>"Amaury / Dieu", "nom"=>"Lucas", "note"=>11.3);


//, "5/20", "Clément", "Dieu"];

echo $twig->render('./twig/pages/home.twig', [
    'title' => 'Home',
    'connected' => false,
    'list' => $list
]);