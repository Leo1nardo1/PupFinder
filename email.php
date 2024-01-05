<?php
include('config/app.php');
include('controllers/PetController.php');

use PHPMailer\PHPMailer\PHPMailer;

//qualquer erro retire /
require '/vendor/autoload.php';

$petController = new PetController;

// Use $recipientEmail in your email-sending logic


if(isset($_POST['send'])){

    $name = htmlentities(($_POST['name']));
    $cellphone = htmlentities(($_POST['cellphone']));
    $comment = htmlentities(($_POST['comment']));
    $formEmail = htmlentities(($_POST['email']));
    $subject = "NOVA SOLICITACAO DE ADOCAO";
    $senderEmail = 'leonardo.jesus7@ba.estudante.senai.br';
    $petIdFromURL = isset($_GET['id']) ? $_GET['id'] : null;

    $mail = new PHPMailer(true);
    
    if ($petIdFromURL !== null) {
      $userId = $petController->getUserIDByPetID($petIdFromURL);
      if ($userId !== null) {
          $recipientEmail = $petController->getUserEmailById($userId);
          if ($recipientEmail) {
              $mail->addAddress($recipientEmail);
          } else {
              // Handle the case where the email couldn't be obtained (provide a default email or log an error)
              $mail->addAddress('default@example.com');
          }
      } else {
          // Handle the case where the user ID couldn't be obtained (provide a default user ID or log an error)
          $mail->addAddress('default@example.com');
      }
  } else {
      // Handle the case where the pet ID couldn't be obtained from the URL
      echo "Pet ID not found in the URL";
      exit;
  }

  
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'leonardo.jesus7@ba.estudante.senai.br';
    $mail->Password = 'grje onvo lrhl qrqr';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($senderEmail, 'PupFinder');

    $mail->Subject = "$senderEmail ($subject)";
    $mail->Body = "Nome do solicitante: $name <br> Telefone para contato: $cellphone <br> E-mail para contato: $formEmail <br> Comentário do solicitante: $comment ";
    $mail->send();

  
      header("Location: logged_index.php");
     
}
?>
