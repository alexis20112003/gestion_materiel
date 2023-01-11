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

        if (isset($_POST['id']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $id = json_decode($_POST['id']);
            $demande = new Commande(0);
            $demande->setDate_debut($_POST['date_debut']);
            $demande->setDate_fin($_POST['date_fin']);
            $demande->setRestitute(0);
            $demande->insertCom($_SESSION['id'], $id);

            $responce = $id;
        }
        echo json_encode($responce);

        break;
}
