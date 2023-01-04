<?php
require_once('../Entity/Database.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

switch ($_POST['request']) {
    case 'addMat':

        if (isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['type'])) {
            error_log('c bon');
            $responce = 'c bon';
        }

        echo json_encode($responce);

        break;
}
