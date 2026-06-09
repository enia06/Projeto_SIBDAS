<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stay This.Positive</title>

    <!-- Bootstrap CSS & custom CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/1241327.css"> 

    <!-- Google Fonts -->     
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet"> 

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/img/logo branco.png" type="image/png">

    <!-- Fontawesome  -->
    <link rel="stylesheet" href="../assets/fontawesome/all.min.css">

</head>

<body>
    <!-- Navbar -->
    <header class="container-fluid admin-navbar text-white">
        <div class="row align-items-center">
            <div class="col-6 d-flex align-items-center p-3">
                <!-- Logo e nome -->
                <img src="../assets/img/logo branco.png" alt="Logótipo da empresa" height="80" class="me-3">
                <h3 class ="mb-0">Stay This.Positive</h3>
            </div>

            <div class="col-6 text-end p-3">
                <div class="dropdown">
                    <button class="btn admin-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-user me-2"></i>Utilizador</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-key me-2"></i>Alterar palavra-passe</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../private/login/login.html"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Botão do menu -->
    <button class="btn admin-menu-btn m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"><i class="fa-solid fa-bars"></i></button>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="offcanvas offcanvas-start admin-sidebar text-white" tabindex="-1" id="menuLateral">
                <div class="offcanvas-header">
                    <h4 class="offcanvas-title">Menu</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body">
                    <nav>
                        <a href="../private/views/equipamentos/listar.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-laptop-medical"></i> &ensp; Equipamentos</a>
                        <a href="../private/views/fornecedores/listar.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-truck-medical"></i> &ensp; Fornecedores</a>
                        <a href="../private/views/localizacoes/listar.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-house-medical-flag"></i> &ensp; Localizações</a>
                        <a href="../private/views/documentacao/listar.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-clipboard-user"></i> &ensp; Documentação</a>
                        <a href="../private/views/garantias_contratos/listar.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-receipt"></i> &ensp; Garantias/Contratos</a>
                        <a href="../private/views/dashboard/dashboard.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-file-waveform"></i> &ensp; Dashboard</a>
                        <hr>
        
                        <a href="../private/views/conteudos/conteudos.html" class="nav-link text-white px-0 mb-3 d-block">
                            <i class="fa-solid fa-pen-to-square"></i> &ensp; Conteúdos Públicos</a>
                    </nav>
                </div>
            </div>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 px-4 ps-md-5">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h2 class="mb-0 display-5 fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.25);">
                        <i class=""></i><strong>Bem-vindo à área administrativa</strong>
                    </h2>
                </div>
                <p class="text-center fs-5 text-muted">Para explorar esta nova área de gestão de inventário hospitalar deve:</p>
                
                <div class="admin-card shadow-sm pt-4 px-4 pb-1 mx-auto mt-4 mb-4" style="max-width: 550px;">
                    <div class="mb-5 mt-3">
                        <h5 class="text-decoration-underline mb-3"><i class="fa-solid fa-bars fs-4 me-3" style="color:#602323"></i>1. Abrir o menu lateral</h5>
                        <p class="text-muted">Selecione o botão do menu para visualizar as funcionalidades disponíveis</p>
                    </div>
                    <div class="mb-5">
                        <h5 class="text-decoration-underline mb-3"><i class="fa-solid fa-folder-open fs-4 me-3" style="color:#602323"></i>2. Selecionar uma área</h5>
                        <p class="text-muted">Escolha a secção que pretende explorar</p>
                    </div>
                    <div class="mb-5">
                        <h5 class="text-decoration-underline mb-3"><i class="fa-solid fa-pen-to-square fs-4 me-3" style="color:#602323"></i>3. Gerir informações</h5>
                        <p class="text-muted">Adicione, edite ou consulte dados do inventário hospitalar</p>
                    </div>
                </div>
        
            </main>  

    <!-- Bootstrap JS and custom JS --> 
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>