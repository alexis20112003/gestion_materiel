<?php
require_once('../Entity/Database.php');
require_once('../Entity/User.php');
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion();

session_start();

switch ($_POST['request']) {
  case 'connexion':

    $error = 0;
    $status = "";
    $msg = "Identifiants incorrect";

    if(isset($_POST['email'] ) && isset($_POST['password'])){
     
      $preparedSql = $GLOBALS['database']->prepare('SELECT `id_utilisateur`, `nom`, `prenom`, `email`, `password`, `promo` 
      FROM `utilisateur` ');
      $preparedSql->execute();
      $users = $preparedSql->fetchAll(PDO::FETCH_ASSOC);
      foreach ($users as $user) {
        $hash = $user['password'];
        if (password_verify($_POST["password"], $hash) && $_POST["email"] == $user['email']){         
            $status = "connected";
            $_SESSION['id'] = User::encrypt_decrypt('encrypt', $user['id_utilisateur']);
            $msg = "Connexion réussi";    
          }
      }
    }
 

    echo json_encode(array("error" => $error, "status" => $status, "msg" => $msg, "session" => $_SESSION));

    break;

  case 'deconnexion':
    session_destroy();
    echo json_encode(0);
    break;
}
