<?php
 class LoginController{
  public $conn;

  public function __construct(){
    $db = new DatabaseConnection;
    $this->conn = $db->conn;
  }

  //Faz a autenticação do login
  public function userLogin($email, $password) {
    $checkLogin = "SELECT * FROM railway.usuario WHERE email = '$email' LIMIT 1";
    $result = $this->conn->query($checkLogin);

    if ($result->num_rows > 0) {
        // Usuário encontrado, cheque a senha
        $data = $result->fetch_assoc();
        
        // Verifica a senha hash utilizando: password_verify()
        if (password_verify($password, $data['senha'])) {
            $this->userAuthentication($data);
            return true;
        } else {
            // Senha não coincide
            return false;
        }
    } else {
        // Usuário não encontrado
        return false;
    }
}

  //Marca o usuário logado como autenticado e guarda suas informações nas variáveis.
  private function userAuthentication($data){
    $_SESSION['authenticated'] = true;
    $_SESSION['auth_user'] = [
        'id_usuario' => $data['idUsuario'],
        'fname_usuario' => $data['nome'],
        'lname_usuario' => $data['sobrenome'],
        'email_usuario' => $data['email'],
        'senha_usuario' => $data['senha'],
        'moderador_bool' => $data['moderador_bool'], // Add this line
    ];
}

  //Função que checa se o usuário já está logado, caso esteja ele é redirecionado para a página logged_index.php 
  public function isLoggedIn(){
    if(isset($_SESSION['authenticated']) === TRUE){
      redirect("Você já está logado!", "logged_index.php");
    }else{
      return false;
    }
  }
  //Se o botão de logout for acionado e o usuário estiver autenticado, a as variaveis e chaves da sessão terão o valor removido
  public function logout(){
    if(isset($_SESSION['authenticated']) === TRUE){
    unset($_SESSION['authenticated']);
    unset($_SESSION['auth_user']);
    return true;
    }else{
      return false;
    }
  }
}

?>