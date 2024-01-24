<?php
  // include('config/app.php');
  
include_once(__DIR__ . '/../controllers/RegisterController.php');
include_once(__DIR__ . '/../controllers/LoginController.php');

  $auth = new LoginController;

  if(isset($_POST['logout_btn'])){
    $checkLogggedOut = $auth->logout();
    if($checkLogggedOut){
      redirect("", "index.php");
    }
  }

  if(isset($_POST['login_btn'])){
    $email = validateInput($db->conn, $_POST['email']);
    $password= validateInput($db->conn, $_POST['password']);

    
    $checkLogin = $auth->userLogin($email, $password);
    if($checkLogin){
      redirect("Seja Bem Vindo!", "logged_index.php");
    }else{
      redirect("E-mail ou senha inválidos!", "login.php");
    }

  }



  if (isset($_POST['register_btn'])) {
    $fname = validateInput($db->conn, $_POST['fname']);
    $lname = validateInput($db->conn, $_POST['lname']);
    $email = validateInput($db->conn, $_POST['email']);
    $password = validateInput($db->conn, $_POST['password']);
    $confirm_password = validateInput($db->conn, $_POST['confirm_password']);

    // Improved email validation using API
    $api_key = "";
    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=$api_key&email=$email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    $data = json_decode($response, true);

    // Check if the email is undeliverable or disposable
    if ($data['deliverability'] === "UNDELIVERABLE") {
        redirect("E-mail não existe!", "login.php");
    }

    if ($data["is_disposable_email"]["value"] === true) {
        redirect("E-mail é descartável!", "login.php");
    }

    // Continue with the rest of your registration logic
    $register = new RegisterController;
    $result_password = $register->confirmPassword($password, $confirm_password);

    if ($result_password) {
        $result_user = $register->isUserExists($email);

        if ($result_user) {
            redirect("E-mail já cadastrado!", "login.php");
        } else {
            $register_query = $register->registration($fname, $lname, $email, $password);

            if ($register_query) {
                redirect("Cadastro realizado com sucesso!", "login.php");
            } else {
                redirect("Algo deu errado.", "login.php");
            }
        }
    }
}

?>