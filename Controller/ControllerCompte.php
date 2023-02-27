<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/User.php');
require_once('../Entity/Mailer.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

$reussite = 0;
$statut = 0;
$msg = "erreur";

// function formTest($array, $pieces = [])
// {
//     if (count($array) > 0) {
//         foreach ($array as $k => $v) {
//             if (!in_array($k, $pieces) || empty($v)) {
//                 return false;
//             }
//         }
//     } else {
//         return false;
//     }

//     return true;
// }


switch ($_POST['request']) {

    case 'loadUser':

        $typeUser = User::selectUserbyTypeandSite($_POST['type'], $_SESSION['site_user']);
        echo json_encode($twig->render('contentGestionCompte.html.twig', array(
            "typeUser" => $typeUser,

        )));


        break;

    case 'loadAllUser':

        $allUser = User::selectAllUser($_SESSION['site_user']);
        echo json_encode($twig->render('contentSuiviUser.html.twig', array(
            "allUser" => $allUser,

        )));


        break;

    case 'loadDisabledUser':

        $disabledUser = User::selectDisabledUser($_SESSION['site_user']);
        echo json_encode($twig->render('contentDisabledUser.html.twig', array(
            "disabledUser" => $disabledUser,

        )));


        break;

    case 'modalAddUser':

        $id_user = User::encrypt_decrypt('decrypt', $_SESSION["id"]);
        $user = new User($id_user);
        $role = User::typeUser();
        $sites = User::selectSites();
        $id_sites = User::selectUserSite($id_user);
        foreach ($id_sites as $site) {
            $userSite = $site;   
        }
        echo json_encode($twig->render('modalAddUser.html.twig', array(
            "user" => $user,
            "role" => $role,
            "sites" => $sites,
            "userSite" => $userSite
        )));

        break;

    case 'addUser':
        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['statut']) && !empty($_POST['site'])) {
            $user = new User(0);
            $mail = new Mailer;
            $userPassword = User::randomPassword();
            $emailModel = 'emailSendPassword.html.twig';
            $userNom = $_POST['nom'];
            $userPrenom = $_POST['prenom'];
            $userEmail = $_POST['email'];
            $site = $_POST['site'];
            $statut = $_POST['statut'];
            $user->setNom($userNom);
            $user->setPrenom($userPrenom);
            $user->setEmail($userEmail);
            $user->setPass($userPassword);
            if (!empty($_POST['promo'])) {
                $user->setPromo($_POST['promo']);
            }
            $user->register($site, $statut);
            $msgMail = $mail->sendMailPassword($userEmail, $userNom, $userPrenom, $userPassword, $emailModel);
            $reussite = 1;
            $msg = "Nouvel Utilisateur Ajouté" . "<br>" . $msgMail;
        }

        echo json_encode(array("msg" => $msg, "reussite" => $reussite));

        break;

    case 'modalUpdateUser':

        $user = new User($_POST["id"]);
        $typeUser = User::selectTypebyUser($_POST["id"]);

        echo json_encode($twig->render('modalUpdateUser.html.twig', array(
            "user" => $user,
            "typeUser" => $typeUser,
        )));

        break;


    case 'updateUser':

        if (isset($_POST['userId']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['enable'])) {
            $user = new User($_POST['userId']);
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setEmail($_POST['email']);
            $user->setEnable($_POST['enable']);
            $user->updateUser();
            $statut = 1;
            $msg = "Informations mises à jour";
        }

        echo json_encode(array("msg" => $msg, "statut" => $statut));

        break;

    case 'loadProfilePage':

        $user = new User($_POST["id"]);

        echo json_encode($twig->render('modalUpdateUser.html.twig', array(
            "user" => $user,

        )));

        break;




    case 'modalSuiviUser':

        $user = User::selectCommandeIdUser($_POST['id']);
        echo json_encode($twig->render(
            'modalSuiviUser.html.twig',
            array(
                "user" => $user
            )
        ));

        break;

    case 'modalUpdateImageProfile':


        echo json_encode($twig->render(
            'modalUpdateImageProfile.html.twig',
        ));

        break;

    case 'modalUpdateImageBanniere':


        echo json_encode($twig->render(
            'modalUpdateImageBanniere.html.twig',
        ));

        break;

    case 'modalMotDePasse':


        echo json_encode($twig->render(
            'modalMotDePasse.html.twig',
        ));

        break;

    case 'sendNewPassword':

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $id = User::selectUserbyEmail($email);
            if (!empty($id)) {
                $user = new User($id);
                $mail = new Mailer;
                $emailModel = 'emailSendPassword.html.twig';
                $userPassword = User::randomPassword();
                $user->setPass($userPassword);
                $userEmail = $email;
                $userNom = $user->getNom();
                $userPrenom = $user->getPrenom();
                $user->updatePassword();
                $msgMail = $mail->sendMailPassword($userEmail, $userNom, $userPrenom, $userPassword, $emailModel);
                $statut = 1;
                $msg = "Nouveau Mot de passe Envoyé";
            }
        }

        echo json_encode(array("msg" => $msg, "statut" => $statut));

        break;

    case 'modalUpdateProfile':

        $id_user = User::encrypt_decrypt('decrypt', $_SESSION["id"]);
        $user = new User($id_user);
        echo json_encode($twig->render(
            'modalUpdateProfile.html.twig',
            array("user" => $user)
        ));

        break;

    case 'updateProfile':

        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['oldPassword']) && isset($_POST["newPassword"])) {
            $id_user = User::encrypt_decrypt('decrypt', $_SESSION["id"]);
            $user = new User($id_user);
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setEmail($_POST['email']);
            $hash = $user->getPass();

            if (password_verify($_POST['oldPassword'], $hash)) {
                $user->setPass($_POST['newPassword']);
            }
            $user->updateProfile();
            $statut = 1;
            $msg = "Informations mises à jour";
        }
        echo json_encode(array("msg" => $msg, "statut" => $statut));

        break;
}
