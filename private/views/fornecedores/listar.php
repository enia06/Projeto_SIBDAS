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
                        <i class=""></i><strong>Listagem de Fornecedores</strong>
                    </h2>
                    <a href ="inserir.php" class="btn admin-btn-new">
                        <i class="fa-solid fa-plus me-1"></i>Novo Fornecedor
                    </a>
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" class="form-control" placeholder="Pesquisar por código, tipo de fornecedor ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select class="form-select" style="max-width: 190px;">
                        <option value="" selected disabled>Tipo de fornecedor</option>
                        <option value="fabricante">Fabricante</option>
                        <option value="distribuidor">Distribuidor/fornecedor comercial</option>
                        <option value="assistencia_tecnica">Empresa de assistência técnica</option>
                        <option value="consumiveis">Fornecedor de consumíveis/acessórios</option>
                    </select>

                    <!-- Botão de pesquisa -->
                    <button class="btn admin-btn-cancel filter-btn mt-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted mb-0">Fornecedores registados: [número de registos]</p>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: 180px;">
                            <option value="" selected disabled>Ordenar por</option>
                            <option>Código</option>
                            <option>Tipo de fornecedor</option>
                        </select>

                        <select class="form-select" style="width: 170px;">
                            <option value="" selected disabled>Sentido</option>
                            <option value="crescente">Crescente ↑</option>
                            <option value="decrescente">Decrescente ↓</option>
                            <option value="alfabetica">Alfabética A → Z</option>
                            <option value="alfabetica_invertida">Alfabética Z → A</option>
                        </select>

                        <button id="btnResumo" class="btn admin-btn-view active" title="Vista resumo">
                            <i class="fa-solid fa-table"></i>
                        </button>

                        <button id="btnDetalhe" class="btn admin-btn-view" title="Vista detalhe">
                            <i class="fa-solid fa-table-columns"></i>
                        </button>
                    </div>
                </div>

                <div id="vistaResumo">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">    
                            <thead class="table-header">
                                <tr>
                                    <th class="text-center">Código</th> 
                                    <th class="text-center">Nome da empresa</th> 
                                    <th class="text-center">Tipo de fornecedor</th>  
                                    <th class="text-center">Contacto</th> 
                                    <th class="text-center">Email</th> 
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr>
                                    <td class="text-center">[Código]</td>
                                    <td class="text-center">[Nome da empresa]</td> 
                                    <td class="text-center">[Tipo de fornecedor]</td>   
                                    <td class="text-center">[Contacto]</td> 
                                    <td class="text-center">[Email]</td> 
                                    <td class="text-center">
                                        <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"> 
                                            <i class="fa-solid fa-circle-info"></i> 
                                        </a>
                                        <a href="editar.php" class="btn btn-sm btn-outline-warning me-1"> 
                                            <i class="fa-solid fa-file-pen"></i> 
                                        </a> 
                                        <a href="remover.php" class="btn btn-sm btn-outline-danger me-1"> 
                                            <i class="fa-solid fa-trash-can"></i> 
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>  
                </div>

                <div id="vistaDetalhe" class="d-none mb-5">
                    <div class="row g-3">
                        <div class="col-lg-4">
                            <div class="card admin-card shadow rounded h-100">
                                <div class="card-body ">
                                    <h5 class="detail-section-title mb-3">
                                        <i class="fa-solid fa-truck-medical me-2"></i>[Nome da empresa]
                                    </h5>
                                    <p><strong>Código:</strong> [Código]</p>
                                    <p><strong>Tipo de fornecedor:</strong> [Tipo de fornecedor]</p>
                                    <p><strong>Morada:</strong> [Morada]</p>
                                    <p><strong>NIF:</strong> [NIF]</p>
                                    <p><strong>Contacto:</strong> [Contacto]</p>
                                    <p><strong>Email:</strong> [Email]</p>
                                    <p><strong>Pessoa de contacto:</strong> [Pessoa de contacto]</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>                         

    
    <script src="../../../assets/js/1241327.js"></script>

<?php include '../../includes/footer.php'; ?>