<?php
class PetController{
  public $conn;

  public function __construct(){
    $db = new DatabaseConnection;
    $this->conn = $db->conn;
  }

  //Busca todos os pets da tabela Pet
  public function index(){
    $petQuery = "SELECT * FROM Pet WHERE status_delecao = 0";
    $result = $this->conn->query($petQuery);
    if($result->num_rows > 0){
        return $result;
    } else {
        return false;
    }
}
  //Busca os pets com id coincidentes
  public function getPetDetailsById($petId) {
    $petQuery = "SELECT p.idPet, p.imagem, p.statusPet, p.nome, p.idade, p.sexo, p.raca, p.estado, p.cidade, p.descricaoPersona, p.historia, p.porte, p.vacina_status, p.especie, p.status_delecao, h.Usuario_idUsuario
    FROM Pet p
    JOIN historico_pet h ON p.idPet = h.Pet_idPet
    WHERE p.idPet = $petId";
    $result = $this->conn->query($petQuery);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return pet details as an associative array
    } else {
        return false;
    }
}

  //Busca os pets a partir do filtro escolhido pelo usuario armazenado na variável $filterData
  public function indexWithFilters($filterData){
    $conditions = [];

    foreach ($filterData as $key => $value) {
        if (!empty($value)) {
            $conditions[] = "$key = '$value'";
        }
    }

    //Condição para status_delecao
    $conditions[] = "status_delecao = 0";

    $whereClause = implode(" AND ", $conditions);

    // Verifica se há alguma condição antes de construir a consulta SQL
    $petQuery = "SELECT * FROM Pet";
    if (!empty($whereClause)) {
        $petQuery .= " WHERE $whereClause";
    }


    $result = $this->conn->query($petQuery);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}




  public function create($inputData) {
    //concatena todas as informações dadas pelo usuario com vírgulas e aspas simples e insere no banco de dados
    $data = "'" . implode("','", $inputData) . "'";
    $petQuery = "INSERT INTO Pet(especie, nome, idade, sexo, raca, porte, vacina_status, estado, cidade, imagem, historia, descricaoPersona) VALUES ($data)";

    $result = $this->conn->query($petQuery);

    if ($result) {
        //Aloca o id do ultimo pet inserido na variavel $lastPetId
        $lastPetId = $this->conn->insert_id;

        // Pega o id do usuário na sessão
        $userId = $_SESSION['auth_user']['id_usuario'];

        // Insere as informações na tabela "historico_pet"
        $dataOperacao = date("Y-m-d");
        $tipoOperacao = "Registro";

        $historicoQuery = "INSERT INTO historico_pet(Usuario_idUsuario, Pet_idPet, data_operacao, tipo_operacao) 
                           VALUES ('$userId', '$lastPetId', '$dataOperacao', '$tipoOperacao')";

        $historicoResult = $this->conn->query($historicoQuery);

        if ($historicoResult) {
            return true;
        } else {
            // Rollback na inserção do pet se a inserção no historico_pet falhar.
            $this->conn->query("UPDATE Pet SET erro_registro = 1 WHERE idPet = '$lastPetId'");
            return false;
        }
    } else {
        return false;
    }

    

}

public function getUserPets($userId) {
  $petQuery = "SELECT p.*, h.tipo_operacao
                FROM Pet p
                JOIN historico_pet h ON p.idPet = h.Pet_idPet
                WHERE h.Usuario_idUsuario = '$userId'
                ORDER BY h.idHistorico DESC";

  $result = $this->conn->query($petQuery);

  if ($result && $result->num_rows > 0) {
      return $result;
  } else {
      return false;
  }
}

public function getUserRegisteredPets($userId) {
    $petQuery = "SELECT p.*, h.tipo_operacao
                 FROM Pet p
                 JOIN historico_pet h ON p.idPet = h.Pet_idPet
                 WHERE h.Usuario_idUsuario = '$userId' AND h.tipo_operacao = 'Registro'
                   AND p.statusPet = 1
                   AND p.status_delecao = 0
                 AND h.idHistorico = (
                     SELECT MAX(idHistorico)
                     FROM historico_pet
                     WHERE Pet_idPet = p.idPet
                 )
                 ORDER BY h.idHistorico DESC";

    $result = $this->conn->query($petQuery);

    if ($result && $result->num_rows > 0) {
        return $result;
    } else {
        return false;
    }
}

