<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
redirect_if_not_allowed(['administrador', 'tecnico']);

$idFornecedorEncrypted = $_GET['id_fornecedor'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncrypted);

if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: listar.php');
    exit;
}

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
        UPDATE fornecedores
        SET fornecedor_ativo = 0
        WHERE id_fornecedor = :id_fornecedor
    ");

    $comando->execute([
        ':id_fornecedor' => $idFornecedor
    ]);

    $_SESSION['mensagem_sucesso'] = "Fornecedor removido com sucesso.";
    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    echo "<p class='text-danger'>Erro ao remover o fornecedor.</p>";
    exit;
}

$ligacao = null;
?>
