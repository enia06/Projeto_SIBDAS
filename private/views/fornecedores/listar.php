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
    
    $fornecedores = $ligacao
        ->query("
            SELECT 
                f.*,
                tf.tipo_fornecedor
            FROM fornecedores f
            LEFT JOIN tipos_fornecedor tf
                ON f.id_tipo_fornecedor = tf.id_tipo_fornecedor
        ")
        ->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $fornecedores = [];
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
                        <input type="text" id="pesquisa-fornecedores" class="form-control" placeholder="Pesquisar por código, tipo de fornecedor, ...">
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

                    <?php if (!empty($erro)) : ?>
                        <p class="text-center text-danger"><?= $erro ?></p>
                    <?php else : ?>
                        <?php if (count($fornecedores) == 0) : ?>
                            <p class="text-muted">Não existem fornecedores registados.</p>
                        <?php else : ?>
                            <p class="text-muted fornecedores-total">Fornecedores registados: <?= count($fornecedores) ?></p>

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
                        <table id="tabela-fornecedores" class="table table-bordered table-striped align-middle">
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
                                <?php foreach ($fornecedores as $fornecedor) : ?>
                                    <tr>
                                        <td class="text-center"><?= $fornecedor->codigo ?></td>
                                        <td class="text-center"><?= $fornecedor->nome_empresa ?></td>
                                        <td class="text-center"><?= $fornecedor->tipo_fornecedor ?></td>
                                        <td class="text-center"><?= $fornecedor->contacto_empresa ?></td>
                                        <td class="text-center"><?= $fornecedor->email ?></td>
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
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>  
                </div>
                <?php endif; ?> <!-- Fecha o if (count($equipamentos) == 0) -->
                <?php endif; ?> <!-- Fecha o if (!empty($erro)) -->

                <div id="vistaDetalhe" class="d-none mb-5">
                    <div class="row g-3">
                        <?php foreach ($fornecedores as $fornecedor) : ?>
                            <div class="col-lg-4">
                                <div class="card admin-card shadow rounded h-100">
                                    <div class="card-body ">
                                        <h5 class="detail-section-title mb-3">
                                            <i class="fa-solid fa-truck-medical me-2"></i> <?= $fornecedor->nome_empresa ?>
                                        </h5>
                                        <p><strong>Código:</strong> <?= $fornecedor->codigo ?></p>
                                        <p><strong>Tipo de fornecedor:</strong> <?= $fornecedor->tipo_fornecedor ?></p>
                                        <p><strong>Morada:</strong> <?= $fornecedor->morada ?></p>
                                        <p><strong>NIF:</strong> <?= $fornecedor->nif ?></p>
                                        <p><strong>Contacto:</strong> <?= $fornecedor->contacto_empresa ?></p>
                                        <p><strong>Email:</strong> <?= $fornecedor->email ?></p>
                                        <p><strong>Pessoa de contacto:</strong> <?= $fornecedor->pessoa_contacto ?></p>
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

        let tabela = $('#tabela-fornecedores').DataTable({
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

        $('#pesquisa-fornecedores').on('keyup', function () {
            tabela.search($(this).val()).draw();
        });

    });
    </script>

<?php include '../../includes/footer.php'; ?>