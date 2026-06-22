<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

$idEquipamentoEncrypted = $_GET['id_equipamento'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncrypted);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
    header('Location: listar.php');
    exit;
}

$erro_sistema = "";
$equipamento = null;
$fornecedores_associados = [];
$documentos_associados = [];

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
        e.*,
        c.categoria,
        te.tipo_entrada,
        ee.estado,
        cr.criticidade,

        l.edificio,
        l.piso,
        l.servico_departamento,
        l.acesso,
        l.sala_gabinete,
        l.responsavel,
        l.observacoes AS observacoes_localizacao,

        f.nome_empresa,
        f.morada,
        f.codigo_postal,
        f.nif,
        f.contacto_empresa,
        f.email,
        f.website,
        f.pessoa_contacto,
        f.telefone_contacto,
        f.observacoes AS observacoes_fornecedor,
        tf.tipo_fornecedor,

        d.codigo_documento,
        d.nome_localizacao_documento,
        d.ficheiro,
        d.data_emissao,
        d.data_validade,
        d.observacoes AS observacoes_documento,
        td.tipo_documento,

        g.data_inicio,
        g.data_fim,
        g.existe_contrato,
        g.entidade_responsavel,
        g.observacoes AS observacoes_garantia,
        eg.estado_garantia,
        tc.tipo_contrato,
        p.periodicidade

    FROM equipamentos e
    LEFT JOIN categorias c ON e.id_categoria = c.id_categoria
    LEFT JOIN tipos_entrada te ON e.id_tipo_entrada = te.id_tipo_entrada
    LEFT JOIN estados_equipamento ee ON e.id_estado = ee.id_estado
    LEFT JOIN criticidades cr ON e.id_criticidade = cr.id_criticidade
    LEFT JOIN localizacoes l ON e.id_localizacao = l.id_localizacao
    LEFT JOIN equipamento_fornecedor ef ON e.id_equipamento = ef.id_equipamento
    LEFT JOIN fornecedores f ON ef.id_fornecedor = f.id_fornecedor
    LEFT JOIN tipos_fornecedor tf ON f.id_tipo_fornecedor = tf.id_tipo_fornecedor
    LEFT JOIN documentos d ON e.id_equipamento = d.id_equipamento
    LEFT JOIN tipos_documento td ON d.id_tipo_documento = td.id_tipo_documento
    LEFT JOIN garantias_contratos g ON e.id_equipamento = g.id_equipamento
    LEFT JOIN estados_garantia eg ON g.id_estado_garantia = eg.id_estado_garantia
    LEFT JOIN tipos_contrato tc ON g.id_tipo_contrato = tc.id_tipo_contrato
    LEFT JOIN periodicidade p ON g.id_periodicidade = p.id_periodicidade
    WHERE e.id_equipamento = :id_equipamento
    LIMIT 1
