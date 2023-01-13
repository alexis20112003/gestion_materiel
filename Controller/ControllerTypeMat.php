<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/Materiel.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'gestionMat':
        $resultNum = Materiel::sqlCount($_POST['type']);
        $type = Materiel::selectIdTypeMat($_POST['type']);
        echo json_encode($twig->render('gestion_mat.html.twig', array(
            "type" => $type,
            "resultNum" => $resultNum,
        )));

        break;

    case 'gestionMatDemande':
        $resultNum = Materiel::sqlCount($_POST['type']);
        $order   = '/';
        $replace = '-';
        $date_debut = str_replace($order, $replace, $_POST['date_debut']);
        $date_fin = str_replace($order, $replace, $_POST['date_fin']);
        $type = Materiel::selectIdTypeMatDemande($_POST['type'], $date_debut, $date_fin);


        echo json_encode($twig->render('gestion_mat_demande.html.twig', array(
            "type" => $type,
            "resultNum" => $resultNum,
        )));

        break;
}
