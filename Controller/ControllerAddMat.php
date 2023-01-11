<?php
require_once('../Entity/Database.php');
require_once('../Entity/Materiel.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

switch ($_POST['request']) {
    case 'addMat':

        if (isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['type']) && isset($_POST['caution'])) {
            $materiel = new Materiel(0);
            $materiel->setNom($_POST['nom']);
            $materiel->setDescription($_POST['description']);
            $materiel->setCaution($_POST['caution']);
            $materiel->setId_type_mat($_POST['type']);
            $materiel->insertMat();

            $responce = $_POST['nom'] . ' ' . $_POST['description'] . ' ' . $_POST['caution'] . ' ' . $_POST['type'];
        }

        echo json_encode($responce);

        break;

    case 'addTypeMat':

        if (isset($_POST['nom']) && isset($_POST['icon'])) {

            $requete = $GLOBALS['database']->prepare("INSERT INTO `type_materiel` (`origine_materiel`, `icon`) VALUES (:nom, :icon)");
            $requete->bindValue(':nom', $_POST['nom']);
            $requete->bindValue(':icon', $_POST['icon']);

            $requete->execute();

            $responce = $_POST['nom'] . ' ' . $_POST['icon'];
        }

        echo json_encode($responce);

        break;

    case 'deleteMat':

        if (isset($_POST['id'])) {
            $id = json_decode($_POST['id']);
            foreach ($id as $value) {
                $materiel = new Materiel($value);
                $materiel->deleteMat();
            }
            $responce = $id;
        }

        echo json_encode($responce);

        break;
    
    case 'modifMat':
        error_log(json_encode($_POST));
        $materiel = new Materiel($_POST['id']);
        $materiel->setNom($_POST['nom']);
        $materiel->setDescription($_POST['description']);
        $materiel->setCaution($_POST['caution']);
        $materiel->setEnable($_POST['enable']);
        $materiel->updateMat();
        

        echo json_encode(1);


        break;
}
