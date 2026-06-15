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
                        <i class=""></i><strong>Listagem de Localizações</strong>
                    </h2>
                    <a href ="inserir.php" class="btn admin-btn-new">
                        <i class="fa-solid fa-plus me-1"></i>Nova Localização
                    </a>
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" class="form-control" placeholder="Pesquisar por edifício, piso ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Edifício</option>
                        <option value="bloco_a">Bloco A</option>
                        <option value="bloco_b">Bloco B</option>
                        <option value="bloco_c">Bloco C</option>
                        <option value="bloco_d">Bloco D</option>
                        <option value="bloco_e">Bloco E</option>
                        <option value="bloco_f">Bloco F</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Piso</option>
                        <option value="piso_1">Piso 1</option>
                        <option value="piso_2">Piso 2</option>
                        <option value="piso_3">Piso 3</option>
                        <option value="piso_4">Piso 4</option>
                        <option value="piso_5">Piso 5</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Serviço</option>
                        <option value="urgencias">Urgências</option>
                        <option value="uci">Unidade de Cuidados Intensivos</option>
                        <option value="pediatria">Pediatria</option>
                        <option value="cardiologia">Cardiologia</option>
                        <option value="neurologia">Neurologia</option>
                        <option value="ortopedia">Ortopedia</option>
                        <option value="radiologia">Radiologia</option>
                        <option value="imagiologia">Imagiologia</option>
                        <option value="laboratorio_analises">Laboratório de Análises Clínicas</option>
                        <option value="farmacia">Farmácia Hospitalar</option>
                    </select>

                    <!-- Botão de pesquisa -->
                    <button class="btn admin-btn-cancel filter-btn mt-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted">Localizações registadas: [número de registos]</p>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: 180px;">
                            <option value="" selected disabled>Ordenar por</option>
                            <option>Código</option>
                            <option>Edifício</option>
                            <option>Piso</option>
                            <option>Serviço</option>
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
                                    <th class="text-center">Edifício</th> 
                                    <th class="text-center">Piso</th> 
                                    <th class="text-center">Serviço/departamento</th> 
                                    <th class="text-center">Sala/Gabinete</th> 
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tr>
                                    <td class="text-center">[Código]</td>
                                    <td class="text-center">[Edifício]</td> 
                                    <td class="text-center">[Piso]</td>  
                                    <td class="text-center">[Serviço/departamento]</td> 
                                    <td class="text-center">[Sala/Gabinete]</td> 
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
                            <div class="card admin-card shadow rounded">
                                <div class="card-body ">
                                    <h5 class="detail-section-title mb-4 text-center">
                                        <i class="fa-solid fa-house-medical-flag fa-2x"></i>
                                    </h5>
                                    <p><strong>Código:</strong> [Código]</p>
                                    <p><strong>Edifício:</strong> [Edifício]</p>
                                    <p><strong>Piso:</strong> [Piso]</p>
                                    <p><strong>Serviço/Departamento:</strong> [Serviço]</p>
                                    <p><strong>Acesso:</strong> [Acesso]</p>
                                    <p><strong>Sala/Gabinete:</strong> [Sala/Gabinete]</p>
                                    <p><strong>Responsável:</strong> [Responsável]</p>
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


