<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once '../Entity/Materiel.php';
require_once '../Entity/User.php';
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

    case 'pageGestionCompte':

        $onglet = User::typeUser();

        echo json_encode($twig->render('gestion_compte_onglet.html.twig', array(
            "onglet" => $onglet
        )));

        break;

    case 'pageGestionProfile':
        $user = new User($_SESSION["id"]);
        echo json_encode($twig->render('gestion_profile.html.twig', array(
            "user" => $user
        )));

        break;

    case 'deconnexion':
        session_destroy();
        echo json_encode(0);
        break;

    case 'pageMatDemande':
        $icon = Materiel::TypeMat();
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        echo json_encode($twig->render('matDemande.html.twig', array(
            "icon" => $icon,
            "date_debut" => $date_debut,
            "date_fin" => $date_fin
        )));

        break;

    case 'pageDemande':
        echo json_encode($twig->render('demande.html.twig', array()));

        break;
}
