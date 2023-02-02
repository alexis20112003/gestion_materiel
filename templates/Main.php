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


if (isset($_SESSION['id'])) {

  $id = User::encrypt_decrypt('decrypt', $_SESSION['id']);
  $user = new User($id);
  $result = User::selectUserSite($id);

  // $list_id = "";
  $list_id = array();
  foreach ($result as $key => $value) {
    // $list_id .= $value['id_site'] . ',';
    array_push($list_id, '' . $value['id_site'] . '');
  }
  // $list_id = substr($list_id, 0, -1);
  $_SESSION['site_user'] = $list_id;
  echo $twig->render('header.html.twig') . $twig->render('main.html.twig', array(
    "user" => $user,
    "sites" => $sites,
  ));
} else {
  header('Location: Accueil.php');
  exit;
}
