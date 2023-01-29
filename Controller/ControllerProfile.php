<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/User.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();


$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);

$reussite = 0;
$statut = 0;
$msg = "";


if (isset($_FILES)) {
    // error_log(print_r($_FILES, true));
    $msg = 'c bon';
    $response = $msg;
    $list_image = [
        "img_url" => '../Assets/image/' . $_FILES['new_file']['name'],
        'img_file' => $_FILES['new_file']['tmp_name']
    ];

    $list = [
        'title' => htmlspecialchars($_FILES['new_file']['name']),
        'img_url' => $list_image['img_url']
    ];

    move_uploaded_file($list_image['img_file'], $list_image['img_url']);
    $user = new User($_SESSION['id']);
    $user->setImg_Profile($list['img_url']);
    // error_log($list['img_url']);
    $user->updateImageProfile();
    echo json_encode($response);
}