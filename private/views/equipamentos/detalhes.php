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
                            <h2 class="mb-4"><strong><i class="fa-solid fa-circle-info me-2"></i> Detalhes do Equipamento</strong></h2>
                            
                            <ul class="nav nav-tabs justify-content-center mb-4" id="equipamentoTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#equipamento"><i class="fa-solid fa-laptop-medical me-1"></i>Equipamento </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fornecedor"><i class="fa-solid fa-truck-medical me-1"></i>Fornecedor</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#localizacao"><i class="fa-solid fa-house-medical-flag me-1"></i>Localização</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documentacao"><i class="fa-solid fa-clipboard-user me-1"></i>Documentação</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#garantias"><i class="fa-solid fa-receipt me-1"></i>Garantias/Contratos</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="equipamento">
                                    <h5 class="detail-section-title">Identificação</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Nome do equipamento</label>
                                            <p class="detail-box">[Nome do equipamento]</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Categoria</label>
                                            <p class="detail-box">[Categoria]</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Código interno</label>
                                            <p class="detail-box">[Código interno]</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Número de série</label>
                                            <p class="detail-box">[Número de série]</p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Dados técnicos</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Marca</label>
                                            <p class="detail-box">[Marca]</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Modelo</label>
                                            <p class="detail-box">[Modelo]</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Fabricante</label>
                                            <p class="detail-box">[Fabricante]</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Ano de fabrico</label>
                                            <p class="detail-box">[Ano de fabrico]</p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Informações de aquisição</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="detail-label">Data de aquisição</label>
                                            <p class="detail-box">[Data de aquisição]</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Custo de aquisição</label>
                                            <p class="detail-box">[Custo de aquisição]</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Tipo de entrada</label>
                                            <p class="detail-box">[Tipo de entrada]</p>
                                        </div>
                                    </div>

                                    <h5 class="detail-section-title">Condições do equipamento</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Estado atual</label>
                                            <p class="detail-box"><span class="status-dot status-active"></span>Ativo</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Criticidade</label>
                                            <p class="detail-box"><span class="status-dot status-critical"></span>Alta</p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Outros</h5>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="detail-label">Observações</label>
                                            <p class="detail-box">[Observações]</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="fornecedor">
                                    <h5 class="detail-section-title">Dados da empresa</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
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
                                </div>

                                <div class="tab-pane fade" id="localizacao">
                                    <h5 class="detail-section-title">Localização geral</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Edifício</label>
                                            <p class="detail-box">[Edifício]</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Piso</label>
                                            <p class="detail-box">[Piso]</p>
                                        </div>
                                    </div>

                                    <h5 class="detail-section-title">Serviço</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Serviço/Departamento</label>
                                            <p class="detail-box">[Serviço/Departamento]</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Acesso</label>
                                            <p class="detail-box">[Acesso]</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Sala/Gabinete</label>
                                            <p class="detail-box">[Sala/Gabinete]</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Responsável</label>
                                            <p class="detail-box">[Responsável]</p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Outros</h5>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="detail-label">Observações</label>
                                            <p class="detail-box">[Observações]</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="documentacao">
                                    <h5 class="detail-section-title">Informações</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Nome</label>
                                            <p class="detail-box">[Nome do documento]</p>
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
                                </div>

                                <div class="tab-pane fade" id="garantias">
                                    <h5 class="detail-section-title">Informações da garantia</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="detail-label">Equipamento associado</label>
                                            <p class="detail-box">[Equipamento associado]</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Data de início da garantia</label>
                                            <p class="detail-box">[Data de início da garantia]</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Data de fim da garantia</label>
                                            <p class="detail-box">[Data de fim da garantia]</p>
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