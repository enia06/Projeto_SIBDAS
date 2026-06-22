<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
redirect_if_not_allowed(['administrador', 'tecnico']);

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

    registar_log('REMOVER_EQUIPAMENTO', 'Foi removido um equipamento.');
    $_SESSION['mensagem_sucesso'] = "Equipamento removido com sucesso.";
    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    registar_log(
        'ERRO_SISTEMA',
        'Erro PDO: ' . $err->getMessage()
    );

     $_SESSION['mensagem_erro'] = "Erro ao remover o equipamento.";
    header('Location: listar.php');
    exit;
}

$ligacao = null;
?>