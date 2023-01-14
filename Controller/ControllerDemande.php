<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/Commande.php');
require_once('../Entity/Materiel.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'insertDemandeMateriel':

        if (isset($_POST['id']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            error_log($date_debut + 'demandeMat');
            $id = json_decode($_POST['id']);
            $demande = new Commande(0);
            $demande->setDate_debut($_POST['date_debut']);
            $demande->setDate_fin($_POST['date_fin']);
            $demande->setRestitute(0);
            $demande->insertCommande($_SESSION['id'], $id);

            $responce = $id;
        } else {
        }
        echo json_encode($responce);

        break;

    case 'materielDemande':
        $resultNum = Materiel::sqlCount($_POST['type']);
        $type = Materiel::selectIdTypeMaterielDemande($_POST['type'], $_POST['date_debut'], $_POST['date_fin']);
        echo json_encode($twig->render('contentDemandeUser.html.twig', array(
            "type" => $type,
            "resultNum" => $resultNum,
        )));

        break;

    case 'ongletsMaterielDemande':
        $icon = Materiel::typeMateriel();
        echo json_encode($twig->render('ongletsDemandeUser.html.twig', array(
            "icon" => $icon,
            "date_debut" => $_POST['date_debut'],
            "date_fin" => $_POST['date_fin']
        )));

        break;
}