public function getUserPetCount($userId) {
    $countQuery = "SELECT COUNT(*) AS petCount
                   FROM (
                       SELECT MAX(idHistorico) AS maxId
                       FROM historico_pet
                       WHERE Usuario_idUsuario = '$userId'
                       GROUP BY Pet_idPet
                   ) AS latestHistories
                   JOIN historico_pet h ON latestHistories.maxId = h.idHistorico
                   JOIN Pet p ON h.Pet_idPet = p.idPet
                   WHERE h.tipo_operacao = 'Registro' AND p.status_delecao = 0";

    $result = $this->conn->query($countQuery);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['petCount'];
    } else {
        return 0;
    }
}

public function getUserDonatedPetCount($userId) {
  $countQuery = "SELECT COUNT(*) as count FROM historico_pet WHERE Usuario_idUsuario = '$userId' AND tipo_operacao = 'Adocao'";
  $result = $this->conn->query($countQuery);

  if ($result && $result->num_rows > 0) {
      $countData = $result->fetch_assoc();
      return $countData['count'];
  } else {
      return 0;
  }
}

public function edit($id){
  $pet_id = validateInput($this->conn, $id);
  $petQuery = "SELECT * FROM Pet WHERE idPet = '$pet_id' LIMIT 1";
  $result = $this->conn->query($petQuery);
  if($result->num_rows == 1){
    $data = $result->fetch_assoc();
    return $data;
  }else{
    return false;
  }
}


public function update($inputData, $id){
  $pet_id = validateInput($this->conn, $id);
  $nome = $inputData['nome'];
  $idade = $inputData['idade'];
  $sexo = $inputData['sexo'];
  $raca = $inputData['raca'];
  $estado = $inputData['estado'];
  $cidade = $inputData['cidade'];
  $descricaoPersona = $inputData['descricaoPersona'];
  $historia = $inputData['historia'];
  $porte = $inputData['porte'];
  $vacinaStatus = $inputData['vacina_status'];
  $especie = $inputData['especie'];

  $petUpdateQuery = "UPDATE Pet 
                     
                     SET nome = '$nome', idade ='$idade', sexo ='$sexo', raca ='$raca', estado ='$estado', cidade ='$cidade', descricaoPersona ='$descricaoPersona', historia ='$historia', porte ='$porte', vacina_status ='$vacinaStatus', especie ='$especie'
                     
                     WHERE idPet = '$pet_id'  LIMIT 1";
    $result = $this->conn->query($petUpdateQuery);
    if($result){
      return true;
    }else{
      return false;
    }

}

public function getLastOperation($petId) {
  $query = "SELECT tipo_operacao
            FROM historico_pet
            WHERE Pet_idPet = '$petId'
            ORDER BY idHistorico DESC
            LIMIT 1";

  $result = $this->conn->query($query);

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['tipo_operacao'];
  } else {
      return '';
  }
}

public function deletePet($petId) {
  // Mark the pet as deleted in the database
  $updateQuery = "UPDATE Pet SET status_delecao = 1 WHERE idPet = '$petId'";
  
  $result = $this->conn->query($updateQuery);

  if ($result) {
      // Successfully marked as deleted
      return true;
  } else {
      // Failed to mark as deleted
      return false;
  }
}

public function getUserEmailById($userId) {
    $query = "SELECT usuario.email
              FROM usuario
              JOIN historico_pet ON usuario.idUsuario = historico_pet.Usuario_idUsuario
              WHERE historico_pet.Usuario_idUsuario = '$userId'
                AND historico_pet.tipo_operacao = 'Registro'
              ORDER BY historico_pet.idHistorico DESC
              LIMIT 1";

    $result = $this->conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['email'];
    } else {
        // Return a default email or handle the case
        return "default@example.com";
    }
}

public function getUserIDByPetID($petId) {
    $query = "SELECT Usuario_idUsuario
              FROM historico_pet
              WHERE Pet_idPet = '$petId'
              ORDER BY idHistorico DESC
              LIMIT 1";

    $result = $this->conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['Usuario_idUsuario'];
    } else {
        // Return a default user ID or handle the case
        return null;
    }
}

}

?>