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

  if(isset($_POST['register_btn'])){
    //Recebe e valida as informações digitadas pelo usuário.
    $fname = validateInput($db->conn, $_POST['fname']);
    $lname = validateInput($db->conn, $_POST['lname']);
    $email = validateInput($db->conn, $_POST['email']);
    $password = validateInput($db->conn, $_POST['password']);
    $confirm_password = validateInput($db->conn, $_POST['confirm_password']);

    $register = new RegisterController;
    //Coloca o resultado da função confirmPassword na variável result_password
    $result_password = $register->confirmPassword($password, $confirm_password);
    //Caso a senha esteja correta, ele checa se o email já está registrado no banco de dados
    if($result_password){
      $result_user = $register->isUserExists($email);
      if($result_user){
        redirect("E-mail já cadastrado!", "login.php");
      }else{
        //Caso o e-mail não esteja cadastrado, registra os dados no banco de dados e finaliza cadastro.
        $register_query = $register->registration($fname, $lname, $email, $password);
        if($register_query){
          redirect("Cadastro realizado com sucesso!", "login.php");
        }else{
          redirect("Algo deu errado.", "login.php");
        }
      }
    }
  }
?>