");

    $comando->execute([
        ':id_equipamento' => $idEquipamento
    ]);

    $equipamento = $comando->fetch(PDO::FETCH_OBJ);

    if (!$equipamento) {
        header('Location: listar.php');
        exit;
    }

    $comando = $ligacao->prepare("
        SELECT 
            f.codigo,
            f.nome_empresa,
            f.morada,
            f.codigo_postal,
            f.nif,
            f.contacto_empresa,
            f.email,
            f.website,
            f.pessoa_contacto,
            f.telefone_contacto,
            f.observacoes,
            tf.tipo_fornecedor
        FROM equipamento_fornecedor ef
        INNER JOIN fornecedores f ON ef.id_fornecedor = f.id_fornecedor
        LEFT JOIN tipos_fornecedor tf ON f.id_tipo_fornecedor = tf.id_tipo_fornecedor
        WHERE ef.id_equipamento = :id_equipamento
        ORDER BY f.codigo
    ");

    $comando->execute([
        ':id_equipamento' => $idEquipamento
    ]);

    $fornecedores_associados = $comando->fetchAll(PDO::FETCH_ASSOC);

    $comando = $ligacao->prepare("
        SELECT 
            d.codigo_documento,
            d.nome_localizacao_documento,
            d.ficheiro,
            d.data_emissao,
            d.data_validade,
            d.observacoes,
            d.documento_ativo,
            td.tipo_documento,
            f.nome_empresa AS fornecedor
        FROM documentos d
        LEFT JOIN tipos_documento td 
            ON d.id_tipo_documento = td.id_tipo_documento
        LEFT JOIN fornecedores f 
            ON d.id_fornecedor = f.id_fornecedor
        WHERE d.id_equipamento = :id_equipamento
        ORDER BY d.codigo_documento
    ");

    $comando->execute([
        ':id_equipamento' => $idEquipamento
    ]);

    $documentos_associados = $comando->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar os detalhes do equipamento.";
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
                                    Detalhes do Equipamento
                                </strong>

                                <?php if ($equipamento->equipamento_ativo == 1): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </h2>
                            
                            <ul class="nav nav-tabs justify-content-center mb-4" id="equipamentoTabs" role="tablist">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#equipamento"><i class="fa-solid fa-laptop-medical me-1"></i>Equipamento </button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fornecedor"><i class="fa-solid fa-truck-medical me-1"></i>Fornecedor</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#localizacao"><i class="fa-solid fa-house-medical-flag me-1"></i>Localização</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#documentacao"><i class="fa-solid fa-clipboard-user me-1"></i>Documentação</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#garantias"><i class="fa-solid fa-receipt me-1"></i>Garantias/Contratos</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="equipamento">
                                    <h5 class="detail-section-title">Identificação</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Nome do equipamento</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->nome) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Categoria</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->categoria) ?></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Código interno</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->codigo_interno) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Número de série</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->numero_serie) ?></p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Dados técnicos</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Marca</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->marca ?? '') ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Modelo</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->modelo ?? '') ?></p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Fabricante</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->fabricante ?? '') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Ano de fabrico</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->ano_fabrico ?? '') ?></p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Informações de aquisição</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="detail-label">Data de aquisição</label>
                                            <p class="detail-box"><?= date('d/m/Y', strtotime($equipamento->data_aquisicao)) ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Custo de aquisição</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->custo_aquisicao ?? '') ?> €</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Tipo de entrada</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->tipo_entrada ?? '') ?></p>
                                        </div>
                                    </div>

                                    <h5 class="detail-section-title">Condições do equipamento</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Estado atual</label>
                                            <p class="detail-box">
                                                <span class="status-dot 
                                                    <?php
                                                        if ($equipamento->estado == 'Ativo') echo 'status-active';
                                                        elseif ($equipamento->estado == 'Em manutenção') echo 'status-maintenance';
                                                        else echo 'status-inactive';
                                                    ?>">
                                                </span>
                                                <?= htmlspecialchars($equipamento->estado ?? '') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Criticidade</label>
                                            <p class="detail-box">
                                                <span class="status-dot 
                                                    <?php
                                                        if ($equipamento->criticidade == 'Baixa') echo 'status-low';
                                                        elseif ($equipamento->criticidade == 'Média') echo 'status-medium';
                                                        elseif ($equipamento->criticidade == 'Alta') echo 'status-critical';
                                                        elseif ($equipamento->criticidade == 'Suporte de vida') echo 'status-life-support';
                                                    ?>">
                                                </span>
                                                <?= htmlspecialchars($equipamento->criticidade ?? '') ?>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Outros</h5>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="detail-label">Observações</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->observacoes ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="fornecedor">
                                    <h5 class="detail-section-title">Fornecedores associados</h5>

                                    <?php if (!empty($fornecedores_associados)): ?>
                                        <?php foreach ($fornecedores_associados as $index => $fornecedor): ?>

                                            <div class="border rounded p-3 mb-3">

                                                <h5 class="detail-section-title mb-3">
                                                    <i class="fa-solid fa-truck-medical me-2"></i>
                                                    Fornecedor <?= $index + 1 ?> - <?= htmlspecialchars($fornecedor['nome_empresa']) ?>
                                                </h5>

                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="detail-label">Nome da empresa</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['codigo']) ?> -
                                                            <?= htmlspecialchars($fornecedor['nome_empresa']) ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="detail-label">Tipo de fornecedor</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['tipo_fornecedor'] ?? '') ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="detail-label">Morada</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['morada'] ?? '') ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="detail-label">Código postal</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['codigo_postal'] ?? '') ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="detail-label">NIF</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['nif'] ?? '') ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="detail-label">Contacto da empresa</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['contacto_empresa'] ?? '') ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Email</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['email'] ?? '') ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="detail-label">Website</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['website'] ?? '') ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <h6 class="detail-section-title">Pessoa de contacto</h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Nome</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['pessoa_contacto'] ?? '') ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="detail-label">Número telefónico</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['telefone_contacto'] ?? '') ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-12">
                                                        <label class="detail-label">Observações</label>
                                                        <p class="detail-box">
                                                            <?= htmlspecialchars($fornecedor['observacoes'] ?? '') ?>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <p class="detail-box text-muted">
                                            Sem fornecedores associados.
                                        </p>

                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane fade" id="localizacao">
                                    <h5 class="detail-section-title">Localização geral</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Edifício</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->edificio ?? '') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Piso</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->piso ?? '') ?></p>
                                        </div>
                                    </div>

                                    <h5 class="detail-section-title">Serviço</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-8">
                                            <label class="detail-label">Serviço/Departamento</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->servico_departamento ?? '') ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Acesso</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->acesso ?? '') ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Sala/Gabinete</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->sala_gabinete ?? '') ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Responsável</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->responsavel ?? '') ?></p>
                                        </div>
                                    </div>
                                    
                                    <h5 class="detail-section-title">Outros</h5>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="detail-label">Observações</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->observacoes_localizacao ?? '') ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="documentacao">
                                    <h5 class="detail-section-title">Documentação associada</h5>

                                    <?php if (!empty($documentos_associados)): ?>
                                        <?php foreach ($documentos_associados as $index => $documento): ?>

                                            <div class="border rounded p-3 mb-3">

                                                <h5 class="detail-section-title mb-3">
                                                    <i class="fa-solid fa-file-lines me-2"></i>
                                                    Documento <?= $index + 1 ?> - <?= htmlspecialchars($documento['codigo_documento']) ?>
                                                </h5>

                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <label class="detail-label">Código</label>
                                                        <p class="detail-box"><?= htmlspecialchars($documento['codigo_documento'] ?? '') ?></p>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="detail-label">Tipo de documento</label>
                                                        <p class="detail-box"><?= htmlspecialchars($documento['tipo_documento'] ?? '') ?></p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Nome/Localização do documento</label>
                                                        <p class="detail-box"><?= htmlspecialchars($documento['nome_localizacao_documento'] ?? '') ?></p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="detail-label">Ficheiro carregado</label>
                                                        <p class="detail-box">
                                                            <?php if (!empty($documento['ficheiro'])) : ?>
                                                                <a href="../../../uploads/documentos/<?= htmlspecialchars($documento['ficheiro']) ?>" 
                                                                target="_blank" 
                                                                class="btn btn-sm btn-outline-danger">
                                                                    <i class="fa-solid fa-file-pdf me-1"></i>Abrir PDF
                                                                </a>
                                                            <?php else : ?>
                                                                <span class="text-muted">Sem ficheiro associado</span>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="detail-label">Data de emissão</label>
                                                        <p class="detail-box">
                                                            <?= !empty($documento['data_emissao']) ? date('d/m/Y', strtotime($documento['data_emissao'])) : '' ?>
                                                        </p>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="detail-label">Data de validade</label>
                                                        <p class="detail-box">
                                                            <?= !empty($documento['data_validade']) ? date('d/m/Y', strtotime($documento['data_validade'])) : 'Sem validade definida' ?>
                                                        </p>
                                                    </div>
                                                </div>

                                                <h6 class="detail-section-title">Associações</h6>

                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <label class="detail-label">Fornecedor associado ao documento</label>
                                                        <p class="detail-box"><?= htmlspecialchars($documento['fornecedor'] ?? 'Sem fornecedor associado') ?></p>
                                                    </div>
                                                </div>

                                                <h6 class="detail-section-title">Outros</h6>

                                                <div class="row mb-0">
                                                    <div class="col-12">
                                                        <label class="detail-label">Observações</label>
                                                        <p class="detail-box"><?= htmlspecialchars($documento['observacoes'] ?? '') ?></p>
                                                    </div>
                                                </div>

                                            </div>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <p class="detail-box text-muted">
                                            Sem documentos associados.
                                        </p>

                                    <?php endif; ?>
                                </div>

                                <div class="tab-pane fade" id="garantias">
                                    <h5 class="detail-section-title">Informações da garantia</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="detail-label">Estado da garantia</label>
                                            <p class="detail-box">
                                                <span class="status-dot 
                                                    <?php
                                                        if ($equipamento->estado_garantia == 'Ativa') echo 'status-active';
                                                        elseif ($equipamento->estado_garantia == 'A expirar') echo 'status-medium';
                                                        elseif ($equipamento->estado_garantia == 'Expirada') echo 'status-critical';
                                                    ?>">
                                                </span>
                                                <?= htmlspecialchars($equipamento->estado_garantia ?? '') ?>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Data de início da garantia</label>
                                            <p class="detail-box"><?= !empty($equipamento->data_inicio) ? date('d/m/Y', strtotime($equipamento->data_inicio)) : '' ?></p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="detail-label">Data de fim da garantia</label>
                                            <p class="detail-box"><?= !empty($equipamento->data_fim) ? date('d/m/Y', strtotime($equipamento->data_fim)) : '' ?></p>
                                        </div>
                                    </div>
                                    <h5 class="detail-section-title">Informações do contrato</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Existência de contrato de manutenção</label>
                                            <p class="detail-box"><?= ($equipamento->existe_contrato == 1) ? 'Sim' : 'Não' ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Tipo de contrato</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->tipo_contrato ?? 'Sem contrato') ?></p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="detail-label">Entidade responsável</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->entidade_responsavel ?? '') ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="detail-label">Periodicidade</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->periodicidade ?? 'Sem periodicidade') ?></p>
                                        </div>
                                    </div>
                                    <h5 class="detail-section-title">Outros</h5>
                                    <div class="row mb-3">
                                        <div class="col-12">
                                            <label class="detail-label">Observações</label>
                                            <p class="detail-box"><?= htmlspecialchars($equipamento->observacoes_garantia ?? '') ?></p>
                                        </div>
                                    </div>
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