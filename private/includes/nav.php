<!-- Navbar -->
    <header class="container-fluid admin-navbar text-white">
        <div class="row align-items-center">
            <div class="col-6 d-flex align-items-center p-3">
                <!-- Logo e nome -->
                <img src="/sibdas/1241327/Projeto_SIBDAS_/assets/img/logo branco.png" alt="Logótipo da empresa" height="80" class="me-3">
                <h3 class="mb-0"><?php echo APP_NAME; ?></h3>
            </div>

            <div class="col-6 text-end p-3">
                <div class="dropdown">
                    <button class="btn admin-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-user me-2"></i>Utilizador</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-key me-2"></i>Alterar palavra-passe</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/sibdas/1241327/Projeto_SIBDAS_/private/login/login.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

<!-- Botão do menu -->
<button class="btn admin-menu-btn m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"><i class="fa-solid fa-bars"></i></button>