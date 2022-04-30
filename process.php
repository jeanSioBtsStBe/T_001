<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once './lib/PHPMailer.php';
require_once './lib/Exception.php';
require_once './lib/SMTP.php';

$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['name']) && !empty($data['name'])) {
    $name = $data['name'];
    if (isset($data['firstName']) && !empty($data['firstName'])) {
        $firstname = $data['firstName'];
        if (isset($data['mail']) && !empty($data['mail'])) {
            $mailExp = $data['mail'];
            if (isset($data['society']) && !empty($data['society'])) {
                $society = $data['society'];
                if (isset($data['message']) && !empty($data['message'])) {
                    $message = $data['message'];

                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Adresse IP ou DNS du serveur SMTP
                    $mail->Port = 465; // Port TCP du serveur SMTP
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encryptage
                    $mail->SMTPAuth = true; // Utiliser l'identification
                    $mail->CharSet = 'UTF-8';

                    $mail->Username   =  'testemaildeveloppement01@gmail.com'; // Adresse email à utiliser
                    $mail->Password   =  'cyduuqsoqisrumrf'; // Mot de passe de l'adresse email à utiliser

                    $mail->setFrom($mailExp, 'First Last'); // L'email à afficher pour l'envoi
                    $mail->addAddress('alexg.devpro@gmail.com'); // L'adresse du destinataire
                    $mail->Subject    =  'Contact depuis Docolab'; // Le sujet du mail
                    $mail->msgHTML(
                        '<h1 style="font-size: 22px">'.'Expéditeur : '.'</h1><br>'.
                        '<p>'.$mailExp.'</p><br>'.
                        '<h2 style="font-size: 18px">'.'Contenu du message : '.'</h2><br>'.
                        '<p>'.$message.'</p>'
                    ); // Le message en HTML
                    $mail->AltBody = $message; // Message en text brut

                    if (!$mail->send()) {
                        $data_error = ["code" => "500", "status" => 'Erreur: ' . $mail->ErrorInfo];
                        echo json_encode($data_error);
                    } else{
                        $data_ok = ["code" => "200", "status" => "Message bien envoyé"];
                        echo json_encode($data_ok);
                    }
                } else {
                    $data_error = ["code" => "500", "status" => 'Merci de remplir le champ "Message".'];
                    echo json_encode($data_error);
                }
            } else {
                $data_error = ["code" => "500", "status" => 'Merci de remplir le champ "Société".'];
                echo json_encode($data_error);
            }
        } else {
            $data_error = ["code" => "500", "status" => 'Merci de remplir le champ "e-mail".'];
            echo json_encode($data_error);
        }
    } else {
        $data_error = ["code" => "500", "status" => 'Merci de remplir le champ "Prénom".'];
        echo json_encode($data_error);
    }
} else {
    $data_error = ["code" => "500", "status" => 'Merci de remplir le champ "Nom".'];
    echo json_encode($data_error);
}