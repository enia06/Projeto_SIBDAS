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

    $documentos = $ligacao
        ->query("
            SELECT 
                d.*,
                td.tipo_documento,
                e.nome AS equipamento
            FROM documentos d
            LEFT JOIN tipos_documento td 
                ON d.id_tipo_documento = td.id_tipo_documento
            LEFT JOIN equipamentos e 
                ON d.id_equipamento = e.id_equipamento
        ")
        ->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $documentos = [];
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
                        <i class=""></i><strong>Listagem de Documentos</strong>
                    </h2>
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" id="pesquisa-documentos" class="form-control" placeholder="Pesquisar por código, tipo de documento ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select id="filtro-tipo-documento" class="form-select" style="max-width: 190px;">
                        <option value="">-- Tipo documento --</option>
                        <option value="Manual do Utilizador">Manual do Utilizador</option>
                        <option value="Manual Técnico">Manual Técnico</option>
                        <option value="Certificado CE">Certificado CE</option>
                        <option value="Ficha Técnica">Ficha Técnica</option>
                        <option value="Relatório de Manutenção">Relatório de Manutenção</option>
                        <option value="Certificado de Calibração">Certificado de Calibração</option>
                        <option value="Relatório de Inspeção">Relatório de Inspeção</option>
                        <option value="Outro">Outro</option>
                    </select>

                    <select id="filtro-validade" class="form-select" style="max-width: 145px;">
                        <option value="">-- Validade --</option>
                        <option value="Com validade">Com validade</option>
                        <option value="Sem validade">Sem validade</option>
                        <option value="Expirado">Expirado</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <?php if (!empty($erro)) : ?>
                        <p class="text-center text-danger"><?= $erro ?></p>
                    <?php else : ?>
                        <?php if (count($documentos) == 0) : ?>
                            <p class="text-muted">Não existem documentos registados.</p>
                        <?php else : ?>
                            <p class="text-muted">Documentos registados: <?= count($documentos) ?></p>
                </div>
                        <?php endif; ?>
                    <?php endif; ?>

                <div class="table-responsive overflow-hidden">
                    <table id="tabela-documentos" class="table table-bordered table-striped align-middle">
                        <thead class="table-header">
                            <tr>
                                <th class="text-center">Código</th> 
                                <th class="text-center">Tipo do documento</th>
                                <th class="text-center">Equipamento associado</th> 
                                <th class="text-center">Data de validade</th>
                                <th>Estado validade</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                                
                        <tbody>
                            <?php foreach ($documentos as $documento) : ?>
                                <tr>
                                     <td class="text-center"><?= $documento->codigo_documento ?></td>
                                    <td class="text-center"><?= $documento->tipo_documento ?></td>
                                    <td class="text-center"><?= $documento->equipamento ?></td>
                                    <td class="text-center">
                                        <?= !empty($documento->data_validade) ? $documento->data_validade : 'Sem validade' ?>
                                    </td>
                                    <?php
                                        if (empty($documento->data_validade)) {
                                            $estado_validade = 'Sem validade';
                                        } elseif ($documento->data_validade < date('Y-m-d')) {
                                            $estado_validade = 'Expirado';
                                        } else {
                                            $estado_validade = 'Com validade';
                                        }
                                    ?>

                                    <td><?= $estado_validade ?></td>
                                    <td class="text-center">
                                        <a href="detalhes.php?id_documento=<?= aes_encrypt($documento->id_documento) ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        <?php if ($_SESSION['perfil'] != 'profissional_saude'): ?>
                                            <a href="remover.php?id=..." class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    
    <script>
    $(document).ready(function () {

        let tabela = $('#tabela-documentos').DataTable({
            dom: 'lrtip',
            pageLength: 5,
            pagingType: "full_numbers",

            columnDefs: [
                {
                    targets: [4],
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
                }
            }
        });

        $('#pesquisa-documentos').on('keyup', function () {
            tabela.search($(this).val()).draw();
        });

        $('#filtro-tipo-documento').on('change', function () {
            tabela.column(1).search(this.value).draw();
        });

        $('#filtro-validade').on('change', function () {
            tabela.column(4).search(this.value).draw();
        });

    });
    </script>
    

<?php include '../../includes/footer.php'; ?>