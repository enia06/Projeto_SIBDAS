<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idEquipamentoEncrypted = $_GET['id_equipamento'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncrypted);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
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
        UPDATE equipamentos
        SET equipamento_ativo = 0
        WHERE id_equipamento = :id_equipamento
    ");

    $comando->execute([
        ':id_equipamento' => $idEquipamento
    ]);

    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    echo "<p class='text-danger'>Erro ao remover o equipamento.</p>";
    exit;
}

$ligacao = null;
?>