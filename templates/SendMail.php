<?php
require_once ('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function sendMail($userEmail, $userNom, $userPrenom, $userPassword) {
  $render = new \Twig\Loader\FilesystemLoader('../components/');
  $twig = new \Twig\Environment($render);
  
  $to = $userEmail;
  
  $mail = new PHPMailer(true);
  $mail->isSMTP();

  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "tls";
  $mail->Host = "smtp-mail.outlook.com";  //outlook SMTP server
  $mail->Port = 587;                    //SMTP port
  try {
    $mail->Username = "ProjetG-Materiel@outlook.fr";
    $mail->Password = "0Gestion_Materiel0" ; 

    $mail->setFrom("ProjetG-Materiel@outlook.fr", "Administrateur");
    $mail->addAddress($to, "$userNom $userPrenom");

    $mail->IsHTML(true);
    $mail->Subject = 'Bienvenue';      
    $mail->MsgHTML($twig->render('emailBody.html.twig', array(
      "email" => $userEmail,
      "nom" => $userNom,
      "prenom" => $userPrenom,
      "password" => $userPassword
    )));
    $mail->send();
    echo 'Le message a bien été envoyé.';
  } catch (phpmailerException $e) {
    echo $e->errorMessage(); 
  } catch (Exception $e) {
    echo $e->getMessage(); 
  }
}
    
?>