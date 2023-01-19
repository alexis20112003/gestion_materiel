<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once '../Entity/User.php';
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'loadUser':
        
            $typeUser = User::selectUserbyType($_POST['type']);
            echo json_encode($twig->render('contentGestionCompte.html.twig', array(
                "typeUser" => $typeUser,
               
            )));
        
            
            break;
            
    case 'loadAllUser':

        $typeUser = User::selectAllUser();
        echo json_encode($twig->render('contentSuiviUser.html.twig', array(
            "typeUser" => $typeUser,
            
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

        $reussite = 0;
        $msg = "";

        if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['statut']) && !empty($_POST['site'])) {
            $user = new User(0);
            $randPass = User::randomPassword();
            $site = $_POST['site'];
            $statut = $_POST['statut'];
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setEmail($_POST['email']);
		    $user->setPass($randPass);
            if (!empty($_POST['promo'])){
                $user->setPromo($_POST['promo']);
            }
            $user->register($site,$statut);
            $reussite = 1;
            $msg = "Nouvel Utilisateur Ajouté";    
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

        $statut = 0;
        $msg = "";
      
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

    
}
