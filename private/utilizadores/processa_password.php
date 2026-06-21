<?php
require_once __DIR__ . '/../includes/funcoes.php';
redirect_if_not_logged();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: alterar_password.php');
    exit;
}

$password_atual = trim($_POST['password_atual'] ?? '');
$nova_password = trim($_POST['nova_password'] ?? '');
$confirmar_password = trim($_POST['confirmar_password'] ?? '');

if ($nova_password != $confirmar_password) {
    $_SESSION['server_error'] = 'As novas palavras-passe não coincidem.';
    header('Location: alterar_password.php');
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
        SELECT *
        FROM utilizadores
        WHERE id_utilizador = :id
        LIMIT 1
    ");

    $comando->execute([
        ':id' => $_SESSION['id_utilizador']
    ]);

    $utilizador = $comando->fetch(PDO::FETCH_OBJ);

    if (!$utilizador) {
        $_SESSION['server_error'] = 'Utilizador não encontrado.';
        header('Location: alterar_password.php');
        exit;
    }

    if (strlen($nova_password) < 8) {
        $_SESSION['server_error'] = 'A nova palavra-passe deve ter pelo menos 8 caracteres.';
        header('Location: alterar_password.php');
        exit;
}

    if (!password_verify($password_atual, $utilizador->password_hash)) {
        $_SESSION['server_error'] = 'A palavra-passe atual está incorreta.';
        header('Location: alterar_password.php');
        exit;
    }

    $nova_hash = password_hash($nova_password, PASSWORD_DEFAULT);

    $comando = $ligacao->prepare("
        UPDATE utilizadores
        SET password_hash = :password
        WHERE id_utilizador = :id
    ");

    $comando->execute([
        ':password' => $nova_hash,
        ':id' => $_SESSION['id_utilizador']
    ]);

    $_SESSION['success_message'] = 'Palavra-passe alterada com sucesso.';

} catch (PDOException $err) {

    $_SESSION['server_error'] = 'Erro ao alterar a palavra-passe.';
}

header('Location: alterar_password.php');
exit;