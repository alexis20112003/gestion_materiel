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
    case 'gestionCompte':
        
            $typeUser = User::selectIdTypeUser($_POST['type']);
            echo json_encode($twig->render('gestion_compte.html.twig', array(
                "typeUser" => $typeUser,
               
            )));
        
            
            break;

    case 'addUserModal':

        $user = new User($_SESSION["id"]);
        $role = User::typeUser();
        $sites = User::selectSites();
        $userSite = User::selectUserSite($_SESSION["id"]);
            echo json_encode($twig->render('addUserModal.html.twig', array(
                "user" => $user,
                "role" => $role,
                "sites" => $sites,
                "userSite" => $userSite
            )));
            
            break;

    case 'addUser':

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

            $response = $_POST['nom'] . ' ' . $_POST['prenom'] . ' ' . $_POST['email'] . ' ' . $_POST['promo'] . ' ' . $randPass;
        }else{
            $response = "Vide";
        }

        echo json_encode($response);

        break;

    case 'updateUserModal':

        $user = new User($_POST["id"]);
      
            echo json_encode($twig->render('updateUserModal.html.twig', array(
                "user" => $user        
                )));
            
            break;
}
