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

<?php
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST .
        ";port=" . MYSQL_PORT .
        ";dbname=" . MYSQL_DATABASE .
        ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );

    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $localizacoes = $ligacao
        ->query("SELECT * FROM localizacoes")
        ->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $localizacoes = [];
}

$ligacao = null;
?>

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
                        <input type="text" id="pesquisa-localizacoes" class="form-control" placeholder="Pesquisar por edifício, piso ...">
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
                    <?php if (!empty($erro)) : ?>
                        <p class="text-center text-danger"><?= $erro ?></p>
                    <?php else : ?>
                        <?php if (count($localizacoes) == 0) : ?>
                            <p class="text-muted">Não existem localizações registadas.</p>
                        <?php else : ?>
                            <p class="text-muted">Localizações registadas: <?= count($localizacoes) ?></p>
                    
                    <div class="d-flex gap-2">
                        <button id="btnResumo" class="btn admin-btn-view active" title="Vista resumo">
                            <i class="fa-solid fa-table"></i>
                        </button>

                        <button id="btnDetalhe" class="btn admin-btn-view" title="Vista detalhe">
                            <i class="fa-solid fa-table-columns"></i>
                        </button>
                    </div>
                </div>
                        <?php endif; ?>
                    <?php endif; ?>

                <div id="vistaResumo">
                    <div class="table-responsive">
                        <table id="tabela-localizacoes" class="table table-bordered table-striped align-middle">
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
                                <?php foreach ($localizacoes as $localizacao) : ?>
                                    <tr>
                                        <td class="text-center"><?= $localizacao->codigo ?></td>
                                        <td class="text-center"><?= $localizacao->edificio ?></td>
                                        <td class="text-center"><?= $localizacao->piso ?></td>
                                        <td class="text-center"><?= $localizacao->servico_departamento ?></td>
                                        <td class="text-center"><?= $localizacao->sala_gabinete ?></td>
                                        <td class="text-center">
                                            <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"> 
                                                <i class="fa-solid fa-circle-info"></i> 
                                            </a>
                                            <a href="editar.php?id_localizacao=<?= aes_encrypt($localizacao->id_localizacao) ?>" class="btn btn-sm btn-outline-warning me-1">
                                                <i class="fa-solid fa-file-pen"></i>
                                            </a>
                                            <a href="remover.php" class="btn btn-sm btn-outline-danger me-1"> 
                                                <i class="fa-solid fa-trash-can"></i> 
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="vistaDetalhe" class="d-none mb-5">
                    <div class="row g-3">
                        <?php foreach ($localizacoes as $localizacao) : ?>
                            <div class="col-lg-4">
                                <div class="card admin-card shadow rounded">
                                    <div class="card-body ">
                                        <h5 class="detail-section-title mb-4 text-center">
                                            <i class="fa-solid fa-house-medical-flag fa-2x"></i>
                                        </h5>
                                        <p><strong>Código:</strong> <?= $localizacao->codigo ?></p>
                                        <p><strong>Edifício:</strong> <?= $localizacao->edificio ?></p>
                                        <p><strong>Piso:</strong> <?= $localizacao->piso ?></p>
                                        <p><strong>Serviço/Departamento:</strong> <?= $localizacao->servico_departamento ?></p>
                                        <p><strong>Acesso:</strong> <?= $localizacao->acesso ?></p>
                                        <p><strong>Sala/Gabinete:</strong> <?= $localizacao->sala_gabinete ?></p>
                                        <p><strong>Responsável:</strong> <?= $localizacao->responsavel ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>                         

    <script src="../../../assets/js/1241327.js"></script>

    <script>
    $(document).ready(function () {

        let tabela = $('#tabela-localizacoes').DataTable({
            dom: 'lrtip',
            pageLength: 5,
            pagingType: "full_numbers",

            language: {
                decimal: "",
                emptyTable: "Sem dados disponíveis na tabela.",
                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                infoFiltered: "(Filtrando _MAX_ total de registos)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrar _MENU_ registos por página",
                loadingRecords: "Carregando...",
                processing: "Processando...",
                search: "Pesquisar:",
                zeroRecords: "Nenhum registo encontrado.",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Seguinte",
                    previous: "Anterior"
                }
            }
        });

        $('#pesquisa-localizacoes').on('keyup', function () {
            tabela.search($(this).val()).draw();
        });

    });
    </script>

<?php include '../../includes/footer.php'; ?>


