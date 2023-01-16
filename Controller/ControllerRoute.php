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
            "user" => $user
        )));

        break;

    case 'pageMatDemande':
        $icon = Materiel::typeMateriel();
        $order   = '/';
        $replace = '-';
        $date_debut = str_replace($order, $replace, $_POST['date_debut']);
        $date_fin = str_replace($order, $replace, $_POST['date_fin']);
        error_log($date_debut + ' page Mat Demande');
        echo json_encode($twig->render('ongletsDemandeUser.html.twig', array(
            "icon" => $icon,
            "date_debut" => $date_debut,
            "date_fin" => $date_fin
        )));

        break;
    case 'pageDemande':
        echo json_encode($twig->render('pageDemandeUser.html.twig'));

        break;

    case 'modalUpdateMateriel':
        $materiel = new Materiel($_POST['id']);
        $typeMateriel =  Materiel::typeMateriel();
        echo json_encode($twig->render(
            'modalUpdatemateriel.html.twig',
            array(
                "materiel" => $materiel,
                "typeMateriel" => $typeMateriel
            )
        ));

        break;
    case 'modalAddMateriel':

        $typeMateriel =  Materiel::typeMateriel();
        echo json_encode($twig->render(
            'modalAddMateriel.html.twig',
            array(
                'typeMateriel' => $typeMateriel
            )
        ));

        break;

    case 'modalDetailMateriel':

        $materiel = new Materiel($_POST['id']);
        echo json_encode($twig->render(
            'modalDetailMateriel.html.twig',
            array(
                "materiel" => $materiel
            )
        ));

        break;

    case 'modalAddTypeMateriel':
        echo json_encode($twig->render(
            'modalAddTypeMateriel.html.twig',
            array()
        ));

        break;
}
