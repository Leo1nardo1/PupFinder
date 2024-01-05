<?php
include('config/app.php');
$auth->isLoggedIn();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login_page.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>PupFinder</title>
</head>

<body>

    <div class="central">
        <header>

            <a href="<?= base_url('index.php') ?>" class="logo"><img src="assets/imagens/logo.png" class="logo-img">PupFinder</a>

            <input type="checkbox" id="chk-toggle" />
            <label id="toggle" for="chk-toggle">
                <span></span>
                <span></span>
                <span></span>
            </label>
            <nav>
                <ul>
                    <li><a href="<?= base_url('index.php#quem') ?>" class="navbar-link">Quem Somos?</a></li>
                    <li><a href="<?= base_url('pet-catalog.php') ?>" class="navbar-link">Quero Adotar</a></li>
                    <li><a href="<?= base_url('index.php#ajudar') ?>" class="navbar-link">Quero Ajudar</a></li>
                    <li><a href="#" class="navbar-link">Produtos</a></li>
                    <li><a href="#" class="navbar-link">Fórum</a></li>
                    <li><a href="#" class="navbar-link">Blog</a></li>
                    <li><a href="<?= base_url('login.php') ?>" class="btn-login">Login</a></li>
                </ul>
            </nav>
        </header>
    </div>


    <?php
    include('message.php');
    ?>

    <main>

        <div class="box">

            <div class="inner-box">
                <div class="forms-wrap">

                    <!--FORMULÁRIO DE LOGIN-->

                    <form action="" method="POST" autocomplete="off" class="sign-in-form">
                        <div class="logo-form">
                            <img src="assets/imagens/logo.png" alt="PupFinder">
                            <h3>PupFinder</h3>
                        </div>
                        <div class="heading-form">
                            <h2>Bem Vindo de Volta</h2>
                            <h6>Não está cadastrado?</h6>
                            <a href="#" class="toggle-form">Cadastre-se</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="email" name="email" autocomplete="off" required class="input-field" />
                                <label>Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" name="password" minlength="4" autocomplete="off" required class="input-field" />
                                <label>Senha</label>
                            </div>

                            <input type="submit" name="login_btn" value="Entrar" class="sign-btn">
                            <p class="text">
                                Esqueceu a sua senha?
                                <a href="#">Recuperar senha</a>
                            </p>
                        </div>
                    </form>



                    <!--FORMULARIO DE CADASTRO-->

                    <form id="registrationForm" action="" method="POST" autocomplete="off" class="sign-up-form">
                        <div class="logo-form">
                            <img src="assets/imagens/logo.png" alt="PupFinder">
                            <h3>PupFinder</h3>
                        </div>
                        <div class="heading-form">
                            <h2>Comece Agora</h2>
                            <h6>Já tem uma conta?</h6>
                            <a href="#" class="toggle-form">Entrar</a>
                        </div>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" autocomplete="off" name="fname" required class="input-field" />
                                <label>Nome</label>
                            </div>
                            <div class="input-wrap">
                                <input type="text" autocomplete="off" name="lname" required class="input-field" />
                                <label>Sobrenome</label>
                            </div>
                            <div class="input-wrap">
                                <input type="email" autocomplete="off"   name="email" required class="input-field" />
                                <label>Email</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" id="password" minlength="4" name="password" autocomplete="off" required class="input-field" />
                                <label for="password">Senha</label>
                            </div>
                            <div class="input-wrap">
                                <input type="password" id="conf-password" minlength="4" name="confirm_password" autocomplete="off" required class="input-field" />
                                <label for="conf-password">Confirmar Senha</label>

                            </div>
                            <p id="confirmar_senha"></p>
                            <input type="submit" value="Cadastrar" onclick="checarSenha()" name="register_btn" class="sign-btn">

                            <p class="text">
                                Ao me cadastrar, concordo com os <a href="#">Termos de Serviço</a> e a
                                <a href="#">Política de Privacidade</a>
                            </p>
                        </div>
                    </form>

                </div>
                <div class="carousel"></div>
            </div>
        </div>
    </main>







    <?php
    include('includes/footer.php');
    ?>