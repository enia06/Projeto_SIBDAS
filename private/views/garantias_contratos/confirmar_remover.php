<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
redirect_if_not_allowed(['administrador', 'tecnico']);

$idGarantiaEncrypted = $_GET['id_garantia'] ?? null;
$idGarantia = aes_decrypt($idGarantiaEncrypted);

if (!$idGarantia || !is_numeric($idGarantia)) {
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
        UPDATE garantias_contratos
        SET garantia_ativa = 0
        WHERE id_garantia = :id_garantia
    ");

    $comando->execute([
        ':id_garantia' => $idGarantia
    ]);

    registar_log('REMOVER_GARANTIA', 'Foi removida uma garantia.');
    $_SESSION['mensagem_sucesso'] = "Garantia removida com sucesso.";
    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    registar_log(
        'ERRO_SISTEMA',
        'Erro ao remover garantia: ' . $err->getMessage()
    );

    $_SESSION['mensagem_erro'] = "Erro ao remover a garantia.";
    header('Location: listar.php');
    exit;
}

$ligacao = null;
?>