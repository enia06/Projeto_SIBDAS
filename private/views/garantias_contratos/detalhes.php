<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idGarantiaEncrypted = $_GET['id_garantia'] ?? null;
$idGarantia = aes_decrypt($idGarantiaEncrypted);

if (!$idGarantia || !is_numeric($idGarantia)) {
    header('Location: listar.php');
    exit;
}

$erro_sistema = "";
$garantia = null;
$estado_garantia = "";
$classe_estado = "";

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST .
        ";port=" . MYSQL_PORT .
        ";dbname=" . MYSQL_DATABASE .
        ";charset=utf8mb4",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );

    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $comando = $ligacao->prepare("
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
        WHERE g.id_garantia = :id_garantia
    ");

    $comando->execute([
        ':id_garantia' => $idGarantia
    ]);

    $garantia = $comando->fetch(PDO::FETCH_OBJ);

    if (!$garantia) {
        header('Location: listar.php');
        exit;
    }

    if (!empty($garantia->data_fim) && $garantia->data_fim < date('Y-m-d')) {
        $estado_garantia = 'Expirada';
        $classe_estado = 'status-inactive';
    } elseif (!empty($garantia->data_fim) && $garantia->data_fim <= date('Y-m-d', strtotime('+30 days'))) {
        $estado_garantia = 'A expirar';
        $classe_estado = 'status-medium';
    } else {
        $estado_garantia = 'Ativa';
        $classe_estado = 'status-active';
    }

} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar os detalhes da garantia.";
}

$ligacao = null;
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-0 pb-4 px-4">
                <div class="d-flex justify-content-center mt-1">
                    <div class="card admin-card w-100 shadow rounded" style="max-width: 950px;">
                         <div class="card-body">
                            <h2 class="mb-4">
                                <strong>
                                    <i class="fa-solid fa-circle-info me-2"></i>
                                    Detalhes da garantia
                                </strong>

                                <?php if ($garantia->garantia_ativa == 1): ?>
                                    <span class="badge bg-success">Ativa</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativa</span>
                                <?php endif; ?>
                            </h2>
                        
                            <h5 class="detail-section-title">Informações da garantia</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Código</label>
                                    <p class="detail-box"><?= htmlspecialchars($garantia->codigo_garantia ?? '') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Equipamento associado</label>
                                    <p class="detail-box"><?= htmlspecialchars($garantia->equipamento ?? '') ?></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="detail-label">Data de início da garantia</label>
                                    <p class="detail-box"><?= !empty($garantia->data_inicio) ? date('d/m/Y', strtotime($garantia->data_inicio)) : '' ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Data de fim da garantia</label>
                                    <p class="detail-box"><?= !empty($garantia->data_fim) ? date('d/m/Y', strtotime($garantia->data_fim)) : '' ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Estado</label>
                                    <p class="detail-box">
                                        <span class="status-dot <?= $classe_estado ?>"></span>
                                        <?= $estado_garantia ?>
                                    </p>
                                </div>
                            </div>

                            <h5 class="detail-section-title">Informações do contrato</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Existência de contrato de manutenção</label>
                                    <p class="detail-box"><?= ($garantia->existe_contrato == 1) ? 'Sim' : 'Não' ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Tipo de contrato</label>
                                    <p class="detail-box"><?= htmlspecialchars($garantia->tipo_contrato ?? 'Sem contrato') ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Entidade responsável</label>
                                    <p class="detail-box"><?= htmlspecialchars($garantia->entidade_responsavel ?? '') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Periodicidade</label>
                                    <p class="detail-box"><?= htmlspecialchars($garantia->periodicidade ?? 'Sem periodicidade') ?></p>
                                </div>
                            </div>
                            
                            <h5 class="detail-section-title">Outros</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="detail-label">Observações</label>
                                    <p class="detail-box"><?= htmlspecialchars($garantia->observacoes ?? '') ?></p>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">                     
                                <a href="listar.php" class="btn btn-outline-secondary">                         
                                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar                     
                                </a>                 
                            </div>  
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>                         

<?php include '../../includes/footer.php'; ?>