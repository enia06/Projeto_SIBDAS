<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
redirect_if_not_allowed(['administrador', 'tecnico']);

$idDocumentoEncrypted = $_GET['id_documento'] ?? null;
$idDocumento = aes_decrypt($idDocumentoEncrypted);

if (!$idDocumento || !is_numeric($idDocumento)) {
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
        UPDATE documentos
        SET documento_ativo = 0
        WHERE id_documento = :id_documento
    ");

    $comando->execute([
        ':id_documento' => $idDocumento
    ]);

    $_SESSION['mensagem_sucesso'] = "Documento removido com sucesso.";
    header('Location: listar.php');
    exit;

} catch (PDOException $err) {
    echo "<p class='text-danger'>Erro ao remover o documento.</p>";
    exit;
}

$ligacao = null;
?>
