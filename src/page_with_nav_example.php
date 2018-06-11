<?php
/**
 * Created by PhpStorm.
 * User: kilianchollet
 * Date: 11/06/2018
 * Time: 10:00
 */

require_once("../_lib/vendor/autoload.php");

$loader = new \Twig_Loader_Filesystem(__DIR__ . "/..");
$twig = new \Twig_Environment($loader);

// Set a title
$message = "It works !";

echo $twig->render('twig/pages/nav-example.html.twig', [
    'title' => 'Authentification',
    'connected' => true
]);