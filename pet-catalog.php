<?php
include_once('controllers/CatalogController.php');
$data = $authenticated->authDetail();
include_once('controllers/PetController.php');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/pet_catalog.css">
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
            <form action="pet-catalog.php" method="GET" class="filter">
                <div class="item">
                    <label for="">Estado</label>
                    <input type="text" name="estado" placeholder="Digite o estado">
                </div>
                <div class="item">
                    <label for="">Especie</label>
                    <select name="especie" id="">
                        <option value=""></option>
                        <option value="Cachorro">Cachorro</option>
                        <option value="Gato">Gato</option>
                    </select>
                </div>
                <div class="item">
                    <label for="">Sexo</label>
                    <select name="sexo" id="">
                        <option value=""></option>
                        <option value="Macho">Macho</option>
                        <option value="Fêmea">Fêmea</option>
                    </select>
                </div>

                <div class="item">
                    <label for="">Porte</label>
                    <select name="porte" id="">
                        <option value=""></option>
                        <option value="Grande">Grande</option>
                        <option value="Médio">Médio</option>
                        <option value="Pequeno">Pequeno</option>
                    </select>
                </div>
                <div class="item">
                    <label for="">Status de vacinação</label>
                    <select name="vacina_status" id="">
                        <option value=""></option>
                        <option value="Completo">Completo</option>
                        <option value="Parcial">Parcial</option>
                        <option value="Não Vacinado">Não Vacinado</option>
                    </select>
                </div>

                <div class="item submit">
                    <button type="submit">Pesquisar</button>
                </div>
            </form>
            <div id="list">
                <?php
                var_dump($_FILES['imagem']);
                $pets = new PetController;
                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['estado'])) {
                    $filterData = [
                        'estado' => validateInput($db->conn, $_GET['estado']),
                        'especie' => validateInput($db->conn, $_GET['especie']),
                        'sexo' => validateInput($db->conn, $_GET['sexo']),
                        'porte' => validateInput($db->conn, $_GET['porte']),
                        'vacina_status' => validateInput($db->conn, $_GET['vacina_status']),
                    ];

                    $result = $pets->indexWithFilters($filterData);
                } else {
                    //Se não tiver filtro, busque todos os pets
                    $result = $pets->index();
                }

                if ($result && $result->num_rows > 0) {
                    // Fetch the rows and reverse the array
                    $rows = $result->fetch_all(MYSQLI_ASSOC);
                    $reversedRows = array_reverse($rows);
                    foreach ($reversedRows as $row) {
                        $lastOperation = $pets->getLastOperation($row['idPet']);
                        $statusClass = ($lastOperation == 'Adocao') ? 'status' : 'status hidden'; // Use a class to hide/show the status
                ?>
                        <div class="item">
                            <a href="pet-profile.php?id=<?= $row['idPet'] ?>" class="item-link">
                                <img src="codes/<?= $row['imagem'] ?>">
                                <div class="title"><?= $row['nome'] ?></div>
                                <div class="<?= $statusClass ?>">Adotado</div>
                                <div class="estado"><?= $row['estado'] ?>, <?= $row['cidade'] ?></div>
                            </a>

                            <?php
                            // Check if the user is a moderator
                            if (isset($_SESSION['auth_user']['moderador_bool']) && $_SESSION['auth_user']['moderador_bool'] == 1) {
                                // Show the button for moderators
                            ?>
                                <form action="pet-mod-delete.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $row['idPet'] ?>">
                                    <button type="submit" class="moderator-button">Deletar Pet</button>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                        
                <?php
                var_dump($_FILES['imagem']);
                    }
                } else {
                    echo "Nenhum registro encontrado";
                }
                ?>
            </div>
        </div>
    </main>







    <?php
    include('includes/footer.php');
    ?>