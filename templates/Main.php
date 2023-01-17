<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/User.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

$render = new \Twig\Loader\FilesystemLoader('../components/');
$twig = new \Twig\Environment($render);

$user = new User($_SESSION["id"]);

$preparedSql = $GLOBALS['database']->prepare('SELECT * FROM `site` ');
$preparedSql->execute();
$sites = $preparedSql->fetchAll(PDO::FETCH_ASSOC);


echo $twig->render('header.html.twig').$twig->render('main.html.twig', array(
  "user" => $user,
  "sites" => $sites,
));

