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
    $equipamentos = $ligacao
        ->query("
            SELECT
                e.*,
                c.categoria,
                ee.estado,
                cr.criticidade,
                te.tipo_entrada
            FROM equipamentos e
            LEFT JOIN categorias c
                ON e.id_categoria = c.id_categoria
            LEFT JOIN estados_equipamento ee
                ON e.id_estado = ee.id_estado
            LEFT JOIN criticidades cr
                ON e.id_criticidade = cr.id_criticidade
            LEFT JOIN tipos_entrada te
                ON e.id_tipo_entrada = te.id_tipo_entrada
        ")
        ->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $equipamentos = [];
}

// Fecha a ligação
$ligacao = null;
?>

    <div class="container-fluid">
        <div class="row">

            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 px-4 ps-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">
                        <i class=""></i><strong>Listagem de Equipamentos</strong>
                    </h2>
                    <a href ="inserir.php" class="btn admin-btn-new">
                        <i class="fa-solid fa-plus me-1"></i>Novo Equipamento
                    </a>
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" id="pesquisa-equipamentos" class="form-control" placeholder="Pesquisar por código, designação, ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select class="form-select" style="max-width: 165px;">
                        <option value="" selected disabled>Categoria</option>
                        <option value="monitorizacao">Monitorização</option>
                        <option value="suporte_vida">Suporte de vida</option>
                        <option value="terapia">Terapia</option>
                        <option value="diagnostico">Diagnóstico</option>
                        <option value="laboratorio">Laboratório</option>
                        <option value="esterilizacao">Esterilização</option>
                        <option value="reabilitacao">Reabilitação</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Estado atual</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="manutencao">Em manutenção</option>
                        <option value="calibracao">Em calibração</option>
                        <option value="quarentena">Em quarentena</option>
                        <option value="abatido">Abatido</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Criticidade</option>
                        <option value="baixa">Baixa</option>
                        <option value="media">Média</option>
                        <option value="alta">Alta</option>
                        <option value="suporte_de_vida">Suporte de vida</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Fornecedor</option>
                        <option value="fabricante">Fabricante</option>
                        <option value="distribuidor">Distribuidor/fornecedor comercial</option>
                        <option value="assistencia_tecnica">Empresa de assistência técnica</option>
                        <option value="consumiveis">Fornecedor de consumíveis/acessórios</option>
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

                    <!-- Botão de filtros avançados -->
                    <button class="btn admin-btn-cancel filter-btn mt-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtrosAvancados">
                        <i class="fa-solid fa-sliders me-1"></i>
                    </button>
                </div>

                <!-- Botão de filtros avançados -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="filtrosAvancados">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">
                            <i class="fa-solid fa-filter me-2"></i>Filtros avançados
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>

                    <div class="offcanvas-body">
                        <div class="mb-3">
                            <label class="form-label">Designação</label>
                            <input type="text" class="form-control" placeholder="Ex: Ventilador pulmonar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Código interno</label>
                            <input type="text" class="form-control" placeholder="Ex: 04.002.00">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número de série</label>
                            <input type="text" class="form-control" placeholder="Ex: EV600-2025-9934">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de entrada</label>
                            <input type="text" class="form-control" placeholder="Ex: Compra">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" class="form-control" placeholder="Ex: Dräger">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text" class="form-control" placeholder="Ex: Evita V600">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fabricante</label>
                            <input type="text" class="form-control" placeholder="Ex: Dräger">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ano de fabrico</label>
                            <input type="text" class="form-control" placeholder="Ex: 2023">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Data de aquisição</label>
                            <input type="text" class="form-control" placeholder="Ex: 15/01/2023">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Custo de aquisição</label>
                            <input type="text" class="form-control" placeholder="Ex: 500€">
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button class="btn admin-btn-cancel">
                                <i class="fa-solid fa-eraser me-1"></i>Limpar
                            </button>

                            <button class="btn admin-btn-save">
                                <i class="fa-solid fa-magnifying-glass me-1"></i>Aplicar
                            </button>
                        </div>
                    </div>
                </div>   

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <?php if (!empty($erro)) : ?>
                        <p class="text-center text-danger"><?= $erro ?></p>
                    <?php else : ?>
                        <?php if (count($equipamentos) == 0) : ?>
                            <p class="text-muted">Não existem equipamentos registados.</p>
                        <?php else : ?>
                            <p class="text-muted equipamentos-total">Equipamentos registados: <?= count($equipamentos) ?></p>
                    
                    <div class="d-flex gap-2">

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
                        <table id="tabela-equipamentos" class="table table-bordered table-striped align-middle">   
                            <thead class="table-header">
                                <tr>
                                    <th class="text-center">Nome</th> 
                                    <th class="text-center">Código interno</th> 
                                    <th class="text-center">Categoria</th> 
                                    <th class="text-center">Marca</th> 
                                    <th class="text-center">Estado atual</th> 
                                    <th class="text-center">Criticidade</th> 
                                    <th class="text-center">Ações</th> 
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php foreach ($equipamentos as $equipamento) : ?>
                                    <tr>
                                        <td class="text-center"><?= $equipamento->nome ?></td>
                                        <td class="text-center"><?= $equipamento->codigo_interno ?></td>
                                        <td class="text-center"><?= $equipamento->categoria ?></td>
                                        <td class="text-center"><?= $equipamento->marca ?></td> 
                                        <td class="text-center">
                                            <span class="status-dot 
                                                <?php
                                                    if ($equipamento->estado == 'Ativo') echo 'status-active';
                                                    elseif ($equipamento->estado == 'Em manutenção') echo 'status-maintenance';
                                                    else echo 'status-inactive';
                                                ?>">
                                            </span>
                                            <?= $equipamento->estado ?>
                                        </td>

                                        <td class="text-center">
                                            <span class="status-dot 
                                                <?php
                                                    if ($equipamento->criticidade == 'Baixa') echo 'status-low';
                                                    elseif ($equipamento->criticidade == 'Média') echo 'status-medium';
                                                    elseif ($equipamento->criticidade == 'Alta') echo 'status-critical';
                                                    elseif ($equipamento->criticidade == 'Suporte de vida') echo 'status-life-support';
                                                ?>">
                                            </span>
                                            <?= $equipamento->criticidade ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"> 
                                                <i class="fa-solid fa-circle-info"></i> 
                                            </a>
                                            <a href="editar.php?id_equipamento=<?= aes_encrypt($equipamento->id_equipamento) ?>" class="btn btn-sm btn-outline-warning me-1">
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
                <?php endif; ?> <!-- Fecha o if (count($equipamentos) == 0) -->
                <?php endif; ?> <!-- Fecha o if (!empty($erro)) -->

                <div id="vistaDetalhe" class="d-none mb-5">
                    <div class="row g-3">
                        <?php foreach ($equipamentos as $equipamento) : ?>
                            <div class="col-lg-4">
                                <div class="card admin-card shadow rounded h-100">
                                    <div class="card-body">
                                        <h5 class="detail-section-title mb-3">
                                            <i class="fa-solid fa-laptop-medical me-2"></i>
                                            <?= $equipamento->nome ?>
                                        </h5>

                                        <p><strong>Código interno:</strong> <?= $equipamento->codigo_interno ?></p>
                                        <p><strong>Número de série:</strong> <?= $equipamento->numero_serie ?></p>
                                        <p><strong>Categoria:</strong> <?= $equipamento->categoria ?></p>
                                        <p><strong>Tipo de entrada:</strong> <?= $equipamento->tipo_entrada ?></p>
                                        <p><strong>Marca:</strong> <?= $equipamento->marca ?></p>
                                        <p><strong>Modelo:</strong> <?= $equipamento->modelo ?></p>
                                        <p>
                                            <strong>Estado atual:</strong>
                                            <span class="status-dot 
                                                <?php
                                                    if ($equipamento->estado == 'Ativo') echo 'status-active';
                                                    elseif ($equipamento->estado == 'Em manutenção') echo 'status-maintenance';
                                                    else echo 'status-inactive';
                                                ?>">
                                            </span>
                                            <?= $equipamento->estado ?>
                                        </p>

                                        <p>
                                            <strong>Criticidade:</strong>
                                            <span class="status-dot 
                                                <?php
                                                    if ($equipamento->criticidade == 'Baixa') echo 'status-low';
                                                    elseif ($equipamento->criticidade == 'Média') echo 'status-medium';
                                                    elseif ($equipamento->criticidade == 'Alta') echo 'status-critical';
                                                    elseif ($equipamento->criticidade == 'Suporte de vida') echo 'status-life-support';
                                                ?>">
                                            </span>
                                            <?= $equipamento->criticidade ?>
                                        </p>
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

    let tabela = $('#tabela-equipamentos').DataTable({
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
            },
            aria: {
                sortAscending: ": ativar para classificar a coluna em ordem crescente.",
                sortDescending: ": ativar para classificar a coluna em ordem decrescente."
            }
        }
    });

    $('#pesquisa-equipamentos').on('keyup', function () {
        tabela.search($(this).val()).draw();
    });

    });
    </script>

<?php include '../../includes/footer.php'; ?>