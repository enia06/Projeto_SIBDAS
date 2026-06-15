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
                            <h2 class="mb-4"><strong><i class="fa-solid fa-circle-info me-2"></i> Detalhes do documento</strong></h2>
                           
                            <h5 class="detail-section-title">Informações</h5>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="detail-label">Código</label>
                                    <p class="detail-box">[Código do documento]</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Tipo de documento</label>
                                    <p class="detail-box">[Tipo de documento]</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Nome/Localização do documento</label>
                                    <p class="detail-box">[Localização do documento]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Ficheiro carregado</label>
                                    <p class="detail-box">[Documento.pdf]</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Data de emissão</label>
                                    <p class="detail-box">[Data de emissão]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Data de validade</label>
                                    <p class="detail-box">[Data de validade]</p>
                                </div>
                            </div>

                            <h5 class="detail-section-title">Associações</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Equipamento associado</label>
                                    <p class="detail-box">[Equipamento]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Fornecedor associado</label>
                                    <p class="detail-box">[Fornecedor]</p>
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