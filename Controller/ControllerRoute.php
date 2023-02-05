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
        foreach ($icon as $key => $value) {
            $icon[$key]['id_type_materiel'] = User::encrypt_decrypt('encrypt', $value['id_type_materiel']);
        }
        echo json_encode($twig->render('pageGestionMateriel.html.twig', array(
            "icon" => $icon
        )));

        break;

    case 'pageGestionCompte':

        $onglet = User::typeUser();
        foreach ($onglet as $key => $value) {
            $onglet[$key]['id_type'] = User::encrypt_decrypt('encrypt', $value['id_type']);
        }
        $id_user = User::encrypt_decrypt('decrypt', $_SESSION['id']);
        $user = new User($id_user);
        echo json_encode($twig->render('pageGestionCompte.html.twig', array(
            "onglet" => $onglet,
            "user" => $user
        )));

        break;

    case 'pageGestionProfile':
        $id_user = User::encrypt_decrypt('decrypt', $_SESSION['id']);
        $user = new User($id_user);
        echo json_encode($twig->render('pageGestionProfile.html.twig', array(
            "user" => $user,
        )));

        break;

    case 'pageDemande':
        echo json_encode($twig->render('pageDemandeUser.html.twig'));

        break;

    case 'pageSuiviMateriel':

        $icon = Materiel::typeMateriel();
        foreach ($icon as $key => $value) {
            $icon[$key]['id_type_materiel'] = User::encrypt_decrypt('encrypt', $value['id_type_materiel']);
        }
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
