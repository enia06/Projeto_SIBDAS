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

    $garantias = $ligacao
        ->query("
            SELECT 
                g.*,
                e.nome AS equipamento,
                eg.estado_garantia,
                tc.tipo_contrato,
                p.periodicidade
            FROM garantias_contratos g
            LEFT JOIN equipamentos e
                ON g.id_equipamento = e.id_equipamento
            LEFT JOIN estados_garantia eg
                ON g.id_estado_garantia = eg.id_estado_garantia
            LEFT JOIN tipos_contrato tc
                ON g.id_tipo_contrato = tc.id_tipo_contrato
            LEFT JOIN periodicidade p
                ON g.id_periodicidade = p.id_periodicidade
        ")
        ->fetchAll(PDO::FETCH_OBJ);

    $erro = '';

} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $garantias = [];
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
                        <i class=""></i><strong>Listagem de Garantias/Contratos</strong>
                    </h2>
                
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" id="pesquisa-garantias" class="form-control" placeholder="Pesquisar por equipamento, tipo de contrato, ...">
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
                    <?php if (!empty($erro)) : ?>
                        <p class="text-center text-danger"><?= $erro ?></p>
                    <?php else : ?>
                        <?php if (count($garantias) == 0) : ?>
                            <p class="text-muted">Não existem garantias/contratos registados.</p>
                        <?php else : ?>
                            <p class="text-muted">Garantias/Contratos registados: <?= count($garantias) ?></p>
                </div>
                        <?php endif; ?>
                    <?php endif; ?>

                <div class="table-responsive">
                    <table id="tabela-garantias" class="table table-bordered table-striped align-middle">
                        <thead class="table-header">
                            <tr> 
                                <th class="text-center">Código</th> 
                                <th class="text-center">Equipamento associado</th> 
                                <th class="text-center">Fim da garantia</th> 
                                <th class="text-center">Estado</th> 
                                <th class="text-center">Tipo de contrato</th> 
                                <th class="text-center">Periodicidade</th> 
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach ($garantias as $garantia) : ?>
                                <tr>
                                    <td class="text-center"><?= $garantia->codigo_garantia ?></td>
                                    <td class="text-center"><?= $garantia->equipamento ?></td>
                                    <td class="text-center"><?= $garantia->data_fim ?></td>
                                    <td class="text-center">
                                        <span class="status-dot 
                                            <?php
                                                if ($garantia->estado_garantia == 'Ativa') echo 'status-active';
                                                elseif ($garantia->estado_garantia == 'A expirar') echo 'status-medium';
                                                elseif ($garantia->estado_garantia == 'Expirada') echo 'status-inactive';
                                            ?>">
                                        </span>
                                        <?= $garantia->estado_garantia ?>
                                    </td>
                                    <td class="text-center"><?= $garantia->tipo_contrato ?? 'Sem contrato' ?></td>
                                    <td class="text-center"><?= $garantia->periodicidade ?? 'Sem periodicidade' ?></td>
                                    <td class="text-center">
                                        <a href="detalhes.php?id_garantia=<?= aes_encrypt($garantia->id_garantia) ?>" class="btn btn-sm btn-outline-primary me-1"> 
                                            <i class="fa-solid fa-circle-info"></i> 
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
            </main>
        </div>
    </div> 
    
    <script src="../../../assets/js/1241327.js"></script>

    <script>
    $(document).ready(function () {

        let tabela = $('#tabela-garantias').DataTable({
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

        $('#pesquisa-garantias').on('keyup', function () {
            tabela.search($(this).val()).draw();
        });

    });
    </script>

<?php include '../../includes/footer.php'; ?>