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
                    <?php if ($_SESSION['perfil'] != 'profissional_saude'): ?>
                        <a href="inserir.php" class="btn admin-btn-new">
                            <i class="fa-solid fa-plus me-1"></i> Nova localização
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
                        <input type="text" id="pesquisa-localizacoes" class="form-control" placeholder="Pesquisar por edifício, piso ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select id="filtro-edificio" class="form-select" style="max-width: 145px;">
                        <option value="">-- Edifício --</option>
                        <option value="Bloco A">Bloco A</option>
                        <option value="Bloco B">Bloco B</option>
                        <option value="Bloco C">Bloco C</option>
                        <option value="Bloco D">Bloco D</option>
                        <option value="Bloco E">Bloco E</option>
                        <option value="Bloco F">Bloco F</option>
                    </select>

                    <select id="filtro-piso" class="form-select" style="max-width: 145px;">
                        <option value="">-- Piso --</option>
                        <option value="Piso 0">Piso 0</option>
                        <option value="Piso 1">Piso 1</option>
                        <option value="Piso 2">Piso 2</option>
                        <option value="Piso 3">Piso 3</option>
                        <option value="Piso 4">Piso 4</option>
                        <option value="Piso 5">Piso 5</option>
                    </select>

                    <select id="filtro-servico" class="form-select" style="max-width: 145px;">
                        <option value="">-- Serviço --</option>
                        <option value="Urgências">Urgências</option>
                        <option value="Unidade de Cuidados Intensivos">UCI</option>
                        <option value="Pediatria">Pediatria</option>
                        <option value="Cardiologia">Cardiologia</option>
                        <option value="Neurologia">Neurologia</option>
                        <option value="Ortopedia">Ortopedia</option>
                        <option value="Radiologia">Radiologia</option>
                        <option value="Imagiologia">Imagiologia</option>
                        <option value="Laboratório de Análises Clínicas">Laboratório</option>
                        <option value="Farmácia Hospitalar">Farmácia</option>
                    </select>
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
                        <div class="d-flex gap-2">
                            <a href="<?= BASE_URL ?>/private/exportacao/exportar.php?tipo=localizacoes&formato=csv" class="btn admin-btn-view">
                                <i class="fa-solid fa-file-csv me-1"></i>CSV
                            </a>

                            <a href="<?= BASE_URL ?>/private/exportacao/exportar.php?tipo=localizacoes&formato=json" class="btn admin-btn-view">
                                <i class="fa-solid fa-file-code me-1"></i>JSON
                            </a>

                            <a href="<?= BASE_URL ?>/private/exportacao/exportar.php?tipo=localizacoes&formato=pdf" class="btn admin-btn-view" target="_blank">
                                <i class="fa-solid fa-file-pdf me-1"></i>PDF
                            </a>

                        </div>
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
                                        <td class="text-center"><?= htmlspecialchars($localizacao->codigo) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($localizacao->edificio) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($localizacao->piso) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($localizacao->servico_departamento) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($localizacao->sala_gabinete) ?></td>
                    
                                        <td class="text-center">
                                            <a href="detalhes.php?id_localizacao=<?= aes_encrypt($localizacao->id_localizacao) ?>" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <?php if ($_SESSION['perfil'] != 'profissional_saude'): ?>
                                                <a href="editar.php?id_localizacao=<?= aes_encrypt($localizacao->id_localizacao) ?>" class="btn btn-sm btn-outline-warning me-1">
                                                    <i class="fa-solid fa-file-pen"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['perfil'] != 'profissional_saude' && $localizacao->localizacao_ativa == 1): ?>
                                                <a href="remover.php?id_localizacao=<?= aes_encrypt($localizacao->id_localizacao) ?>" class="btn btn-sm btn-outline-danger">
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

    function aplicarFiltrosLocalizacoes() {
        let pesquisa = $('#pesquisa-localizacoes').val().toLowerCase();
        let edificio = $('#filtro-edificio').val().toLowerCase();
        let piso = $('#filtro-piso').val().toLowerCase();
        let servico = $('#filtro-servico').val().toLowerCase();

        $.fn.dataTable.ext.search = [];

        $.fn.dataTable.ext.search.push(function (settings, data) {
            if (settings.nTable.id !== 'tabela-localizacoes') {
                return true;
            }

            let codigo = (data[0] || '').toLowerCase();
            let edificioTabela = (data[1] || '').toLowerCase();
            let pisoTabela = (data[2] || '').toLowerCase();
            let servicoTabela = (data[3] || '').toLowerCase();
            let salaTabela = (data[4] || '').toLowerCase();

            let textoLinha = codigo + ' ' + edificioTabela + ' ' + pisoTabela + ' ' + servicoTabela + ' ' + salaTabela;

            let correspondePesquisa = pesquisa === '' || textoLinha.includes(pesquisa);
            let correspondeEdificio = edificio === '' || edificioTabela === edificio;
            let correspondePiso = piso === '' || pisoTabela === piso;
            let correspondeServico = servico === '' || servicoTabela === servico;

            return correspondePesquisa && correspondeEdificio && correspondePiso && correspondeServico;
        });

        tabela.draw();
    }

    $('#pesquisa-localizacoes').on('keyup input', aplicarFiltrosLocalizacoes);
    $('#filtro-edificio').on('change', aplicarFiltrosLocalizacoes);
    $('#filtro-piso').on('change', aplicarFiltrosLocalizacoes);
    $('#filtro-servico').on('change', aplicarFiltrosLocalizacoes);
});
</script>

<?php include '../../includes/footer.php'; ?>


