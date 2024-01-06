<?php
// include('config/app.php');
  class RegisterController{
    public $conn;
    public function __construct(){
      $db = new DatabaseConnection;
      $this->conn = $db->conn;
    }

    //Registra as informações de cadastro no banco de dados e retorna a inserção.
    public function registration($fname, $lname, $email, $password){

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $register_query = "INSERT INTO railway.usuario (nome, sobrenome, email, senha) VALUES ('$fname', '$lname', '$email', '$hashedPassword')";
      $result = $this->conn->query($register_query);
      return $result;
    }

    //Checa no banco de dados se o número de fileiras retornados com a SELECT query é maior que 0, se for, retorna true.
    public function isUserExists($email){
      $checkUser = "SELECT email FROM railway.usuario WHERE email='$email' LIMIT 1";
      $result = $this->conn->query($checkUser);
      if($result->num_rows > 0){
        return true;
      }else{
        return false;
      }
    }
    //Checa se as senhas coincidem e returna true (sim) ou false (não).
    public function confirmPassword($password, $confirmPassword){
      if($password == $confirmPassword){
        return true;
      }else{
        return false;
      }
    }
  }
?>