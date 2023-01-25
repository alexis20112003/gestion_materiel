<?php
require_once '../vendor/autoload.php';

$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

session_start();


if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    header('Location: Main.php');
    exit;
} else {
    echo $twig->render('header.html.twig') . $twig->render('pageAccueil.html.twig');
}
