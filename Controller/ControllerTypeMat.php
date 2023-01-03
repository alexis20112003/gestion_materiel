<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once '../Entity/Materiel.php';
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

switch ($_POST['request']) {
    case 'gestionMat':
        $type = Materiel::selectIdTypeMat($_POST['type']);
        echo json_encode($twig->render('gestion_mat_type.html.twig', array(
            "type" => $type,
        )));

        break;
}
