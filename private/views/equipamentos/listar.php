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
$fornecedoresFiltro = [];
$servicosFiltro = [];

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
            te.tipo_entrada,
            l.servico_departamento,
            GROUP_CONCAT(f.nome_empresa SEPARATOR ', ') AS fornecedores
        FROM equipamentos e
        LEFT JOIN categorias c
            ON e.id_categoria = c.id_categoria
        LEFT JOIN estados_equipamento ee
            ON e.id_estado = ee.id_estado
        LEFT JOIN criticidades cr
            ON e.id_criticidade = cr.id_criticidade
        LEFT JOIN tipos_entrada te
            ON e.id_tipo_entrada = te.id_tipo_entrada
        LEFT JOIN localizacoes l
            ON e.id_localizacao = l.id_localizacao
        LEFT JOIN equipamento_fornecedor ef
            ON e.id_equipamento = ef.id_equipamento
        LEFT JOIN fornecedores f
            ON ef.id_fornecedor = f.id_fornecedor
        GROUP BY e.id_equipamento
        ORDER BY e.nome ASC
    ")
    ->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

    $fornecedoresFiltro = [];

    foreach ($equipamentos as $equipamento) {
        if (!empty($equipamento->fornecedores)) {
            $listaFornecedores = explode(',', $equipamento->fornecedores);

            foreach ($listaFornecedores as $fornecedor) {
                $fornecedor = trim($fornecedor);
                $fornecedoresFiltro[$fornecedor] = $fornecedor;
            }
        }
    }

    sort($fornecedoresFiltro);

    $servicosFiltro = [];

    foreach ($equipamentos as $equipamento) {
        if (!empty($equipamento->servico_departamento)) {
            $servicosFiltro[$equipamento->servico_departamento] = $equipamento->servico_departamento;
        }
    }

    sort($servicosFiltro);

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
                    <?php if ($_SESSION['perfil'] != 'profissional_saude'): ?>
                        <a href="inserir.php" class="btn admin-btn-new">
                            <i class="fa-solid fa-plus me-1"></i> Novo equipamento
                        </a>
                    <?php endif; ?>
                </div>
                <hr> 

                <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['mensagem_sucesso']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['mensagem_sucesso']); ?>
                <?php endif; ?>

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" id="pesquisa-equipamentos" class="form-control" placeholder="Pesquisar por código, designação, ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select id="filtro-categoria" class="form-select" style="max-width: 165px;">
                        <option value="">-- Categoria --</option>
                        <option value="Monitorização">Monitorização</option>
                        <option value="Suporte de vida">Suporte de vida</option>
                        <option value="Terapia">Terapia</option>
                        <option value="Diagnóstico">Diagnóstico</option>
                        <option value="Laboratório">Laboratório</option>
                        <option value="Esterilização">Esterilização</option>
                        <option value="Reabilitação">Reabilitação</option>
                    </select>

                    <select id="filtro-estado" class="form-select" style="max-width: 145px;">
                        <option value="">-- Estado --</option>
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                        <option value="Em manutenção">Em manutenção</option>
                        <option value="Em calibração">Em calibração</option>
                        <option value="Em quarentena">Em quarentena</option>
                        <option value="Abatido">Abatido</option>
                    </select>

                    <select id="filtro-criticidade" class="form-select" style="max-width: 145px;">
                        <option value="">-- Criticidade --</option>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                        <option value="Suporte de vida">Suporte de vida</option>
                    </select>

                    <select id="filtro-fornecedor" class="form-select" style="max-width: 145px;">
                        <option value="">-- Fornecedor --</option>

                        <?php foreach ($fornecedoresFiltro as $fornecedor) : ?>
                            <option value="<?= htmlspecialchars($fornecedor) ?>">
                                <?= htmlspecialchars($fornecedor) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <select id="filtro-servico" class="form-select" style="max-width: 145px;">
                        <option value="">-- Serviço --</option>

                        <?php foreach ($servicosFiltro as $servico) : ?>
                            <option value="<?= htmlspecialchars($servico) ?>">
                                <?= htmlspecialchars($servico) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

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
                            <input type="text" id="filtro-designacao" class="form-control" placeholder="Ex: Ventilador pulmonar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Código interno</label>
                            <input type="text" id="filtro-codigo" class="form-control" placeholder="Ex: 04.002.00">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número de série</label>
                            <input type="text" id="filtro-serie" class="form-control" placeholder="Ex: EV600-2025-9934">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de entrada</label>
                            <input type="text" id="filtro-tipo-entrada" class="form-control" placeholder="Ex: Compra">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <input type="text" id="filtro-marca" class="form-control" placeholder="Ex: Dräger">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text" id="filtro-modelo" class="form-control" placeholder="Ex: Evita V600">
                        </div>
                    
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" id="limpar-filtros-avancados" class="btn admin-btn-cancel">
                                <i class="fa-solid fa-eraser me-1"></i>Limpar
                            </button>

                            <button type="button" id="aplicar-filtros-avancados" class="btn admin-btn-save">
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

                        <a href="<?= BASE_URL ?>/private/exportacao/exportar.php?tipo=equipamentos&formato=csv" class="btn admin-btn-view">
                            <i class="fa-solid fa-file-csv me-1"></i>CSV
                        </a>

                        <a href="<?= BASE_URL ?>/private/exportacao/exportar.php?tipo=equipamentos&formato=json" class="btn admin-btn-view">
                            <i class="fa-solid fa-file-code me-1"></i>JSON
                        </a>

                        <a href="<?= BASE_URL ?>/private/exportacao/exportar.php?tipo=equipamentos&formato=pdf" class="btn admin-btn-view" target="_blank">
                            <i class="fa-solid fa-file-pdf me-1"></i>PDF
                        </a>

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
                                    <th>Fornecedor</th>
                                    <th>Serviço</th>
                                    <th>Número de série</th>
                                    <th>Tipo de entrada</th>
                                    <th>Modelo</th>
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
                                        <td><?= htmlspecialchars($equipamento->fornecedores ?? '') ?></td>
                                        <td><?= htmlspecialchars($equipamento->servico_departamento ?? '') ?></td>
                                        <td><?= htmlspecialchars($equipamento->numero_serie ?? '') ?></td>
                                        <td><?= htmlspecialchars($equipamento->tipo_entrada ?? '') ?></td>
                                        <td><?= htmlspecialchars($equipamento->modelo ?? '') ?></td>

                                        <td class="text-center">
                                            <a href="detalhes.php?id_equipamento=<?= aes_encrypt($equipamento->id_equipamento) ?>" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <?php if ($_SESSION['perfil'] != 'profissional_saude'): ?>
                                                <a href="editar.php?id_equipamento=<?= aes_encrypt($equipamento->id_equipamento) ?>" class="btn btn-sm btn-outline-warning">
                                                    <i class="fa-solid fa-file-pen"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['perfil'] != 'profissional_saude' && $equipamento->equipamento_ativo == 1): ?>
                                                <a href="remover.php?id_equipamento=<?= aes_encrypt($equipamento->id_equipamento) ?>" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            <?php endif; ?>
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

            columnDefs: [
                {
                    targets: [6, 7, 8, 9, 10],
                    visible: false,
                    searchable: true
                }
            ],

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

        $('#filtro-categoria').on('change', function () {
            tabela.column(2).search(this.value).draw();
        });

        $('#filtro-estado').on('change', function () {
            tabela.column(4).search(this.value).draw();
        });

        $('#filtro-criticidade').on('change', function () {
            tabela.column(5).search(this.value).draw();
        });

        $('#filtro-fornecedor').on('change', function () {
            tabela.column(6).search(this.value).draw();
        });

        $('#filtro-servico').on('change', function () {
            tabela.column(7).search(this.value).draw();
        });

        $('#aplicar-filtros-avancados').on('click', function () {
        tabela.column(0).search($('#filtro-designacao').val()).draw();
        tabela.column(1).search($('#filtro-codigo').val()).draw();
        tabela.column(3).search($('#filtro-marca').val()).draw();
        tabela.column(8).search($('#filtro-serie').val()).draw();
        tabela.column(9).search($('#filtro-tipo-entrada').val()).draw();
        tabela.column(10).search($('#filtro-modelo').val()).draw();

        bootstrap.Offcanvas.getInstance(
            document.getElementById('filtrosAvancados')
        ).hide();
    });

    $('#limpar-filtros-avancados').on('click', function () {
        $('#filtro-categoria').val('');
        $('#filtro-estado').val('');
        $('#filtro-criticidade').val('');
        $('#filtro-fornecedor').val('');
        $('#filtro-servico').val('');
        $('#filtro-designacao').val('');
        $('#filtro-codigo').val('');
        $('#filtro-serie').val('');
        $('#filtro-tipo-entrada').val('');
        $('#filtro-marca').val('');
        $('#filtro-modelo').val('');

        tabela.column(2).search('');
        tabela.column(4).search('');
        tabela.column(5).search('');
        tabela.column(6).search('');
        tabela.column(7).search('');
        tabela.column(0).search('');
        tabela.column(1).search('');
        tabela.column(3).search('');
        tabela.column(8).search('');
        tabela.column(9).search('');
        tabela.column(10).search('');
        tabela.draw();

        bootstrap.Offcanvas.getInstance(
            document.getElementById('filtrosAvancados')
        ).hide();
    });

    });
    </script>

<?php include '../../includes/footer.php'; ?>