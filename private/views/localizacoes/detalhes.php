<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

$idLocalizacaoEncrypted = $_GET['id_localizacao'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncrypted);

if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
    header('Location: listar.php');
    exit;
}

$erro_sistema = "";
$localizacao = null;

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
        SELECT *
        FROM localizacoes
        WHERE id_localizacao = :id_localizacao
    ");

    $comando->execute([
        ':id_localizacao' => $idLocalizacao
    ]);

    $localizacao = $comando->fetch(PDO::FETCH_OBJ);

    if (!$localizacao) {
        header('Location: listar.php');
        exit;
    }

} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar os detalhes da localização.";
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
                                    Detalhes da localização
                                </strong>

                                <?php if ($localizacao->localizacao_ativa == 1): ?>
                                    <span class="badge bg-success">Ativa</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativa</span>
                                <?php endif; ?>
                            </h2>
                           
                            <h5 class="detail-section-title">Localização geral</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="detail-label">Código</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->codigo ?? '') ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Edifício</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->edificio ?? '') ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Piso</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->piso ?? '') ?></p>
                                </div>
                            </div>

                            <h5 class="detail-section-title">Serviço</h5>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label class="detail-label">Serviço/Departamento</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->servico_departamento ?? '') ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="detail-label">Acesso</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->acesso ?? '') ?></p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="detail-label">Sala/Gabinete</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->sala_gabinete ?? '') ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="detail-label">Responsável</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->responsavel ?? '') ?></p>
                                </div>
                            </div>
                            
                            <h5 class="detail-section-title">Outros</h5>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="detail-label">Observações</label>
                                    <p class="detail-box"><?= htmlspecialchars($localizacao->observacoes ?? '') ?></p>
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