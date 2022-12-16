<?php
require_once ('../Entity/Database.php'); 
$db = new Database();
$GLOBALS['database'] = $db->mysqlConnexion(); 

switch($_POST['request'])
{
case 'connect':

  session_start();

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
          $msg = "Connexion réussi";    
        }
      }
      
    }
  

  echo json_encode(array("error"=>$error, "status"=>$status, "msg"=>$msg, "session"=>$_SESSION));

break;
}
    ?>