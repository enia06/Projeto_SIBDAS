<?php
require_once __DIR__ . '/../config/config.php';

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST .
        ";port=" . MYSQL_PORT .
        ";dbname=" . MYSQL_DATABASE .
        ";charset=utf8mb4",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );

    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $bem_vindo = $ligacao->query("SELECT * FROM bem_vindo_publico WHERE id_bem_vindo = 1")->fetch(PDO::FETCH_OBJ);
    $sobre_nos = $ligacao->query("SELECT * FROM sobre_nos_publico WHERE id_sobre_nos = 1")->fetch(PDO::FETCH_OBJ);
    $secao_servicos = $ligacao->query("SELECT * FROM secao_servicos_publico WHERE id_secao_servicos = 1")->fetch(PDO::FETCH_OBJ);
    $servicos = $ligacao->query("SELECT * FROM servicos_publico WHERE ativo = 1 ORDER BY ordem ASC")->fetchAll(PDO::FETCH_OBJ);
    $contactos = $ligacao->query("SELECT * FROM contactos_publico WHERE id_contacto = 1")->fetch(PDO::FETCH_OBJ);
    $rodape = $ligacao->query("SELECT * FROM rodape_publico WHERE id_rodape = 1")->fetch(PDO::FETCH_OBJ);

} catch (PDOException $err) {
    $bem_vindo = null;
    $sobre_nos = null;
    $secao_servicos = null;
    $servicos = [];
    $contactos = null;
    $rodape = null;
}

$ligacao = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay This.Positive</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/logo branco.png" type="image/png">

    <!-- Google Fonts --> 
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet"> 

    <!-- Font Awesome --> 
    <link rel="stylesheet" href="../assets/fontawesome/all.min.css"> 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    
    <!-- Estilo da página-->
    <link rel="stylesheet" href="../assets/css/1241327.css">
    
</head>
<body>
    <!-- Navegação -->
    <nav class="bng-navbar">
        <!-- Logótipo e Nome da empresa -->
         <div>
            <img src="../assets/img/logo branco.png" alt="Logótipo da Empresa">
            <h2><strong>Stay This.Positive</strong></h2>
        </div>

        <!-- Links centrais de navegação-->
        <div class="container-navegacao"> 
            <a href ="#bem-vindo">Bem-vindo</a>
            <a href ="#sobre-nos">Sobre nós</a>
            <a href ="#servicos">Serviços</a>
            <a href ="#contacto">Contacto</a>
        </div>

        <!-- Seccção Login -->
        <div class="nav-cliente">
            <a href="/sibdas/1241327/stay-this-positive/private/login/login.php"><i class="fa-solid fa-user"></i>&nbsp; Login</a>
        </div>
    </nav>


    <!-- Secção "Conteúdo da página - Bem-vindo" --> 
    <section class="container-texto-generico" id="bem-vindo">
        <div class="bem-vindo-content">
            <h1><?= htmlspecialchars($bem_vindo->titulo ?? 'Bem-vindo à Stay This.Positive') ?></h1> 
            <p>"<?= htmlspecialchars($bem_vindo->descricao ?? 'Inventário inteligente, saúde para toda a gente') ?>"</p>
        </div>

        <div id="carouselHomepage" class="carousel slide bem-vindo-imagens" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../assets/img/welcome 1.png" class="d-block w-100" alt="Banner 1">
                </div> 
                <div class="carousel-item">
                    <img src="../assets/img/welcome 2.png" class="d-block w-100" alt="Banner 2">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselHomepage" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselHomepage" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

    </section>
                
    <!-- Secção "Conteúdo da página - Sobre nós" --> 
    <section class="container-texto-generico" id="sobre-nos">
        <div class="sobre-nos-content">
            <div class="sobre-nos-imagem">
                <img src="../assets/img/homepage.png" alt="Banner da Página Inicial">
            </div>

            <div class="sobre-nos-texto">
                <h1><?= htmlspecialchars($sobre_nos->titulo ?? 'Quem somos?') ?></h1>
                <p><?= nl2br(htmlspecialchars($sobre_nos->descricao ?? '')) ?></p>
                <a href="#contacto" class="button"><?= htmlspecialchars($sobre_nos->texto_botao ?? 'Contacte-nos') ?></a>
            </div>
        </div>
    </section>

    <!-- Secção "Conteúdo da página - Servicos" -->
    <section id="servicos">
        <h1><?= htmlspecialchars($secao_servicos->titulo ?? 'Os nossos serviços') ?></h1>
        <div id="servicos-container">   
            <?php foreach ($servicos as $servico) : ?>
                <div class="servicos-card">
                    <i class="<?= htmlspecialchars($servico->icone) ?>"></i>
                    <h3><?= htmlspecialchars($servico->titulo) ?></h3>
                    <p><?= htmlspecialchars($servico->descricao) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Secção "Conteúdo da página - Contacto" -->
    <section id="contacto">
        <h1><?= htmlspecialchars($contactos->titulo ?? 'Contacto') ?></h1>
        <p><?= htmlspecialchars($contactos->texto_introdutorio ?? '') ?></p>
        <form id="contactForm" action="processa_contacto.php" method="post"> 
            <label for="nome"><?= htmlspecialchars($contactos->subtitulo_nome ?? 'Nome:') ?></label>
            <input type="text" id="nome" name="nome" required>
            <label for="email"><?= htmlspecialchars($contactos->subtitulo_email ?? 'Email:') ?></label>
            <input type="email" id="email" name="email" required>
            <label for="mensagem"><?= htmlspecialchars($contactos->subtitulo_mensagem ?? 'Mensagem:') ?></label>
            <textarea id="mensagem" name="mensagem" rows="4" required></textarea>
            <button type="submit"><?= htmlspecialchars($contactos->texto_botao ?? 'Enviar') ?></button>
        </form>
    </section>

    <!-- Rodapé -->
    <footer class="footer-container">
        <div class="footer-section">
            <strong><?= strtoupper(htmlspecialchars($rodape->titulo_1 ?? 'Localização')) ?></strong>
            <p>
                <?= htmlspecialchars($rodape->rua ?? '') ?><br>
                <?= htmlspecialchars($rodape->codigo_postal ?? '') ?><br>
                <?= htmlspecialchars($rodape->pais ?? '') ?>
            </p>
        </div>

        <div class="footer-section">
            <strong><?= strtoupper(htmlspecialchars($rodape->titulo_2 ?? 'Horário')) ?></strong>
            <p>
                <?= htmlspecialchars($rodape->dias_uteis ?? '') ?><br>
                <?= htmlspecialchars($rodape->sabado_feriados ?? '') ?><br>
                <?= htmlspecialchars($rodape->domingo ?? '') ?>
            </p>
        </div>

        <div class="footer-section">
            <strong><?= strtoupper(htmlspecialchars($rodape->titulo_3 ?? 'Contactos')) ?></strong>
            <p>
                Email: <?= htmlspecialchars($rodape->email ?? '') ?><br>
                Telefone: <?= htmlspecialchars($rodape->telefone ?? '') ?><br>
                Instagram: <?= htmlspecialchars($rodape->instagram ?? '') ?><br>
                Facebook: <?= htmlspecialchars($rodape->facebook ?? '') ?>
            </p>
        </div>
    </footer>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>