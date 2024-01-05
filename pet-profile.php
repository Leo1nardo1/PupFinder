<?php
include_once('controllers/CatalogController.php');
$data = $authenticated->authDetail();
include_once('controllers/PetController.php');

// Captura o ID do pet na url
$petId = isset($_GET['id']) ? $_GET['id'] : null;

// Valida o ID do pet, checa se não é numérico e se é menor ou igual a 0
if (!is_numeric($petId) || $petId <= 0) {
    header('Location: pet-catalog.php');
    exit;
}

$pets = new PetController();

// Captura os detalhes do chat baseado no seu ID
$petDetails = $pets->getPetDetailsById($petId);

// Checa se os detalhes foram capturados corretamente
if (!$petDetails) {
    header('Location: pet-catalog.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/pet_profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>PupFinder</title>
</head>

<body>

    <div class="central">
        <header>

            <?php if (isset($_SESSION['authenticated'])) : ?>
                <a href="<?= base_url('logged_index.php') ?>" class="logo">
                <?php else : ?>
                    <a href="<?= base_url('index.php') ?>" class="logo">
                    <?php endif; ?>
                    <img src="assets/imagens/logo.png" class="logo-img">PupFinder</a>

                    <input type="checkbox" id="chk-toggle" />
                    <label id="toggle" for="chk-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </label>
                    <nav>
                        <ul>
                            <?php if (isset($_SESSION['authenticated'])) : ?>
                                <li><a href="<?= base_url('logged_index.php#quem') ?>" class="navbar-link">Quem Somos?</a></li>
                            <?php else : ?>
                                <li><a href="<?= base_url('index.php#quem') ?>" class="navbar-link">Quem Somos?</a></li>
                            <?php endif; ?>
                            <li><a href="<?= base_url('pet-catalog.php') ?>" class="navbar-link">Quero Adotar</a></li>
                            <?php if (isset($_SESSION['authenticated'])) : ?>
                                <li><a href="<?= base_url('logged_index.php#ajudar') ?>" class="navbar-link">Quero Ajudar</a></li>
                            <?php else : ?>
                                <li><a href="<?= base_url('index.php#ajudar') ?>" class="navbar-link">Quero Ajudar</a></li>
                            <?php endif; ?>
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
                            <?php else : ?>
                                <li><a href="<?= base_url('login.php') ?>" class="btn-login">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
        </header>
    </div>


    <?php
    include('message.php');
    ?>

    <main>
        <div class="container">
            <div class="box">
                <div class="images">
                    <div class="img-holder active">
                        <img src="codes/<?= $petDetails['imagem'] ?>">
                    </div>
                </div>
                <div class="basic-info">
                    <h1><?= $petDetails['nome'] ?></h1>
                    <div class="rate">
                        <p><?= $petDetails['idade'] ?> / Porte <?= $petDetails['porte'] ?> / <?= $petDetails['sexo'] ?></p>
                    </div>
                    <span><?= $petDetails['estado'] ?>, <?= $petDetails['cidade'] ?></span>
                    <?php
                    $lastOperation = $pets->getLastOperation($petDetails['idPet']);
                    $adoptionStatusClass = ($lastOperation == 'Adocao') ? 'hidden' : '';
                    ?>
                    <div class="options <?= $adoptionStatusClass ?>">
                        <a href="#" id="interestedBtn">Estou interessado</a>
                    </div>
                </div>
                <div class="description">
                    <h4>História</h4>
                    <p><?= $petDetails['historia'] ?></p>
                    <h4>Personalidade</h4>
                    <p><?= $petDetails['descricaoPersona'] ?></p>
                    <ul class="features">
                        <li>Raça: <?= $petDetails['raca'] ?></li>
                        <li>Status de Vacina: <?= $petDetails['vacina_status'] ?></li>
                    </ul>
                </div>
            </div>
        </div>

    </main>


    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="combinedForm" method="POST" action="email.php<?= isset($_GET['id']) ? '?id=' . $_GET['id'] : '' ?>">
                <h2>Notifique o dono</h2>

                <div class="input-group">
                    <label for="name">Nome e sobrenome:</label>
                    <input name="name" type="text" placeholder="Digite o seu nome e sobrenome" class="feedback-input" id="name" autocomplete="off" />
                </div>

                <div class="input-group">
                    <label for="email">E-mail:</label>
                    <input name="email" type="email" placeholder="Digite o seu e-mail" class="feedback-input" id="email" autocomplete="off" required />
                </div>

                <div class="input-group">
                    <label for="cellphone">Telefone:</label>
                    <input name="cellphone" min="0" type="number" placeholder="Digite o seu telefone" class="feedback-input" id="cellphone" autocomplete="off" />
                </div>

                <div class="input-group">
                    <label for="comment">Comentários adicionais:</label>
                    <textarea name="comment" class="feedback-input" id="comment" autocomplete="off"></textarea>
                </div>

                <div class="submit">
                    <input type="submit" name="send" value="Enviar" id="button-blue" />
                </div>

                <!-- Add a hidden input field to include the owner's email -->
                <input type="hidden" name="ownerEmail" value="<?= $userEmail ?>" />
            </form>
        </div>
    </div>

    <script>
      
        var modal = document.getElementById("myModal");

        var btn = document.getElementById("interestedBtn");

        var span = document.getElementsByClassName("close")[0];

        
        btn.onclick = function() {
            modal.style.display = "block";
        }

      
        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>



    <!-- <i class="fa-solid fa-circle-check"></i>
    <i class="fa-solid fa-circle-xmark"></i> -->

    <?php
    include('includes/footer.php');
    ?>