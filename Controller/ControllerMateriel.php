<?php
require_once('../vendor/autoload.php');
require_once('../Entity/Database.php');
require_once('../Entity/Materiel.php');
require_once('../Entity/User.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

$render = new \Twig\Loader\FilesystemLoader('../components/');

$twig = new \Twig\Environment($render);


switch ($_POST['request']) {

    case 'loadMateriel':
        $list_result = array();
        if ($_POST['type'] == 1) {
            foreach ($_SESSION['site_user'] as $key => $value) {
                $type = Materiel::selectIdTypeMateriel($_POST['type'], $value);
                array_push($list_result, $type);
            }
        } else {
            $type_decrypted = User::encrypt_decrypt('decrypt', $_POST['type']);
            foreach ($_SESSION['site_user'] as $key => $value) {
                $type = Materiel::selectIdTypeMateriel($type_decrypted, $value);
                array_push($list_result, $type);
            }
        }
        echo json_encode($twig->render('contentGestionMateriel.html.twig', array(
            "type" => $list_result,

        )));
        break;
    case 'loadAllMateriel':
        $list_result = array();
        foreach ($_SESSION['site_user'] as $key => $value) {
            $allMateriel = Materiel::selectAllMateriel($value);
            array_push($list_result, $allMateriel);
        }
        echo json_encode($twig->render('contentSuiviMateriel.html.twig', array(
            "allMateriel" => $list_result,

        )));

        break;

    case 'addMateriel':

        if (isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['type']) && isset($_POST['caution'])) {
            $materiel = new Materiel(0);
            $materiel->setNom($_POST['nom']);
            $materiel->setDescription($_POST['description']);
            $materiel->setCaution($_POST['caution']);
            $materiel->setId_type_materiel($_POST['type']);
            $materiel->insertMateriel();

            $responce = $_POST['nom'] . ' ' . $_POST['description'] . ' ' . $_POST['caution'] . ' ' . $_POST['type'];
        }

        echo json_encode($responce);

        break;

    case 'addTypeMateriel':

        if (isset($_POST['nom']) && isset($_POST['icon'])) {

            $requete = $GLOBALS['database']->prepare("INSERT INTO `type_materiel` (`origine_materiel`, `icon`) VALUES (:nom, :icon)");
            $requete->bindValue(':nom', $_POST['nom']);
            $requete->bindValue(':icon', $_POST['icon']);

            $requete->execute();

            $responce = $_POST['nom'] . ' ' . $_POST['icon'];
        }

        echo json_encode($responce);

        break;

    case 'deleteMateriel':

        if (isset($_POST['id'])) {
            $id = json_decode($_POST['id']);
            foreach ($id as $value) {
                $materiel = new Materiel($value);
                $materiel->deleteMateriel();
            }
            $responce = $id;
        }

        echo json_encode($responce);

        break;

    case 'updateMateriel':

        $materiel = new Materiel($_POST['id']);
        $materiel->setNom($_POST['nom']);
        $materiel->setDescription($_POST['description']);
        $materiel->setCaution($_POST['caution']);
        $materiel->setEnable($_POST['enable']);
        $materiel->updateMateriel();


        echo json_encode(1);


        break;

    case 'modalUpdateMateriel':
        $materiel = new Materiel($_POST['id']);
        $typeMateriel =  Materiel::typeMateriel();
        echo json_encode($twig->render(
            'modalUpdatemateriel.html.twig',
            array(
                "materiel" => $materiel,
                "typeMateriel" => $typeMateriel
            )
        ));

        break;

    case 'modalAddMateriel':

        $typeMateriel =  Materiel::typeMateriel();
        echo json_encode($twig->render(
            'modalAddMateriel.html.twig',
            array(
                'typeMateriel' => $typeMateriel
            )
        ));

        break;

    case 'modalDetailMateriel':

        $materiel = Materiel::detailMaterielById($_POST['id']);
        echo json_encode($twig->render(
            'modalDetailMateriel.html.twig',
            array(
                "materiel" => $materiel
            )
        ));

        break;

    case 'modalAddTypeMateriel':
        echo json_encode($twig->render(
            'modalAddTypeMateriel.html.twig',
            array()
        ));

        break;

    case 'modalSuiviMateriel':

        $materiel = Materiel::selectCommandeIdMateriel($_POST['id']);
        echo json_encode($twig->render(
            'modalSuiviMateriel.html.twig',
            array(
                "materiel" => $materiel
            )
        ));

        break;
}
