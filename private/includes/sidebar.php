<?php
$perfil = $_SESSION['perfil'] ?? '';
?>

<!-- Sidebar -->
<div class="offcanvas offcanvas-start admin-sidebar text-white" tabindex="-1" id="menuLateral">
    <div class="offcanvas-header">
        <h4 class="offcanvas-title">Menu</h4>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <nav>

            <a href="/sibdas/1241327/stay-this-positive/private/views/equipamentos/listar.php" class="nav-link text-white px-0 mb-3 d-block">
                <i class="fa-solid fa-laptop-medical"></i> &ensp; Equipamentos
            </a>

            <?php if ($perfil == 'administrador' || $perfil == 'tecnico'): ?>
                <a href="/sibdas/1241327/stay-this-positive/private/views/fornecedores/listar.php" class="nav-link text-white px-0 mb-3 d-block">
                    <i class="fa-solid fa-truck-medical"></i> &ensp; Fornecedores
                </a>
            <?php endif; ?>

            <a href="/sibdas/1241327/stay-this-positive/private/views/localizacoes/listar.php" class="nav-link text-white px-0 mb-3 d-block">
                <i class="fa-solid fa-house-medical-flag"></i> &ensp; Localizações
            </a>

            <a href="/sibdas/1241327/stay-this-positive/private/views/documentacao/listar.php" class="nav-link text-white px-0 mb-3 d-block">
                <i class="fa-solid fa-clipboard-user"></i> &ensp; Documentação
            </a>

            <a href="/sibdas/1241327/stay-this-positive/private/views/garantias_contratos/listar.php" class="nav-link text-white px-0 mb-3 d-block">
                <i class="fa-solid fa-receipt"></i> &ensp; Garantias/Contratos
            </a>

            <?php if ($perfil == 'administrador' || $perfil == 'tecnico'): ?>
                <a href="/sibdas/1241327/stay-this-positive/private/views/dashboard/dashboard.php" class="nav-link text-white px-0 mb-3 d-block">
                    <i class="fa-solid fa-file-waveform"></i> &ensp; Dashboard
                </a>
            <?php endif; ?>

            <?php if ($perfil == 'administrador'): ?>
                <hr>

                <a href="/sibdas/1241327/stay-this-positive/private/views/conteudos/conteudos.php" class="nav-link text-white px-0 mb-3 d-block">
                    <i class="fa-solid fa-pen-to-square"></i> &ensp; Conteúdos Públicos
                </a>
            <?php endif; ?>
        </nav>
    </div>
</div>