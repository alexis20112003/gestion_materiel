<?php
require_once('../vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{

    function sendMailPassword($userEmail, $userNom, $userPrenom, $userPassword, $emailModel)
    {
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
            $mail->Password = "0Gestion_Materiel0";

            $mail->setFrom("ProjetG-Materiel@outlook.fr", "Administrateur");
            $mail->addAddress($to, "$userNom $userPrenom");

            $mail->IsHTML(true);
            $mail->Subject = 'Bienvenue';
            $mail->MsgHTML($twig->render($emailModel, array(
                "email" => $userEmail,
                "nom" => $userNom,
                "prenom" => $userPrenom,
                "password" => $userPassword
            )));
            $mail->send();
            $message = 'Le mail a bien été envoyé.';
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $message;
    }

    function sendMailNotification($userEmail, $info)
    {
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
            $mail->Password = "0Gestion_Materiel0";

            $mail->setFrom("ProjetG-Materiel@outlook.fr", "Administrateur");
            $mail->addAddress($to, "admin");

            $mail->IsHTML(true);
            $mail->Subject = 'Bienvenue';
            $mail->MsgHTML($twig->render('emailBodyNotification.html.twig', array(
                "info" => $info,
            )));
            $mail->send();
            $message = 'Le mail a bien été envoyé.';
            echo 'Le message a bien été envoyé.';
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $message;
    }
}
