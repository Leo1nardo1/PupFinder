<?php

include('../config/app.php');
include_once('../controllers/PetController.php');

if (isset($_POST['update_pet'])) {
     
    $id = validateInput($db->conn, $_POST['idPet']);
    $inputData = [
        'especie' => validateInput($db->conn, $_POST['especie']),
        'nome' => validateInput($db->conn, $_POST['nome_pet']),
        'idade' => validateInput($db->conn, $_POST['idade']),
        'sexo' => validateInput($db->conn, $_POST['sexo']),
        'raca' => validateInput($db->conn, $_POST['raca']),
        'porte' => validateInput($db->conn, $_POST['porte']),
        'vacina_status' => validateInput($db->conn, $_POST['vacina_status']),
        'estado' => validateInput($db->conn, $_POST['estado']),
        'cidade' => validateInput($db->conn, $_POST['cidade']),
        'historia' => validateInput($db->conn, $_POST['historia']),
        'descricaoPersona' => validateInput($db->conn, $_POST['descricaoPersona']),
    ];
    $pet = new PetController;
    $result = $pet->update($inputData, $id); 
    if ($result) {
        redirect("", "user-profile.php");
    } else {
        redirect("Algo deu errado!", "pet-update.php");
    }
}



//Script de adição do pet
if (isset($_POST['add_pet'])) {
    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    // Validação de upload de imagem, primeiro checando se o campo não está vazio.
    if (!empty($_FILES['imagem']['name'])) {
        $fileType = mime_content_type($_FILES['imagem']['tmp_name']);
        var_dump($_FILES['imagem']);
        //caso não seja png, jpeg ou jpg, é indicado que o arquivo é inválido
        if (!in_array($fileType, $allowedFileTypes)) {
            redirect("Tipo de arquivo inválido!", "pet-register.php");
            exit;
        }

        // Limita o tamanho máximo da imagem
        $maxFileSize = 5 * 1024 * 1024; // 5 MB 
        if ($_FILES['imagem']['size'] > $maxFileSize) {
          redirect("A imagem é muito pesada!", "pet-register.php");
            exit;
        }

        $inputData = [
            'especie' => validateInput($db->conn, $_POST['especie']),
            'nome' => validateInput($db->conn, $_POST['nome_pet']),
            'idade' => validateInput($db->conn, $_POST['idade']),
            'sexo' => validateInput($db->conn, $_POST['sexo']),
            'raca' => validateInput($db->conn, $_POST['raca']),
            'porte' => validateInput($db->conn, $_POST['porte']),
            'vacina_status' => validateInput($db->conn, $_POST['vacina_status']),
            'estado' => validateInput($db->conn, $_POST['estado']),
            'cidade' => validateInput($db->conn, $_POST['cidade']),
            'imagem' => handleImageUpload($_FILES['imagem']),
            'historia' => validateInput($db->conn, $_POST['historia']),
            'descricaoPersona' => validateInput($db->conn, $_POST['descricaoPersona']),
        ];

        $pet = new PetController;
        //Insere dados digitados pelo usuário no banco de dados
        $result = $pet->create($inputData);

        if ($result) {
            redirect("Pet Adicionado com sucesso", "pet-register.php");
        } else {
            redirect("Algo deu errado!", "pet-register.php");
        }
    } else {
      redirect("Imagem não selecionada!", "pet-register.php");
        exit;
    }
    

    
}


//Lida com as imagens selecionadas. 
function handleImageUpload($file) {
    //Coloca como diretório alvo a pasta "uploads"
    $targetDir = "uploads/";
    //Cria um nome único para cada imagem
    $targetFile = $targetDir . uniqid() . '_' . basename($file['name']);
    
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $targetFile;
    } else {
        return false;
    }
}
?>