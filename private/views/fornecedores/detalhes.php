<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-0 pb-4 px-4">
                <div class="d-flex justify-content-center mt-1">
                    <div class="card admin-card w-100 shadow rounded" style="max-width: 950px;">
                         <div class="card-body">
                            <h2 class="mb-4"><strong><i class="fa-solid fa-circle-info me-2"></i> Detalhes do fornecedor</strong></h2>
                           
                            <h5 class="detail-section-title">Dados da empresa</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="detail-label">Código</label>
                                    <p class="detail-box">[Código]</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Nome da empresa</label>
                                    <p class="detail-box">[Nome da empresa]</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Tipo de fornecedor</label>
                                    <p class="detail-box">[Tipo de fornecedor]</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="detail-label">Morada</label>
                                    <p class="detail-box">[Morada]</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Código postal</label>
                                    <p class="detail-box">[Código postal]</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">NIF</label>
                                    <p class="detail-box">[NIF]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Contacto da empresa</label>
                                    <p class="detail-box">[Contacto da empresa]</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Email</label>
                                    <p class="detail-box">[Email]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Website</label>
                                    <p class="detail-box">[Website]</p>
                                </div>
                            </div>
                            
                            <h5 class="detail-section-title">Pessoa de contacto</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Nome</label>
                                    <p class="detail-box">[Nome]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Número telefónico </label>
                                    <p class="detail-box">[Número telefónico]</p>
                                </div>
                            </div>
                            
                            <h5 class="detail-section-title">Outros</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="detail-label">Observações</label>
                                    <p class="detail-box">[Observações]</p>
                                </div>
                            </div>
                            
                        
                            <div class="d-flex justify-content-end">                     
                                <a href="listar.php" class="btn btn-outline-secondary">                         
                                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar                     
                                </a>                 
                            </div>  
                        </div>
                    </div>
                </div>
            </main>
         </div>  
    </div>                         

<?php include '../../includes/footer.php'; ?>