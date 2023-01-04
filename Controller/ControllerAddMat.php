<?php
require_once('../Entity/Database.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

switch ($_POST['request']) {
    case 'addMat':




        break;
}
