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
    case 'pageGestionMat':

        $icon = Materiel::TypeMat();

        echo json_encode($twig->render('gestion_mat.html.twig', array(
            "icon" => $icon
        )));

        break;

    case 'pageGestionProfile':
        $user = new User($_SESSION["id"]);
        echo json_encode($twig->render('gestion_profile.html.twig', array(
            "user" => $user
        )));

        break;

    case 'deconnexion':
        
        session_destroy();
        echo json_encode(0);
        break;

    case 'pageAddMat':

        $TypeMat =  Materiel::TypeMat();
        echo json_encode($twig->render('addMat.html.twig', array(
            "TypeMat" => $TypeMat
        )));

        break;
    
        case 'pageModifMat':
        $materiel = new Materiel($_POST['id']);
        $TypeMat =  Materiel::TypeMat();
        echo json_encode($twig->render('modifMat.html.twig', array(
            "materiel" => $materiel,
            "TypeMat" => $TypeMat
        )
        ));

        break;
        
        case 'pageAfficherMat':
        
            $materiel = new Materiel($_POST['id']);
            echo json_encode($twig->render('afficherMat.html.twig', array(
                "materiel" => $materiel
            )
            ));
    
        break;
        
        case 'pageAddTypeMat':
            echo json_encode($twig->render('addTypeMat.html.twig', array(
            )
            ));

        break;
        
        
}
