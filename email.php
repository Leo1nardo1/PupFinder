
<?php
include('controllers/AuthenticationController.php');
include('controllers/PetController.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

//qualquer erro retire /
require 'vendor/autoload.php';

$petController = new PetController;

if(isset($_POST['send'])){
    $name = htmlentities($_POST['name']);
    $cellphone = htmlentities($_POST['cellphone']);
    $comment = htmlentities($_POST['comment']);
    $formEmail = htmlentities($_POST['email']);
    $subject = "NOVA SOLICITACAO DE ADOCAO";
    $senderEmail = '@gmail.com';
    $petIdFromURL = isset($_GET['id']) ? $_GET['id'] : null;

    $mail = new PHPMailer(true);
    
    try {
        if ($petIdFromURL !== null) {
            $userId = $petController->getUserIDByPetID($petIdFromURL);
            if ($userId !== null) {
                $recipientEmail = $petController->getUserEmailById($userId);
                if ($recipientEmail) {
                    $mail->addAddress($recipientEmail);
                } else {
                    // Handle the case where the email couldn't be obtained (provide a default email or log an error)
                    $mail->addAddress($senderEmail);
                }
            } else {
                // Handle the case where the user ID couldn't be obtained (provide a default user ID or log an error)
                $mail->addAddress($senderEmail);
            }
        } else {
            // Handle the case where the pet ID couldn't be obtained from the URL
            throw new Exception("Pet ID not found in the URL");
        }

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '@gmail.com';
        $mail->Password = '';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom($senderEmail, 'PupFinder');
        $mail->Subject = "$senderEmail ($subject)";
        $mail->Body = "Nome do solicitante: $name <br> Telefone para contato: $cellphone <br> E-mail para contato: $formEmail <br> Comentário do solicitante: $comment ";
        $mail->send();

        ob_start(); // Start output buffering
    header("Location: logged_index.php");
    ob_end_flush(); // Flush the output buffer and send the header
    
    } catch (Exception $e) {
        // Handle the exception (log it, display a message, etc.)
        echo "Error sending email: " . $e->getMessage();
        // You can redirect to pet-catalog.php or any other error page
        header("Location: pet-catalog.php");
    }
}
?>
