<?php
include_once('controllers/AuthenticationController.php');
$data = $authenticated->authDetail();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/pet_register.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>PupFinder</title>
</head>

<body>

  <div class="central">
    <header>

      <a href="<?= base_url('logged_index.php') ?>" class="logo"><img src="assets/imagens/logo.png" class="logo-img">PupFinder</a>

      <input type="checkbox" id="chk-toggle" />
      <label id="toggle" for="chk-toggle">
        <span></span>
        <span></span>
        <span></span>
      </label>
      <nav>
        <ul>
        <li><a href="<?= base_url('logged_index.php#quem') ?>" class="navbar-link">Quem Somos?</a></li>
        <li><a href="<?= base_url('pet-catalog.php') ?>" class="navbar-link">Quero Adotar</a></li>
        <li><a href="<?= base_url('logged_index.php#ajudar') ?>" class="navbar-link">Quero Ajudar</a></li>
          <li><a href="#" class="navbar-link">Produtos</a></li>
          <li><a href="#" class="navbar-link">Fórum</a></li>
          <li><a href="#" class="navbar-link">Blog</a></li>
          <?php if (isset($_SESSION['authenticated'])) : ?>
            <li>
              <a href="user-profile.php" class="navbar-link"><?= $_SESSION['auth_user']['fname_usuario'] . " " . $_SESSION['auth_user']['lname_usuario']; ?> <i class="fa-solid fa-user"></i>
              </a>
            </li>

            <li>
              <form action="" method="POST">
                <button type="submit" name="logout_btn" class="logout-btn">Sair</button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>
  </div>


  <?php
  include('message.php');
  ?>


  <main>

    <section class="container">
      <div class="form-header">Cadastro de Pet</div>
      <form action="codes/pet-code.php" method="POST" class="form" enctype="multipart/form-data">

        <label>Espécie</label>
        <div class="select-box">
          <select name="especie">
            <option hidden value="">Escolha a espécie</option>
            <option value="Cachorro">Cachorro</option>
            <option value="Gato">Gato</option>
          </select>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Nome</label>
            <input type="text" name="nome_pet" placeholder="Digite o nome" required />
          </div>

          <div class="input-box">
            <label>Idade</label>
            <input type="text" name="idade" placeholder="Digite a idade" maxlength="9" required />
          </div>
        </div>

        <label>Sexo</label>
        <div class="select-box">
          <select name="sexo">
            <option hidden value="">Escolha o sexo</option>
            <option value="Macho">Macho</option>
            <option value="Fêmea">Fêmea</option>
          </select>
        </div>

        <div class="column">
          <div class="input-box">
            <label>Raça</label>
            <input type="text" name="raca" placeholder="Digite o nome da raça" required />
          </div>
        </div>

        <label>Porte</label>
        <div class="select-box">
          <select name="porte">
            <option hidden value="">Escolha o porte</option>
            <option value="Pequeno">Pequeno</option>
            <option value="Médio">Médio</option>
            <option value="Grande">Grande</option>
          </select>
        </div>

        <label>Status de Vacinação</label>
        <div class="select-box">
          <select name="vacina_status">
            <option hidden value="">Escolha o status</option>
            <option value="Completo">Completo</option>
            <option value="Parcial">Parcial</option>
            <option value="Não vacinado">Não vacinado</option>
          </select>
        </div>


        <div class="column">
          <div class="input-box">
            <label>Estado</label>
            <input type="text" name="estado" placeholder="Digite o estado" required />
          </div>
          <div class="input-box">
            <label>Cidade</label>
            <input type="text" name="cidade" placeholder="Digite a cidade" required />
          </div>
        </div>


        <div class="input-box">
          <label>Imagem do Pet</label>
          <input type="file" name="imagem" required accept="image/jpg, image/png, image/jpeg" />
        </div>


        <div class="input-box">
          <label>Historia do Pet</label>
          <textarea name="historia" placeholder="Descreva a história do pet" rows="4" maxlength="255" required></textarea>
        </div>

        <div class="input-box">
          <label>Personalidade do Pet</label>
          <textarea name="descricaoPersona" placeholder="Descreva a personalidade do pet" maxlength="255" rows="4" required></textarea>
        </div>

        <button type="submit" name="add_pet">Cadastrar Pet</button>
      </form>
    </section>

  </main>







  <?php
  include('includes/footer.php');
  ?>