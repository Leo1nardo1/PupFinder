<?php
include_once('controllers/AuthenticationController.php');
$data = $authenticated->authDetail();
include_once('controllers/PetController.php');

$userId = $_SESSION['auth_user']['id_usuario'];
$petController = new PetController();
$userPetCount = $petController->getUserPetCount($userId);
$userDonatedPetCount = $petController->getUserDonatedPetCount($userId);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/user_profile.css">
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

    <h1>Olá, <?= $data['nome'] ?></h1>



    <div class="content">
        <div class="cards">
            <div class="card">
                <div class="box">
                    <h1><?= $userPetCount ?></h1>
                    <h3>Pets cadastrados</h3>
                </div>
                <div class="icon-case">
                    <img src="assets/imagens/puppy.png" alt="">
                </div>
            </div>
            <div class="card">
                <div class="box">
                    <h1><?= $userDonatedPetCount ?></h1>
                    <h3>Pets doados</h3>
                </div>
                <div class="icon-case">
                    <img src="assets/imagens/puppy.png" alt="">
                </div>
            </div>
            <div class="card last-card">
                <div class="box">
                    <h1>Assine</h1>
                    <h3>E torne-se um usuário vip</h3>
                </div>
                <div class="icon-case">
                    <img src="assets/imagens/paypal.png" alt="">
                </div>
            </div>
        </div>
        <div class="table">
            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Imagem</th>
                            <th>Idade</th>
                            <th>Porte</th>
                            <th>Stat. Vacina</th>
                            <th>Administrar</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userPets = $petController->getUserRegisteredPets($userId);

                        if ($userPets && $userPets->num_rows > 0) {
                            while ($row = $userPets->fetch_assoc()) {
                        ?>
                                <tr>
                                    <td><?= $row['nome'] ?></td>
                                    <td><img src="codes/<?= $row['imagem'] ?>" alt="<?= $row['nome'] ?>" /></td>
                                    <td><?= $row['idade'] ?></td>
                                    <td><?= $row['porte'] ?></td>
                                    <td><?= $row['vacina_status'] ?></td>
                                    <td>
                                        <a href="pet-update.php?id=<?= $row['idPet'] ?>" class="buttonatualizar">Atualizar</a>
                                        <a href="pet-delete.php?id=<?= $row['idPet'] ?>" class="buttondeletar">Deletar</a>


                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>Nenhum pet cadastrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= base_url('pet-register.php') ?>" class="buttonadd">Adicionar novo Pet</a>

        </div>

    </div>










    <?php
    include('includes/footer.php');
    ?>