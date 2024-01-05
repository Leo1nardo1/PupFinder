<?php
include_once('controllers/AuthenticationController.php');
$data = $authenticated->authDetail();
include('includes/header.php');
?>
<div class="bg">
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
                    <li><a href="#quem" class="navbar-link">Quem Somos?</a></li>
                    <li><a href="<?= base_url('pet-catalog.php') ?>" class="navbar-link">Quero Adotar</a></li>
                    <li><a href="#ajudar" class="navbar-link">Quero Ajudar</a></li>
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

        <div class="headline">

            <?php
            include('message.php');
            ?>
            <h1><span>PupFinder</span> <span class="subtext">UNINDO CORAÇÕES PELUDOS A LARES ACONCHEGANTES</span></h1>

            <div class="ladoalado">
                <a href="<?= base_url('pet-catalog.php') ?>" class="btn hidden">Adote um pet</a>
                <a href="<?= base_url('pet-register.php') ?>" class="btn clean hidden">Divulgue seu pet</a>
            </div>

        </div>
    </div>
    <div class="degrade"></div>
</div>
<section id="quem">
    <article>
        <h2>Quem somos nós?</h2>
        <img src="assets/imagens/logo.png" alt="Quem somos" class="esq margdir w43">
        <p>
            No coração do PupFinder, somos uma equipe apaixonada dedicada a redefinir a experiência de adoção e cuidado com pets. Nossa plataforma online é um ecossistema completo, conectando lares aconchegantes a pets adoráveis.
            <br><br>
            Na magia da adoção, encontramos lares para pets amorosos, construindo conexões duradouras. A doação é um ato de generosidade que transforma vidas, unindo corações peludos a famílias dedicadas. Junte-se a nós no PupFinder, onde cada adoção e doação se transforma em uma história de amor e felicidade.
        </p>
    </article>
</section>
<section id="querajudar" class="secajudar">
    <article class="spaceajudar">
        <h2>Quer nos ajudar?</h2>
        <div class="ajuda">
            <ul>
                <li>
                    <a href="#">
                        <img src="assets/imagens/1.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="assets/imagens/2.jpg" alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="assets/imagens/3.png" alt="">
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="assets/imagens/4.jpg" alt="">
                    </a>
                </li>
            </ul>
        </div>
    </article>

    <aside id="ajudar" class="boxassine">
        <h2 class="doe">Doe e torne-se um membro vip</h2>
        <img src="assets/imagens/paypal.png" alt="" class="doacao">
        <span class="assine">Assine a partir de</span>
        <span class="preco">R$ 4,99</span>
        <span class="vantagens">Desbloqueie mais slots<br>e ganhe visibilidade especial para os pets que você doar!</span>
    </aside>
    <div class="clear"></div>
</section>

<!--Efeito no texto da headline-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            document.querySelector('.headline').classList.add('show');
        }, 500);
    });
</script>
<?php
include('includes/footer.php');
?>