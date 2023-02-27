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
                $id_decrypted = User::encrypt_decrypt('decrypt', $materiel);
                foreach ($id_verif as $key => $all_materiel) {
                    if ($id_decrypted == $all_materiel['id_materiels']) {
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
                $response = 'error';
            }
        } else {
            $response = 'error 2';
        }
        echo json_encode($response);

        break;

    case 'materielDemande':
        if ($_POST['type'] == 1) {
            $type = Materiel::selectIdTypeMaterielDemande($_POST['type'], $_POST['date_debut'], $_POST['date_fin'], $_SESSION['site_user']);
        } else {
            $type_decrypted = User::encrypt_decrypt('decrypt', $_POST['type']);
            $type = Materiel::selectIdTypeMaterielDemande($type_decrypted, $_POST['date_debut'], $_POST['date_fin'], $_SESSION['site_user']);
        }
        foreach ($type as $key => $value) {
            $type[$key]['id_materiels'] = User::encrypt_decrypt('encrypt', $value['id_materiels']);
        }
        echo json_encode($twig->render('contentDemandeUser.html.twig', array(
            "type" => $type,
        )));

        break;

    case 'ongletsMaterielDemande':
        $icon = Materiel::typeMateriel();
        foreach ($icon as $key => $value) {
            $icon[$key]['id_type_materiel'] = User::encrypt_decrypt('encrypt', $value['id_type_materiel']);
        }
        echo json_encode($twig->render('ongletsDemandeUser.html.twig', array(
            "icon" => $icon,
            "date_debut" => $_POST['date_debut'],
            "date_fin" => $_POST['date_fin']
        )));

        break;

    case 'NotificationDemande':
        $list = array();
        $demandes = Commande::selectCommandeStatut();
        foreach ($demandes as $key => $demande) {
            foreach ($demande as $key => $value) {
                $demande[$key]['idCom'] = User::encrypt_decrypt('encrypt', $value['idCom']);
            }
        }
        array_push($list, $demande);
        echo json_encode($twig->render('contentNotificationDemande.html.twig', array(
            'demande' => $list,
        )));

        break;

    case 'NotificationGive':
        $demande = Commande::selectCommandeGive();
        foreach ($demande as $key => $value) {
            $demande[$key]['id_commande'] = User::encrypt_decrypt('encrypt', $value['id_commande']);
        }
        echo json_encode($twig->render('contentNotificationGive.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'NotificationRecover':
        $demande = Commande::selectCommandeRecover();
        foreach ($demande as $key => $value) {
            $demande[$key]['id_commande'] = User::encrypt_decrypt('encrypt', $value['id_commande']);
        }
        echo json_encode($twig->render('contentNotificationRecover.html.twig', array(
            'demande' => $demande,
        )));

        break;

    case 'updateDemandeGive':
        $demande = new Commande(0);
        $id_decrypted = User::encrypt_decrypt('decrypt', $_POST['id']);
        $demande->updateDemandeGive($id_decrypted);
        $response = 'c bon';
        echo json_encode($response);

        break;

    case 'updateDemandeRecover':
        $demande = new Commande(0);
        $id_decrypted = User::encrypt_decrypt('decrypt', $_POST['id']);
        $demande->updateDemandeRecover($id_decrypted);
        $responce = 'c bon';
        echo json_encode($responce);

        break;

    case 'refuseDemandeMateriel':
        $demande = new Commande(0);
        $id_decrypted = User::encrypt_decrypt('decrypt', $_POST['id']);
        $demande->refuseDemandeMateriel($id_decrypted);
        $response = 'c bon';
        echo json_encode($response);

        break;

    case 'acceptDemandeMateriel':
        $demande = new Commande(0);
        $id_decrypted = User::encrypt_decrypt('decrypt', $_POST['id']);
        $demande->acceptDemandeMateriel($id_decrypted);
        $response = 'c bon';
        echo json_encode($response);

        break;
}
