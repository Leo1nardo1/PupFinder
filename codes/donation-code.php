<?php

include('../config/app.php');
include_once('../controllers/PetController.php');

if (isset($_POST['donated_pet'])) {
    $idPet = validateInput($db->conn, $_POST['idPet']);

    // Update statusPet column in the Pet table
    $updatePetStatusQuery = "UPDATE railway.pet SET statusPet = 0 WHERE idPet = '$idPet'";
    $resultUpdatePetStatus = $db->conn->query($updatePetStatusQuery);

    // Insert a new row in the historico_pet table
    $userId = $_SESSION['auth_user']['id_usuario'];
    $currentDate = date('Y-m-d');
    $insertHistoricoQuery = "INSERT INTO railway.historico_pet (Usuario_idUsuario, Pet_idPet, data_operacao, tipo_operacao)
                             VALUES ('$userId', '$idPet', '$currentDate', 'Adocao')";
    $resultInsertHistorico = $db->conn->query($insertHistoricoQuery);

    if ($resultUpdatePetStatus && $resultInsertHistorico) {
        // Successful donation confirmation
        redirect("", "user-profile.php?id=$idPet");
    } else {
        // Handle errors accordingly
        redirect("Erro ao confirmar doação", "pet-update.php?id=$idPet");
    }
}

?>