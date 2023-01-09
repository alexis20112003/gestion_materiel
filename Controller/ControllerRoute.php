<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once '../Entity/Materiel.php';
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'pageGestionMat':

        $icon = Materiel::TypeMat();

        echo json_encode($twig->render('gestion_mat_onglet.html.twig', array(
            "icon" => $icon
        )));

        break;

    case 'pageGestionProfile':

        echo json_encode($twig->render('gestion_profile.html.twig'));

        break;

    case 'deconnexion':
        session_destroy();
        echo json_encode(0);
        break;

    case 'pageDemande':
        $icon = Materiel::TypeMat();
        echo json_encode($twig->render('demande.html.twig', array(
            "icon" => $icon
        )));

        break;
}
