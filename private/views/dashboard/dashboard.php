<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

include '../../includes/header.php';
include '../../includes/nav.php';

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

    $total_equipamentos = $ligacao->query("SELECT COUNT(*) FROM equipamentos")->fetchColumn();

    $ativos = $ligacao->query("
        SELECT COUNT(*)
        FROM equipamentos e
        INNER JOIN estados_equipamento ee ON e.id_estado = ee.id_estado
        WHERE ee.estado = 'Ativo'
    ")->fetchColumn();

    $manutencao = $ligacao->query("
        SELECT COUNT(*)
        FROM equipamentos e
        INNER JOIN estados_equipamento ee ON e.id_estado = ee.id_estado
        WHERE ee.estado = 'Em manutenção'
    ")->fetchColumn();

    $inativos = $ligacao->query("
        SELECT COUNT(*)
        FROM equipamentos e
        INNER JOIN estados_equipamento ee ON e.id_estado = ee.id_estado
        WHERE ee.estado = 'Inativo'
    ")->fetchColumn();

    $garantias_expiradas = $ligacao->query("
        SELECT COUNT(*)
        FROM garantias_contratos
        WHERE data_fim < CURDATE()
    ")->fetchColumn();

    $garantias_expirar = $ligacao->query("
        SELECT COUNT(*)
        FROM garantias_contratos
        WHERE data_fim BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    ")->fetchColumn();

    $sem_documentacao = $ligacao->query("
        SELECT COUNT(*)
        FROM equipamentos e
        LEFT JOIN documentos d ON e.id_equipamento = d.id_equipamento
        WHERE d.id_documento IS NULL
        OR d.ficheiro IS NULL
        OR d.ficheiro = ''
    ")->fetchColumn();

    $criticidade_elevada = $ligacao->query("
        SELECT COUNT(*)
        FROM equipamentos e
        INNER JOIN criticidades c ON e.id_criticidade = c.id_criticidade
        WHERE c.criticidade IN ('Alta', 'Suporte de vida')
    ")->fetchColumn();

    $equipamentos_servico = $ligacao->query("
        SELECT l.servico_departamento, COUNT(*) AS total
        FROM equipamentos e
        INNER JOIN localizacoes l ON e.id_localizacao = l.id_localizacao
        GROUP BY l.servico_departamento
        ORDER BY total DESC
    ")->fetchAll(PDO::FETCH_OBJ);

    $suporte_vida_servico = $ligacao->query("
        SELECT l.servico_departamento, COUNT(*) AS total
        FROM equipamentos e
        INNER JOIN localizacoes l ON e.id_localizacao = l.id_localizacao
        INNER JOIN criticidades c ON e.id_criticidade = c.id_criticidade
        WHERE c.criticidade = 'Suporte de vida'
        GROUP BY l.servico_departamento
        ORDER BY total DESC
    ")->fetchAll(PDO::FETCH_OBJ);

    $categorias_grafico = $ligacao->query("
        SELECT c.categoria, COUNT(*) AS total
        FROM equipamentos e
        INNER JOIN categorias c ON e.id_categoria = c.id_categoria
        GROUP BY c.categoria
        ORDER BY total DESC
    ")->fetchAll(PDO::FETCH_OBJ);

    $localizacoes_grafico = $ligacao->query("
        SELECT l.edificio, COUNT(*) AS total
        FROM equipamentos e
        INNER JOIN localizacoes l ON e.id_localizacao = l.id_localizacao
        GROUP BY l.edificio
        ORDER BY total DESC
    ")->fetchAll(PDO::FETCH_OBJ);

} catch (PDOException $err) {
    $total_equipamentos = 0;
    $ativos = 0;
    $manutencao = 0;
    $inativos = 0;
    $garantias_expiradas = 0;
    $garantias_expirar = 0;
    $sem_documentacao = 0;
    $criticidade_elevada = 0;
    $equipamentos_servico = [];
    $suporte_vida_servico = [];
    $categorias_grafico = [];
    $localizacoes_grafico = [];
}

$ligacao = null;
?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 pb-5 px-5">
                <div class="mb-4">
                    <h2 class="mb-1">
                        <strong>Dashboard</strong>
                    </h2>
                    <p class="text-muted mt-2 fs-5">
                        Resumo geral sobre os equipamentos médicos
                    </p>
                </div>
                <hr>

                <!-- Indicadores principais -->
                <h5 class="detail-section-title">Estado dos equipamentos</h5>
                <div class="row g-3 mb-5">
                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-laptop-medical dashboard-icon"></i>
                            <h3><?= $total_equipamentos ?></h3>
                            <p>Total de equipamentos</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-circle-check dashboard-icon"></i>
                            <h3><?= $ativos ?></h3>
                            <p>Equipamentos ativos</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-screwdriver-wrench dashboard-icon"></i>
                            <h3><?= $manutencao ?></h3>
                            <p>Em manutenção</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-card text-center">
                            <i class="fa-solid fa-circle-xmark dashboard-icon"></i>
                            <h3><?= $inativos ?></h3>
                            <p>Equipamentos inativos</p>
                        </div>
                    </div>
                </div>

                <!-- Alertas -->
                <h5 class="detail-section-title">Alertas e indicadores críticos</h5>
                <div class="row g-3 mb-5">
                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong><?= $garantias_expiradas ?></strong>
                            <span>Garantias expiradas</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong><?= $garantias_expirar ?></strong>
                            <span>Garantias a expirar em 30 dias</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong><?= $sem_documentacao ?></strong>
                            <span>Sem documentação associada</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="dashboard-alert">
                            <strong><?= $criticidade_elevada ?></strong>
                            <span>Criticidade elevada</span>
                        </div>
                    </div>
                </div>

                <!-- Tabelas resumo -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Equipamentos por serviço</h5>
                            <table class="table table-bordered align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th class="text-center">Serviço</th>
                                        <th class="text-center">N.º equipamentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($equipamentos_servico as $linha) : ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($linha->servico_departamento) ?></td>
                                            <td class="text-center"><?= $linha->total ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Equipamentos de suporte de vida por serviço</h5>
                            <table class="table table-bordered align-middle">
                                <thead class="table-header">
                                    <tr>
                                        <th class="text-center">Serviço</th>
                                        <th class="text-center">N.º equipamentos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($suporte_vida_servico as $linha) : ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($linha->servico_departamento) ?></td>
                                            <td class="text-center"><?= $linha->total ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Distribuição por categoria</h5>
                            <div class="dashboard-pie-container">
                                <canvas id="graficoCategorias" width="220" height="220"></canvas>
                                <div class="dashboard-legend">
                                    <?php foreach ($categorias_grafico as $index => $linha) : ?>
                                        <div>
                                            <span class="legend-<?= ($index % 4) + 1 ?>"></span>
                                            <?= htmlspecialchars($linha->categoria) ?> (<?= $linha->total ?>)
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="dashboard-box">
                            <h5 class="detail-section-title text-center mb-3">Distribuição por localização</h5>
                            <div class="dashboard-pie-container">
                                <canvas id="graficoLocalizacoes" width="220" height="220"></canvas>
                                <div class="dashboard-legend">
                                    <?php foreach ($localizacoes_grafico as $index => $linha) : ?>
                                        <div>
                                            <span class="legend-<?= ($index % 4) + 1 ?>"></span>
                                            <?= htmlspecialchars($linha->edificio) ?> (<?= $linha->total ?>)
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../assets/js/1241327.js"></script>

    <script>
    const dadosCategorias = <?= json_encode(array_column($categorias_grafico, 'total')) ?>;
    const dadosLocalizacoes = <?= json_encode(array_column($localizacoes_grafico, 'total')) ?>;

    desenharGraficoCircular(
        "graficoCategorias",
        dadosCategorias,
        ["#602323", "#a33c44", "#c9757b", "#ebcece"]
    );

    desenharGraficoCircular(
        "graficoLocalizacoes",
        dadosLocalizacoes,
        ["#602323", "#a33c44", "#c9757b", "#ebcece"]
    );
    </script>

<?php include '../../includes/footer.php'; ?>

