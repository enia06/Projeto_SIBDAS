<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

$idDocumentoEncrypted = $_GET['id_documento'] ?? null;
$idDocumento = aes_decrypt($idDocumentoEncrypted);

if (!$idDocumento || !is_numeric($idDocumento)) {
    header('Location: listar.php');
    exit;
}

$erro_sistema = "";
$documento = null;

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
            d.*,
            td.tipo_documento,
            e.nome AS equipamento,
            f.nome_empresa AS fornecedor
        FROM documentos d
        LEFT JOIN tipos_documento td
            ON d.id_tipo_documento = td.id_tipo_documento
        LEFT JOIN equipamentos e
            ON d.id_equipamento = e.id_equipamento
        LEFT JOIN fornecedores f
            ON d.id_fornecedor = f.id_fornecedor
        WHERE d.id_documento = :id_documento
    ");

    $comando->execute([
        ':id_documento' => $idDocumento
    ]);

    $documento = $comando->fetch(PDO::FETCH_OBJ);

    if (!$documento) {
        header('Location: listar.php');
        exit;
    }

} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar os detalhes do documento.";
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
                                    Detalhes da documentação
                                </strong>

                                <?php if ($documento->documento_ativo == 1): ?>
                                    <span class="badge bg-success">Ativa</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativa</span>
                                <?php endif; ?>
                            </h2>
                           
                            <h5 class="detail-section-title">Informações</h5>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="detail-label">Código</label>
                                    <p class="detail-box"><?= htmlspecialchars($documento->codigo_documento ?? '') ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Tipo de documento</label>
                                    <p class="detail-box"><?= htmlspecialchars($documento->tipo_documento ?? '') ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Nome/Localização do documento</label>
                                    <p class="detail-box"><?= htmlspecialchars($documento->nome_localizacao_documento ?? '') ?></p>
                                </div>
                                <div class="col-md-6">
                                <label class="detail-label">Ficheiro carregado</label>
                                <p class="detail-box">
                                    <?php if (!empty($documento->ficheiro)): ?>
                                        <a href="../../uploads/documentos/<?= htmlspecialchars($documento->ficheiro) ?>" 
                                        target="_blank" 
                                        class="text-decoration-none">
                                            <i class="fa-solid fa-file-pdf me-1"></i>
                                            <?= htmlspecialchars($documento->ficheiro) ?>
                                        </a>
                                    <?php else: ?>
                                        Sem ficheiro associado
                                    <?php endif; ?>
                                </p>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Data de emissão</label>
                                    <p class="detail-box"><?= !empty($documento->data_emissao) ? date('d/m/Y', strtotime($documento->data_emissao)) : '' ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Data de validade</label>
                                    <p class="detail-box"><?= !empty($documento->data_validade) ? date('d/m/Y', strtotime($documento->data_validade)) : 'Sem validade definida' ?></p>
                                </div>
                            </div>

                            <h5 class="detail-section-title">Associações</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Equipamento associado</label>
                                    <p class="detail-box"><?= htmlspecialchars($documento->equipamento ?? '') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Fornecedor associado</label>
                                    <p class="detail-box"><?= htmlspecialchars($documento->fornecedor ?? 'Sem fornecedor associado') ?></p>
                                </div>
                            </div>
                            
                            <h5 class="detail-section-title">Outros</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="detail-label">Observações</label>
                                    <p class="detail-box"><?= htmlspecialchars($documento->observacoes ?? '') ?></p>
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