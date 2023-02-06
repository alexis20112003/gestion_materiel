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
          // if($_POST['email'] == $user['email'] && $_POST['password'] == $user['password']){

            $status = "connected";
            $userId = $user['id_utilisateur'];
            $token = bin2hex(random_bytes(64));
            $exec = $GLOBALS['database']->prepare("INSERT INTO `token` (`id_utilisateur`, `valeur`) VALUES (:userId, :token)");
            $exec->bindParam(':token', $token);
            $exec->bindParam(':userId', $userId);
            $exec->execute();

            
            $_SESSION['temp'] = User::encrypt_decrypt('encrypt', $user['id_utilisateur']);
            $msg = "Connexion réussi";    
          }
      }
    }
 

    echo json_encode(array("error" => $error, "status" => $status, "msg" => $msg, "session" => $_SESSION));

    break;
  
  case 'authentification':

    $error = 0;
    $status = "";
    $msg = "Token incorrect";

    if (isset($_POST['token'])) {
      $token = $_POST['token'];
      $preparedSql = $GLOBALS['database']->prepare("SELECT `id_utilisateur` FROM `token` WHERE `valeur` = :token");
      $preparedSql->bindParam(':token', $token);
      $preparedSql->execute();
      $userId = $preparedSql->fetchColumn();

      if ($userId) {
        $status = "authentified";
        $msg = "Authentification réussie";
        $_SESSION['id'] = User::encrypt_decrypt('encrypt', $userId);
      }
    }

    echo json_encode(array("error" => $error, "status" => $status, "msg" => $msg, "session" => $_SESSION));
    
    break;

  case 'changePassword':

    $error = 0;
    $statut = 0;
    $msg = "Mot de passe incorrect";
    $user = new User($_SESSION["id"]);
    if ($_POST["PasswordConfirme"] == $user->getPass()) {

      $msg = "Changement réussi";
    }




    echo json_encode(array("error" => $error, "msg" => $msg, "statut" => $statut));

    break;

  case 'deconnexion':
    session_destroy();
    echo json_encode(0);
    break;
}
