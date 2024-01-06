<?php

include('config/app.php');

class CatalogController{
  public $conn;

  public function __construct(){
    $db = new DatabaseConnection;
    $this->conn = $db->conn;
    $this->checkisLoggedIn();
  }
//Checa se o usuário está logado
  private function checkisLoggedIn(){
    if(!isset($_SESSION['authenticated'])){
      return false;
    }else{
      return true;
    }
  }
//Checa se o usuário está logado e extrai suas informações.
  public function authDetail(){
    $checkAuth = $this->checkIsLoggedIn();
    if($checkAuth){
      //extrai o id do usuário
      $user_id = $_SESSION['auth_user']['id_usuario'];
      //compara o id do usuário com o id do usuário no banco de dados.
      //Também seleciona todos os itens da fileira onde o id coincide. LIMIT 1 garante que apenas um registro seja entregue
      $getUserData = "SELECT * FROM railway.usuario WHERE idUsuario = '$user_id' LIMIT 1";
      //O resultado dessa query é colocado numa variável $result.
      $result = $this->conn->query($getUserData);
      if($result->num_rows > 0){
        //Caso o resultado retorne mais de uma fileira, as informações são colocadas dentro da variável $data.
        $data = $result->fetch_assoc();
        return $data;
      }else{
        redirect("Algo deu errado!", "login.php");
      }
    }else{
      return false;
    }
  }
}
$authenticated = new CatalogController;
?>




