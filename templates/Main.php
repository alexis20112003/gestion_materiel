<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/User.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

$render = new \Twig\Loader\FilesystemLoader('../components/');
$twig = new \Twig\Environment($render);



$preparedSql = $GLOBALS['database']->prepare('SELECT * FROM `site` ');
$preparedSql->execute();
$sites = $preparedSql->fetchAll(PDO::FETCH_ASSOC);

error_log(json_encode($_SESSION));
if (isset($_SESSION['id'])) {
  
  $id= User::encrypt_decrypt('decrypt', $_SESSION['id']);
  $user = new User($id);
  error_log(json_encode($id));
  echo $twig->render('header.html.twig') . $twig->render('main.html.twig', array(
    "user" => $user,
    "sites" => $sites,
  ));
} else {
  header('Location: Accueil.php');
  exit;
}
