<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

$idGarantiaEncrypted = $_GET['id_garantia'] ?? null;
$idGarantia = aes_decrypt($idGarantiaEncrypted);

if (!$idGarantia || !is_numeric($idGarantia)) {
    header('Location: listar.php');
    exit;
}

$garantia = null;

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
            g.codigo_garantia,
            g.data_fim,
            e.nome AS equipamento
        FROM garantias_contratos g
        LEFT JOIN equipamentos e
            ON g.id_equipamento = e.id_equipamento
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

} catch (PDOException $err) {
    echo "<p class='text-danger'>Erro ao carregar a garantia/contrato.</p>";
    exit;
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
                    <p class="mb-2 fs-5">Deseja eliminar a garantia/contrato?</p>
                    <h4 class="mb-2"><strong><?= htmlspecialchars($garantia->codigo_garantia ?? '') ?></strong></h4>
                    <p class="mb-4 text-muted"><?= htmlspecialchars($garantia->equipamento ?? '') ?></p>
                    <p class="text-muted mb-4 text-decoration-underline">ATENÇÃO - A garantia/contrato ficará inativa no sistema</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href ="listar.php" class="btn admin-btn-cancel px-4"><i class="fa-solid fa-xmark me-2"></i>Cancelar</a>
                        <a href="confirmar_remover.php?id_garantia=<?= urlencode($idGarantiaEncrypted) ?>" class="btn admin-btn-save px-4"></i>Confirmar</a>
                    </div>
                </div>
            </main>
        </div>
    </div>                         

<?php include '../../includes/footer.php'; ?>