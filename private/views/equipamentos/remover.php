<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 d-flex justify-content-center align-items-center px-4 ps-5" style="min-height:60vh;">
                    <div class="card admin-card w-100 shadow rounded text-center p-4 pt-5" style="max-width: 500px;">
                        <div class="remove-warning-icon display-4 mb-3">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <p class="mb-2 fs-5">Deseja eliminar o equipamento?</p>
                        <h4 class="mb-4"><strong>[Nome do equipamento]</strong></h4>
                        <p class="text-muted mb-4 text-decoration-underline">ATENÇÃO - Esta ação não poderá ser revertida</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href ="listar.php" class="btn admin-btn-cancel px-4"><i class="fa-solid fa-xmark me-2"></i>Cancelar</a>
                            <a href ="listar.php" class="btn admin-btn-save px-4"><i class="fa-solid fa-check me-2"></i>Confirmar</a>
                        </div>
                    </div>
            </main>
        </div>
    </div>

<?php include '../../includes/footer.php'; ?>