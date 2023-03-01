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
            $id_verif = Materiel::verifMaterielDemande($_POST['date_debut'], $_POST['date_fin']);
            $var = false;
            foreach ($id as $key => $materiel) {
                foreach ($id_verif as $key => $all_materiel) {
                    if ($materiel == $all_materiel['id_materiels']) {
                        $var = true;
                    }
                }
            }
            if ($var == false) {
                $demande = new Commande(0);
                $demande->setDate_debut($_POST['date_debut']);
                $demande->setDate_fin($_POST['date_fin']);
                $demande->setRestitute(0);
                $id_user = User::encrypt_decrypt('decrypt', $_SESSION['id']);
                $info_commande = $demande->insertCommande($id_user, $id);
                $mail = new Mailer;
                $id_site = User::selectUserSite($id_user);
                foreach ($id_site as $site) {
                    $mail_user = User::selectAdminbySite($site['id_site']);
                    $mail->sendMailNotification($mail_user, $info_commande);
                    $response = 'c bon';
                }
            } else {
                $response = 'c pas bon';
            }
        } else {
            $response = 'c pas bon 2';
        }
        echo json_encode($response);

        break;

    case 'materielDemande':
        $type = Materiel::selectIdTypeMaterielDemande($_POST['type'], $_POST['date_debut'], $_POST['date_fin'], $_SESSION['site_user']);
        echo json_encode($twig->render('contentDemandeUser.html.twig', array(
            "type" => $type,
        )));

        break;

    case 'ongletsMaterielDemande':
        $icon = Materiel::typeMateriel();
        $date_deb = new DateTime($_POST['date_debut']);
        $date_start = $date_deb->format("d-m-Y");
        $date_fin = new DateTime($_POST['date_fin']);
        $date_end = $date_fin->format("d-m-Y");
        $html = $twig->render('ongletsDemandeUser.html.twig', array(
            "icon" => $icon,
            "date_debut" => $_POST['date_debut'],
            "date_fin" => $_POST['date_fin']
        ));

        echo json_encode(array("html" => $html, "date_start" => $date_start, "date_end" => $date_end));

        break;

    case 'NotificationDemande':
        $demande = Commande::selectCommandeStatut($_SESSION['site_user']);
        echo json_encode($twig->render('contentNotificationDemande.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'NotificationGive':
        $demande = Commande::selectCommandeGive($_SESSION['site_user']);
        echo json_encode($twig->render('contentNotificationGive.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'NotificationRecover':
        $demande = Commande::selectCommandeRecover($_SESSION['site_user']);
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
        $email = $demande->refuseDemandeMateriel($_POST['id']);
        $info_commande = Commande::selectCommandebyId($_POST['id']);
        $mail = new Mailer;
        $mail->sendMailRefuse($email['email'], $info_commande);
        $response = 'c bon';
        echo json_encode($response);

        break;

    case 'acceptDemandeMateriel':
        $demande = new Commande(0);
        $email = $demande->acceptDemandeMateriel($_POST['id']);
        $info_commande = Commande::selectCommandebyId($_POST['id']);
        $mail = new Mailer;
        $mail->sendMailAccept($email['email'], $info_commande);
        $response = 'c bon';
        echo json_encode($response);

        break;
}
