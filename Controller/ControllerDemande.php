<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/Commande.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'demandeMat':

        if (isset($_POST['id']) && isset($_POST['date_debut'])) {
            $id = json_decode($_POST['id']);
            foreach ($id as $value) {
                $demande = new Commande($value);
            }
            $responce = $id;
        }
        echo json_encode($responce);

        break;
}
