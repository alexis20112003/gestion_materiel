<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/Commande.php');
require_once('../Entity/Materiel.php');
require_once('../Entity/User.php');
require_once('../Entity/Mailer.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'insertDemandeMateriel':

        if (isset($_POST['id']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            $id = json_decode($_POST['id']);
            $demande = new Commande(0);
            $demande->setDate_debut($_POST['date_debut']);
            $demande->setDate_fin($_POST['date_fin']);
            $demande->setRestitute(0);
            $info_commande = $demande->insertCommande($_SESSION['id'], $id);
            $mail = new Mailer;
            $id_site = User::selectUserSite($_SESSION['id']);
            $mail_user = User::selectAdminbySite($id_site);
            error_log(json_encode($info_commande));
            $mail->sendMailNotification($mail_user, $info_commande);

            $response = $id;
        } else {
        }
        echo json_encode($response);

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

    case 'NotificationDemande':
        $demande = Commande::selectCommandeStatut();
        echo json_encode($twig->render('contentNotificationDemande.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'NotificationGive':
        $demande = Commande::selectCommandeGive();
        echo json_encode($twig->render('contentNotificationGive.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'NotificationRecover':
        $demande = Commande::selectCommandeRecover();
        echo json_encode($twig->render('contentNotificationRecover.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'updateDemandeGive':
        $demande = new Commande(0);
        $demande->updateDemandeGive($_POST['id']);
        $response = 'c bon';
        echo json_encode($response);

        break;

    case 'updateDemandeRecover':
        $demande = new Commande(0);
        $demande->updateDemandeRecover($_POST['id']);
        $responce = 'c bon';
        echo json_encode($responce);

        break;

    case 'refuseDemandeMateriel':
        $demande = new Commande(0);
        $demande->refuseDemandeMateriel($_POST['id']);
        $response = 'c bon';
        echo json_encode($response);

        break;

    case 'acceptDemandeMateriel':
        $demande = new Commande(0);
        $demande->acceptDemandeMateriel($_POST['id']);
        $response = 'c bon';
        echo json_encode($response);

        break;
}
