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
    case 'demandeMateriel':

        if (isset($_POST['id']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $order   = '/';
            $replace = '-';
            $date_debut = str_replace($order, $replace, $_POST['date_debut']);
            $date_fin = str_replace($order, $replace, $_POST['date_fin']);
            error_log($date_debut + 'demandeMat');
            $id = json_decode($_POST['id']);
            $demande = new Commande(0);
            $demande->setDate_debut($date_debut);
            $demande->setDate_fin($date_fin);
            $demande->setRestitute(0);
            $demande->insertCom($_SESSION['id'], $id);

            $responce = $id;
        }
        echo json_encode($responce);

        break;

}
