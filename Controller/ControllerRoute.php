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
        $user = new User($_SESSION["id"]);

        echo json_encode($twig->render('gestion_compte_onglet.html.twig', array(
            "onglet" => $onglet,
            "user" => $user
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
        $order   = '/';
        $replace = '-';
        $date_debut = str_replace($order, $replace, $_POST['date_debut']);
        $date_fin = str_replace($order, $replace, $_POST['date_fin']);
        error_log($date_debut);
        echo json_encode($twig->render('matDemande.html.twig', array(
            "icon" => $icon,
            "date_debut" => $date_debut,
            "date_fin" => $date_fin
        )));

        break;
    case 'pageDemande':
        echo json_encode($twig->render('demande.html.twig'));

        break;

    case 'pageModifMat':
        $materiel = new Materiel($_POST['id']);
        $TypeMat =  Materiel::TypeMat();
        echo json_encode($twig->render(
            'modifMat.html.twig',
            array(
                "materiel" => $materiel,
                "TypeMat" => $TypeMat
            )
        ));

        break;
    case 'pageAddMat':

        $TypeMat =  Materiel::TypeMat();
        echo json_encode($twig->render(
            'addMat.html.twig',
            array(
                'TypeMat' => $TypeMat
            )
        ));

        break;

    case 'pageAfficherMat':

        $materiel = new Materiel($_POST['id']);
        echo json_encode($twig->render(
            'afficherMat.html.twig',
            array(
                "materiel" => $materiel
            )
        ));

        break;

    case 'pageAddTypeMat':
        echo json_encode($twig->render(
            'addTypeMat.html.twig',
            array()
        ));

        break;
}
