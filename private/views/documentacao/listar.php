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
                    <select class="form-select" style="max-width: 190px;">
                        <option value="" selected disabled>Tipo de documento</option>
                        <option value="manual_utilizador">Manual do Utilizador</option>
                        <option value="manual_tecnico">Manual Técnico</option>
                        <option value="certificado_ce">Certificado CE</option>
                        <option value="ficha_tecnica">Ficha Técnica</option>
                        <option value="relatorio_manutencao">Relatório de Manutenção</option>
                        <option value="calibracao">Certificado de Calibração</option>
                        <option value="inspecao">Relatório de Inspeção</option>
                        <option value="outro">Outro</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Validade</option>
                        <option value="com_validade">Com validade</option>
                        <option value="sem_validade">Sem validade</option>
                        <option value="expirado">Expirado</option>
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
                        <?php if (count($documentos) == 0) : ?>
                            <p class="text-muted">Não existem documentos registados.</p>
                        <?php else : ?>
                            <p class="text-muted">Documentos registados: <?= count($documentos) ?></p>
                </div>
                        <?php endif; ?>
                    <?php endif; ?>

                <div class="table-responsive">
                    <table id="tabela-documentos" class="table table-bordered table-striped align-middle">
                        <thead class="table-header">
                            <tr>
                                <th class="text-center">Código</th> 
                                <th class="text-center">Tipo do documento</th>
                                <th class="text-center">Equipamento associado</th> 
                                <th class="text-center">Data de validade</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                                
                        <tbody>
                            <?php foreach ($documentos as $documento) : ?>
                                <tr>
                                     <td class="text-center"><?= $documento->codigo_documento ?></td>
                                    <td class="text-center"><?= $documento->tipo_documento ?></td>
                                    <td class="text-center"><?= $documento->equipamento ?></td>
                                    <td class="text-center"><?= $documento->data_validade ?? 'Sem validade' ?></td>
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

    });
    </script>
    

<?php include '../../includes/footer.php'; ?>