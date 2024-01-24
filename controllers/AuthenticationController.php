<?php

include('config/app.php');

class AuthenticationController{
  public $conn;

  public function __construct(){
    $db = new DatabaseConnection;
    $this->conn = $db->conn;
    $this->checkisLoggedIn();
  }

  private function checkisLoggedIn(){
    if(!isset($_SESSION['authenticated'])){
      redirect("Faça login para acessar a página!", "login.php");
      return false;
    }else{
      return true;
    }
  }

  public function authDetail(){
    $checkAuth = $this->checkisLoggedIn();
    if($checkAuth){
      $user_id = $_SESSION['auth_user']['id_usuario'];
      $getUserData = "SELECT * FROM usuario WHERE idUsuario = '$user_id' LIMIT 1";
      $result = $this->conn->query($getUserData);
      if($result->num_rows > 0){
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
$authenticated = new AuthenticationController;
?>