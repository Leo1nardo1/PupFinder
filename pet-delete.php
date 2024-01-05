<?php
include('config/app.php');
include_once('controllers/PetController.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $petId = validateInput($db->conn, $_GET['id']);

    $petController = new PetController();
    if ($petController->deletePet($petId)) {
       
        header('Location: user-profile.php'); 
        exit;
    } else {
        
        echo "Falha ao deletar o pet.";
    }
} else {
    
    echo "Requisição inválida.";
}
?>
