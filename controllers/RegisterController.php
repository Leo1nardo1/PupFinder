<?php
// include('config/app.php');
class RegisterController{
    public $conn;
    
    public function __construct(){
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    // Registra as informações de cadastro no banco de dados e retorna a inserção.
    public function registration($fname, $lname, $email, $password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Previne injeção SQL
        $register_query = $this->conn->prepare("INSERT INTO usuario (nome, sobrenome, email, senha) VALUES (?, ?, ?, ?)");
        $register_query->bind_param("ssss", $fname, $lname, $email, $hashedPassword);

        
        $result = $register_query->execute();
    
        $register_query->close();

        return $result;
    }

    // Checa no banco de dados se o número de fileiras retornados com a SELECT query é maior que 0, se for, retorna true.
    public function isUserExists($email){
        // Use prepared statement to prevent SQL injection
        $checkUser = $this->conn->prepare("SELECT email FROM usuario WHERE email=? LIMIT 1");
        $checkUser->bind_param("s", $email);

        
        $checkUser->execute();

       
        $checkUser->store_result();

        // Check if the user exists
        $exists = $checkUser->num_rows > 0;

        // Close the statement
        $checkUser->close();

        return $exists;
    }

    // Checa se as senhas coincidem e retorna true (sim) ou false (não).
    public function confirmPassword($password, $confirmPassword){
        return ($password == $confirmPassword);
    }


}