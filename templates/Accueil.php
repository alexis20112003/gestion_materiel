<?php
require_once '../vendor/autoload.php';

$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

echo $twig->render('pageAccueil.html.twig').$twig->render('header.html.twig');
