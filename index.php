<?php
require_once("./_lib/vendor/autoload.php");
$loader = new \Twig_Loader_Filesystem(__DIR__.'/templates');
$twig = new \Twig_Environment($loader);
echo $twig->render('index.twig', ['name' => "hello world"]);
