<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idLocalizacaoEncrypted = $_GET['id_localizacao'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncrypted);

if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
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
        UPDATE localizacoes
        SET localizacao_ativa = 0
        WHERE id_localizacao = :id_localizacao
    ");

    $comando->execute([
        ':id_localizacao' => $idLocalizacao
    ]);

    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    echo "<p class='text-danger'>Erro ao remover a localização.</p>";
    exit;
}

$ligacao = null;
?>