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
            echo json_encode($twig->render('addUserModal.html.twig', array(
                "user" => $user,
                "role" => $role)));
            
            break;

    case 'addUser':

        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['promo']) && isset($_POST['statut'])) {
            $user = new User(0);
            $user->setNom($_POST['nom']);
            $user->setPrenom($_POST['prenom']);
            $user->setEmail($_POST['email']);
            $user->setPromo($_POST['promo']);
            $user->setStatut($_POST['statut']);
            $user->insertMat();

            $responce = $_POST['nom'] . ' ' . $_POST['description'] . ' ' . $_POST['caution'] . ' ' . $_POST['type'];
        }

        echo json_encode($responce);

        break;

    case 'updateUserModal':

        $user = new User($_POST["id"]);
      
            echo json_encode($twig->render('updateUserModal.html.twig', array(
                "user" => $user,
                )));
            
            break;
}
