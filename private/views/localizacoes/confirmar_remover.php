<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
redirect_if_not_allowed(['administrador', 'tecnico']);

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

    registar_log('REMOVER_LOCALIZACAO', 'Foi removida uma localização.');
    $_SESSION['mensagem_sucesso'] = "Localização removida com sucesso.";
    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    registar_log(
        'ERRO_SISTEMA',
        'Erro ao remover localização: ' . $err->getMessage()
    );
    
    $_SESSION['mensagem_erro'] = "Erro ao remover a localização.";
    header('Location: listar.php');
    exit;
}

$ligacao = null;
?>