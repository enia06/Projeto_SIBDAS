<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
require_once __DIR__ . '/../../includes/validacoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/private/login/login.php');
    exit;
}

$idFornecedorEncrypted = $_GET['id_fornecedor'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncrypted);

if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: listar.php');
    exit;
}

$erros = [];
$erro_sistema = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codigo = trim($_POST['codigo'] ?? '');
    $nome_empresa = trim($_POST['nome_empresa'] ?? '');
    $tipo_fornecedor = $_POST['tipo_fornecedor'] ?? '';
    $morada = trim($_POST['morada'] ?? '');
    $codigo_postal = trim($_POST['codigo_postal'] ?? '');
    $nif = trim($_POST['nif'] ?? '');
    $contacto_empresa = trim($_POST['contacto_empresa'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $pessoa_contacto = trim($_POST['pessoa_contacto'] ?? '');
    $telefone_contacto = trim($_POST['telefone_contacto'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');

    if (empty($codigo)) $erros[] = "O código é obrigatório.";
if (empty($nome_empresa)) $erros[] = "O nome da empresa é obrigatório.";
if (empty($tipo_fornecedor)) $erros[] = "O tipo de fornecedor é obrigatório.";
if (empty($morada)) $erros[] = "A morada é obrigatória.";
if (empty($codigo_postal)) $erros[] = "O código postal é obrigatório.";

if (empty($nif)) {
    $erros[] = "O NIF é obrigatório.";
} elseif (!preg_match('/^\d{9}$/', $nif)) {
    $erros[] = "O NIF deve ter 9 dígitos.";
}

if (empty($contacto_empresa)) {
    $erros[] = "O contacto da empresa é obrigatório.";
} elseif (strlen(preg_replace('/\D/', '', $contacto_empresa)) < 9) {
    $erros[] = "O contacto da empresa deve ter pelo menos 9 dígitos.";
}

if (empty($email)) {
    $erros[] = "O email é obrigatório.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "O email não é válido.";
}

if (empty($website)) {
    $erros[] = "O website é obrigatório.";
} elseif (!filter_var($website, FILTER_VALIDATE_URL)) {
    $erros[] = "O website não é válido.";
}

if (empty($pessoa_contacto)) {
    $erros[] = "A pessoa de contacto é obrigatória.";
} elseif (preg_match('/^\d+$/', $pessoa_contacto)) {
    $erros[] = "A pessoa de contacto não pode conter apenas números.";
}

if (empty($telefone_contacto)) {
    $erros[] = "O número telefónico da pessoa de contacto é obrigatório.";
} elseif (strlen(preg_replace('/\D/', '', $telefone_contacto)) < 9) {
    $erros[] = "O número telefónico da pessoa de contacto deve ter pelo menos 9 dígitos.";
}

if (empty($erros)) {
    $codigo = strtoupper($codigo);
    $nome_empresa = ucwords(strtolower($nome_empresa));
    $pessoa_contacto = ucwords(strtolower($pessoa_contacto));

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
            UPDATE fornecedores SET
                codigo = :codigo,
                nome_empresa = :nome_empresa,
                morada = :morada,
                codigo_postal = :codigo_postal,
                nif = :nif,
                contacto_empresa = :contacto_empresa,
                email = :email,
                website = :website,
                pessoa_contacto = :pessoa_contacto,
                telefone_contacto = :telefone_contacto,
                observacoes = :observacoes,
                id_tipo_fornecedor = :id_tipo_fornecedor
            WHERE id_fornecedor = :id_fornecedor
        ");

        $comando->execute([
            ':codigo' => $codigo,
            ':nome_empresa' => $nome_empresa,
            ':morada' => $morada,
            ':codigo_postal' => $codigo_postal,
            ':nif' => $nif,
            ':contacto_empresa' => $contacto_empresa,
            ':email' => $email,
            ':website' => $website,
            ':pessoa_contacto' => $pessoa_contacto,
            ':telefone_contacto' => $telefone_contacto,
            ':observacoes' => $observacoes,
            ':id_tipo_fornecedor' => $tipo_fornecedor,
            ':id_fornecedor' => $idFornecedor
        ]);

        header('Location: listar.php');
        exit;

    } catch (PDOException $err) {
        $erro_sistema = "Erro ao atualizar os dados: " . $err->getMessage();
    }

    $ligacao = null;
    }
}

$fornecedor = null;

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
        FROM fornecedores
        WHERE id_fornecedor = :id_fornecedor
    ");

    $comando->execute([
        ':id_fornecedor' => $idFornecedor
    ]);

    $fornecedor = $comando->fetch(PDO::FETCH_OBJ);

    if (!$fornecedor) {
        header('Location: listar.php');
        exit;
    }

} catch (PDOException $err) {
    $erro_sistema = "Erro na ligação à base de dados.";
}

$ligacao = null;

?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-0 pb-4 px-4">
                <div class="d-flex justify-content-center mt-1">
                    <div class="card admin-card w-100 shadow rounded" style="max-width: 950px;">
                         <div class="card-body">
                            <h2 class="mb-4"><strong><i class="fa-solid fa-pen-to-square me-2"></i> Editar fornecedor</strong></h2>
                            <form action="editar.php?id_fornecedor=<?= htmlspecialchars($idFornecedorEncrypted) ?>" method="post" novalidate>
                                
                                <!-- Código, Designação e Tipo de fornecedor -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="texto_codigo" class="form-label">Código<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo" name="codigo" value="<?= htmlspecialchars($fornecedor->codigo) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_nome" class="form-label">Nome da empresa<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_nome" name="nome_empresa" value="<?= htmlspecialchars($fornecedor->nome_empresa) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_tipo_fornecedor" class="form-label">Tipo de fornecedor<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_tipo_fornecedor" name="tipo_fornecedor" required>
                                            <option value="">Escolha uma opção</option>
                                            <option value="1" <?= ($fornecedor->id_tipo_fornecedor == 1) ? 'selected' : '' ?>> Fabricante </option>
                                            <option value="2" <?= ($fornecedor->id_tipo_fornecedor == 2) ? 'selected' : '' ?>> Distribuidor/fornecedor comercial </option>
                                            <option value="3" <?= ($fornecedor->id_tipo_fornecedor == 3) ? 'selected' : '' ?>> Empresa de assistência técnica </option>
                                            <option value="4" <?= ($fornecedor->id_tipo_fornecedor == 4) ? 'selected' : '' ?>> Fornecedor de consumíveis/acessórios </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Morada e Código postal -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="texto_morada" class="form-label">Morada<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_morada" name="morada" value="<?= htmlspecialchars($fornecedor->morada) ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_codigo_postal" class="form-label">Código postal<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo_postal" name="codigo_postal" value="<?= htmlspecialchars($fornecedor->codigo_postal) ?>" required>
                                    </div>
                                </div>

                                <!-- NIF e Contacto da empresa -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_NIF" class="form-label">NIF<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_NIF" name="nif" value="<?= htmlspecialchars($fornecedor->nif) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_contacto_telefonico" class="form-label">Contacto da empresa<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="texto_contacto_telefonico" name="contacto_empresa" value="<?= htmlspecialchars($fornecedor->contacto_empresa) ?>" required>
                                    </div>
                                </div>

                                <!-- Email e Website -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_email" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_email" name="email" value="<?= htmlspecialchars($fornecedor->email) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_website" class="form-label">Website<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_website" name="website" value="<?= htmlspecialchars($fornecedor->website) ?>" required>
                                    </div>
                                </div>

                                <!-- Pessoa de contacto e Número telefónico -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_pessoa_contacto" class="form-label">Pessoa de contacto<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_pessoa_contacto" name="pessoa_contacto" value="<?= htmlspecialchars($fornecedor->pessoa_contacto) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_telefone_contacto" class="form-label">Número telefónico (pessoa de contacto)<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="texto_numero_telefonico" name="telefone_contacto" value="<?= htmlspecialchars($fornecedor->telefone_contacto) ?>" required>
                                    </div>
                                </div>

                                <!-- Observações -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="texto_observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="texto_observacoes" name="observacoes" rows="4"><?= htmlspecialchars($fornecedor->observacoes) ?></textarea>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="d-flex justify-content-center gap-3 mb-4">
                                    <a href="listar.php" class="btn admin-btn-cancel">
                                        <i class="fa-solid fa-xmark me-1"></i>Cancelar
                                    </a>
                                    <button type="submit" class="btn admin-btn-save">
                                        <i class="fa-regular fa-floppy-disk me-1"></i>Guardar
                                    </button>
                                </div>

                                <!-- Erros -->
                                <?php if (!empty($erros)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <strong>Foram encontrados os seguintes erros:</strong>
                                        <ul class="mb-0 mt-2">
                                            <?php foreach ($erros as $erro): ?>
                                                <li><?= htmlspecialchars($erro) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($erro_sistema)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <p class="mb-0"><?= htmlspecialchars($erro_sistema) ?></p>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
         </div>  
    </div>                         

<?php include '../../includes/footer.php'; ?>