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
$msg = "";

function formTest($array, $pieces = [])
{
    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (!in_array($k, $pieces) || empty($v)) {
                return false;
            }
        }
    } else {
        return false;
    }

    return true;
} 


switch ($_POST['request']) {

    case 'loadUser':
        
            $typeUser = User::selectUserbyType($_POST['type']);
            echo json_encode($twig->render('contentGestionCompte.html.twig', array(
                "typeUser" => $typeUser,
               
            )));
        
            
            break;
            
    case 'loadAllUser':

        $allUser = User::selectAllUser();
        echo json_encode($twig->render('contentSuiviUser.html.twig', array(
            "allUser" => $allUser,
            
        )));
    
        
        break;

    case 'loadDisabledUser':

        $disabledUser = User::selectDisabledUser();
        echo json_encode($twig->render('contentDisabledUser.html.twig', array(
            "disabledUser" => $disabledUser,
            
        )));
    
        
        break;

    case 'modalAddUser':

        $user = new User($_SESSION["id"]);
        $role = User::typeUser();
        $sites = User::selectSites();
        $userSite = User::selectUserSite($_SESSION["id"]);
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
            if (!empty($_POST['promo'])){
                $user->setPromo($_POST['promo']);
            }
            $user->register($site,$statut);
            $msgMail = $mail->sendMailPassword($userEmail, $userNom, $userPrenom, $userPassword, $emailModel);
            $reussite = 1;
            $msg = "Nouvel Utilisateur Ajouté"."<br>".$msgMail;    
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
            $response = $_POST['nom'] . ' ' . $_POST['prenom'] . ' ' . $_POST['email'] . ' ' . $_POST['enable'];
            $statut = 1;
            $msg = "Informations mises à jour";
        }

        echo json_encode(array("msg" => $msg, "statut" => $statut));

    break;

    case 'loadProfilePage' :

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

    case 'updateImageProfile':

        if (isset($_FILES)){
           
            $list_image = [
                "img_url" => 'gestion_materiel/Assets' .$_FILES['imgProfile']['name'],
                'img_file' => $_FILES['imgProfile']['tmp_name']
            ];
            $list = [
                'title'=> htmlspecialchars($_FILES['new_file']['name']),
                'img_url' => $list_image['img_url']
            ];
    
            move_uploaded_file($list_image['img_file'], $list_image['img_url']);
             
            $user = new User($_SESSION['id']);
            $user->setImg_Profile($_POST['imgProfile']);
            $user->updateImageProfile();
            $statut = 1;
            $msg = "Profile mis à jour";
        }

        echo json_encode(array("msg" => $msg, "statut" => $statut));

    break;


}
