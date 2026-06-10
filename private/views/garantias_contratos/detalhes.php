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
                            <h2 class="mb-4"><strong><i class="fa-solid fa-circle-info me-2"></i>Detalhes da garantia/contrato</strong></h2>
                        
                            <h5 class="detail-section-title">Informações da garantia</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Código</label>
                                    <p class="detail-box">[Código]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Equipamento associado</label>
                                    <p class="detail-box">[Equipamento associado]</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="detail-label">Data de início da garantia</label>
                                    <p class="detail-box">[Data de início da garantia]</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Data de fim da garantia</label>
                                    <p class="detail-box">[Data de fim da garantia]</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Estado</label>
                                    <p class="detail-box"><span class="status-dot status-active"></span>Ativa</p>
                                </div>
                            </div>

                            <h5 class="detail-section-title">Informações do contrato</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Existência de contrato de manutenção</label>
                                    <p class="detail-box">[Sim/Não]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Tipo de contrato</label>
                                    <p class="detail-box">[Tipo de contrato]</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Entidade responsável</label>
                                    <p class="detail-box">[Entidade responsável]</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Periodicidade</label>
                                    <p class="detail-box">[Periodicidade]</p>
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