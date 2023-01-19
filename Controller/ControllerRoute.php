<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once '../Entity/Materiel.php';
require_once '../Entity/User.php';
require_once '../Entity/Commande.php';
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'pageGestionMateriel':

        $icon = Materiel::typeMateriel();

        echo json_encode($twig->render('pageGestionMateriel.html.twig', array(
            "icon" => $icon
        )));

        break;

    case 'pageGestionCompte':

        $onglet = User::typeUser();
        $user = new User($_SESSION["id"]);

        echo json_encode($twig->render('pageGestionCompte.html.twig', array(
            "onglet" => $onglet,
            "user" => $user
        )));

        break;

    case 'pageGestionProfile':
        $user = new User($_SESSION["id"]);
        echo json_encode($twig->render('pageGestionProfile.html.twig', array(
            "user" => $user,
        )));

        break;

    case 'pageDemande':
        echo json_encode($twig->render('pageDemandeUser.html.twig'));

        break;

    case 'pageSuiviMateriel':

        $icon = Materiel::typeMateriel();

        echo json_encode($twig->render('pageSuiviMateriel.html.twig', array(
            "icon" => $icon
        )));

        break;

    case 'pageNotificationDemande':
        echo json_encode($twig->render('pageNotificationDemande.html.twig', array()));

        break;

    case 'pageNotificationDemande':
        echo json_encode($twig->render('pageNotificationDemande.html.twig', array()));

        break;
}
