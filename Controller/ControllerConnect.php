<?php
require_once ('../Entity/Database.php'); 
require_once ('../Entity/User.php'); 
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion(); 

session_start();

switch($_POST['request'])
{
case 'connexion':

    $error = 0;
    $status = "";
    $msg = "Identifiants incorrect";

    if(isset($_POST['mail'] ) && isset($_POST['password'])){
     

        $preparedSql = $GLOBALS['database']->prepare('SELECT `id_utilisateur`, `nom`, `prenom`, `email`, `password`, `promo` FROM `utilisateur` ');
        // $preparedSql->bindvalue(":mail", $mail);
        // $preparedSql->bindvalue(":password", $password);
        $preparedSql->execute();
        $users = $preparedSql->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($users as $user) {
        if($_POST["mail"] == $user['email']  && $_POST["password"] == $user['password']){

          $status = "connected";
          $_SESSION["id"] = $user['id_utilisateur'];
          $_SESSION['id'] = User::encrypt_decrypt('encrypt', $_SESSION['id']);
          $msg = "Connexion réussi";    
        }
      }
      
    }
  

  echo json_encode(array("error"=>$error, "status"=>$status, "msg"=>$msg, "session"=>$_SESSION));

break;

case 'changePassword':

    $error = 0;
    $statut = 0;
    $msg = "Mot de passe incorrect";
    $user = new User($_SESSION["id"]);
    if($_POST["PasswordConfirme"] == $user->getPass()){
     
          $msg = "Changement réussi";    
        }
      
      
  

  echo json_encode(array("error"=>$error, "msg"=>$msg, "statut"=>$statut));

break;

case 'deconnexion':
  // $_SESSION['id'] = User::encrypt_decrypt('decrypt', $_SESSION['id']);
  session_destroy();
  error_log("tooooooooooooootttttoooooooooo");
  echo json_encode(0);
  break;
  
}
    ?>