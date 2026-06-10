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
            <a href="/sibdas/1241327/Projeto_SIBDAS_/private/login/login.php" target="_blank"><i class="fa-solid fa-user"></i>&nbsp; Login</a>
        </div>
    </nav>


    <!-- Secção "Conteúdo da página - Bem-vindo" --> 
    <section class="container-texto-generico" id="bem-vindo">
        <div class="bem-vindo-content">
            <h1>Bem-vindo à Stay This.Positive</h1> 
            <p>"Inventário inteligente, saúde para toda a gente"</p>
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
                <h1>Quem somos?</h1>
                <p>A Stay This.Positive é uma empresa dedicada à gestão de inventário hospitalar de equipamentos médicos. Disponibilizamos uma plataforma organizada, intuitiva e atualizada para consulta de informação relativa aos equipamentos médicos existentes. Através da nossa plataforma, é possível obter informações sobre fornecedores, localizações, documentação técnica, garantias e contratos associados a cada equipamento. <br> Com a Stay This.Positive, nunca estará perdido!</br></p>
                <a href="#contacto" class="button">Contacte-nos</a>
            </div>
        </div>
    </section>

    <!-- Secção "Conteúdo da página - Servicos" -->
    <section id="servicos">
        <h1>Os nossos serviços</h1>
        <div id="servicos-container">   
            <div class="servicos-card">
                <i class="fa-solid fa-laptop-medical"></i>
                <h3>Equipamentos</h3>
                <p>Consulte informações sobre os equipamentos e o seu estado atual</p>
            </div>
            <div class="servicos-card">
                <i class="fa-solid fa-truck-medical"></i>
                <h3>Fornecedores</h3>
                <p>Descubra os fornecedores responsáveis pela distribuição dos nossos equipamentos</p>
            </div>
            <div class="servicos-card">
                <i class="fa-solid fa-house-medical-flag"></i>
                <h3>Localizações</h3>
                <p>Localize de forma rápida qualquer equipamento nas nossas instalações</p> 
            </div>
            <div class="servicos-card">
                <i class="fa-solid fa-clipboard-user"></i>
                <h3>Documentação técnica</h3>
                <p>Aceda a manuais e documentação técnica dos nossos equipamentos</p> 
            </div>
            <div class="servicos-card">
                <i class="fa-solid fa-receipt"></i>
                <h3>Garantias e Contratos</h3>
                <p>Consulte as garantias e contratos associados a cada equipamento</p> 
            </div>
            <div class="servicos-card">
                <i class="fa-solid fa-file-waveform"></i>
                <h3>Dashboard</h3>
                <p>Acompanhe dados relevantes e obtenha uma visão geral sobre o nosso inventário</p> 
            </div>
        </div>
    </section>

    <!-- Secção "Conteúdo da página - Contacto" -->
    <section id="contacto">
        <h1>Contacto</h1>
        <p>Entre em contacto connosco para esclarecer qualquer dúvida. Estaremos aqui para ajudar!</p> 
        <form id="contactForm"> <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" required>
            <label for="email">Email:</label><input type="email" id="email" name="email" required>
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" rows="4" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </section>

    <!-- Rodapé -->
    <footer class="footer-container">
        <div class="footer-section">
            <strong>LOCALIZAÇÃO</strong>
            <p>Rua dos Engenheiros nº24 <br> 4920-327, Viana do Castelo <br> Portugal</p>
        </div>

        <div class="footer-section">
            <strong>HORÁRIO</strong>
            <p>Dias úteis (2º a 6º feira): 8h - 20h <br> Sábado e Feriados: 8h - 13h <br> Domingo: Encerrado</p>
        </div>

        <div class="footer-section">
            <strong>CONTACTOS</strong>
            <p>Email: StayThis.Positive@gmail.com <br> Telefone: 251 811 722 <br> Instagram: StayThis.Positive <br> Facebook: StayThis.Positive</p>
        </div>
    </footer>  

    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>