<?php
// Verifica se a sessão ainda não foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia a sessão
}

// Verifica se o utilizador está autenticado
if (!isset($_SESSION['utilizador'])) {
    header('Location: ../public/login.php');// Se não estiver autenticado, redireciona para o formulário de login
    exit; // Encerra o script
}

$nome = $_SESSION['nome_utilizador'] ?? $_SESSION['utilizador'];
$perfil = $_SESSION['perfil'] ?? '';

switch ($perfil) {
    case 'administrador':
        $perfil_formatado = 'Administrador';
        break;
    case 'tecnico':
        $perfil_formatado = 'Técnico de Engenharia Clínica';
        break;
    case 'profissional_saude':
        $perfil_formatado = 'Profissional de Saúde';
        break;
    default:
        $perfil_formatado = $perfil;
}
?>

<!-- Navbar -->
    <header class="container-fluid admin-navbar text-white">
        <div class="row align-items-center">
            <div class="col-6 d-flex align-items-center p-3">
                <!-- Logo e nome -->
                <a href="/sibdas/1241327/stay-this-positive/private/indexpriv.php">
                    <img src="/sibdas/1241327/stay-this-positive/assets/img/logo branco.png" alt="Logótipo da empresa" height="80" class="me-3">
                </a>

                <h3 class="mb-0"><?php echo APP_NAME; ?></h3>
                
            </div>

            <div class="col-6 text-end p-3">
                <div class="dropdown">
                    <button class="btn admin-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-regular fa-user me-2"></i> <?= htmlspecialchars($nome) ?></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="px-3 py-2 text-start">
                            <div class="fw-bold"><?= htmlspecialchars($nome) ?></div>
                            <small class="text-muted"><?= htmlspecialchars($perfil_formatado) ?></small>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="/sibdas/1241327/stay-this-positive/private/utilizadores/alterar_password.php">
                                <i class="fa-solid fa-key"></i>
                                Alterar palavra-passe
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <a class="dropdown-item" href="/sibdas/1241327/stay-this-positive/private/login/logout.php">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

<!-- Botão do menu -->
<button class="btn admin-menu-btn m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"><i class="fa-solid fa-bars"></i></button>