<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
redirect_if_not_allowed(['administrador', 'tecnico']);

$idEquipamentoEncrypted = $_GET['id_equipamento'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncrypted);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
    header('Location: listar.php');
    exit;
}

$erro_sistema = "";
$equipamento = null;

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
        SELECT nome, codigo_interno, numero_serie
        FROM equipamentos
        WHERE id_equipamento = :id_equipamento
    ");

    $comando->execute([
        ':id_equipamento' => $idEquipamento
    ]);

    $equipamento = $comando->fetch(PDO::FETCH_OBJ);

    if (!$equipamento) {
        header('Location: listar.php');
        exit;
    }

} catch (PDOException $err) {
    $erro_sistema = "Erro ao carregar o equipamento.";
}

$ligacao = null;
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 d-flex justify-content-center align-items-center px-4 ps-5" style="min-height:60vh;">
                    <div class="card admin-card w-100 shadow rounded text-center p-4 pt-5" style="max-width: 500px;">
                        <div class="remove-warning-icon display-4 mb-3">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <p class="mb-2 fs-5">Deseja eliminar o equipamento?</p>
                        <h4 class="mb-2"><strong><?= htmlspecialchars($equipamento->nome ?? '') ?></strong></h4>
                        <p class="mb-4 text-muted">
                            <?= htmlspecialchars($equipamento->codigo_interno ?? '') ?> |
                            <?= htmlspecialchars($equipamento->numero_serie ?? '') ?>
                        </p>
                        <p class="text-muted mb-4 text-decoration-underline">ATENÇÃO - O equipamento ficará inativo no sistema</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href ="listar.php" class="btn admin-btn-cancel px-4"><i class="fa-solid fa-xmark me-2"></i>Cancelar</a>
                            <a href="confirmar_remover.php?id_equipamento=<?= urlencode($idEquipamentoEncrypted) ?>" class="btn admin-btn-save px-4"><i class="fa-solid fa-check me-2"></i>Confirmar</a>
                        </div>
                    </div>
            </main>
        </div>
    </div>

<?php include '../../includes/footer.php'; ?>