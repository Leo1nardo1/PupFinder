<?php
include('config/app.php');
include_once('controllers/PetController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $petId = validateInput($db->conn, $_POST['id']);

    $petController = new PetController();

    // Directly delete the pet for moderators
    if (isset($_SESSION['auth_user']['moderador_bool']) && $_SESSION['auth_user']['moderador_bool'] == 1) {
        if ($petController->deletePet($petId)) {
            header('Location: user-profile.php'); 
            exit;
        } else {
            echo "Falha ao deletar o pet.";
        }
    } else {
        echo "Você não tem permissão para deletar este pet.";
        exit;
    }
} else {
    echo "Requisição inválida.";
}