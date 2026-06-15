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
            <main class="col-12 pt-3 px-4 ps-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">
                        <i class=""></i><strong>Listagem de Garantias/Contratos</strong>
                    </h2>
                
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" class="form-control" placeholder="Pesquisar por equipamento, tipo de contrato, ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select class="form-select" style="max-width: 190px;">
                        <option value="" selected disabled>Estado da garantia</option>
                        <option value="ativa">Ativa</option>
                        <option value="expirada">Expirada</option>
                    </select>

                    <select class="form-select" style="max-width: 190px;">
                        <option value="" selected disabled>Tipo de contrato</option>
                        <option value="manutencao_preventiva">Manutenção preventiva</option>
                        <option value="manutencao_corretiva">Manutenção corretiva</option>
                        <option value="manutencao_preventiva_corretiva">Manutenção preventiva e corretiva</option>
                        <option value="manutencao_completa">Manutenção completa</option>
                    </select>

                    <!-- Botão de pesquisa -->
                    <button class="btn admin-btn-cancel filter-btn mt-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted">
                        Garantias/Contratos registados: [número de registos]
                    </p>

                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: 180px;">
                            <option value="" selected disabled>Ordenar por</option>
                            <option>Código</option>
                            <option>Data de fim da garantia</option>
                            <option>Estado</option>
                            <option>Tipo de contrato</option>
                            <option>Periodicidade</option>
                        </select>

                        <select class="form-select" style="width: 170px;">
                            <option value="" selected disabled>Sentido</option>
                            <option value="crescente">Crescente ↑</option>
                            <option value="decrescente">Decrescente ↓</option>
                            <option value="alfabetica">Alfabética A → Z</option>
                            <option value="alfabetica_invertida">Alfabética Z → A</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">    
                        <thead class="table-header">
                            <tr> 
                                <th class="text-center">Código</th> 
                                <th class="text-center">Equipamento associado</th> 
                                <th class="text-center">Data de fim da garantia</th> 
                                <th class="text-center">Estado</th> 
                                <th class="text-center">Tipo de contrato</th> 
                                <th class="text-center">Periodicidade</th> 
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                                <td class="text-center">[Código]</td> 
                                <td class="text-center">[Equipamento associado]</td> 
                                <td class="text-center">[Data de fim da garantia]</td>
                                <td class="text-center"><span class="status-dot status-active"></span>Ativa</td>  
                                <td class="text-center">[Tipo de contrato]</td> 
                                <td class="text-center">[Periodicidade]</td> 
                                <td class="text-center">
                                    <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"> 
                                        <i class="fa-solid fa-circle-info"></i> 
                                    </a>
                                   
                                    <a href="remover.php" class="btn btn-sm btn-outline-danger me-1"> 
                                        <i class="fa-solid fa-trash-can"></i> 
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>                         

<?php include '../../includes/footer.php'; ?>