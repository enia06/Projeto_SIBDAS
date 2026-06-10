<?php
require_once __DIR__ . '/../config/config.php';
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>

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
        </div>
    </div>

<?php include 'includes/footer.php'; ?>

    