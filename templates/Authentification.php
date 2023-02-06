<?php
require_once '../vendor/autoload.php';
require_once('../Entity/Database.php');
require_once('../Entity/User.php');

$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

session_start();


if (isset($_SESSION['id']) and !empty($_SESSION['id'])) {
    header('Location: Main.php');
    exit;
} else if(isset($_SESSION['temp']) and !empty($_SESSION['temp'])){
    $temp = User::encrypt_decrypt('decrypt', $_SESSION['temp']);
    echo $twig->render('header.html.twig') . $twig->render('pageAuthentification.html.twig');
}else {
    echo $twig->render('header.html.twig') . $twig->render('pageAccueil.html.twig');
}