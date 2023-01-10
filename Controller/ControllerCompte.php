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
        
            $userCount = User::userCount($_POST['type']);
            $typeUser = User::selectIdTypeUser($_POST['type']);
            echo json_encode($twig->render('gestion_compte.html.twig', array(
                "typeUser" => $typeUser,
                "userCount" => $userCount,
            )));
        
            
            break;
}
