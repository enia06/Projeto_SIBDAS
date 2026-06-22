<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
redirect_if_not_allowed(['administrador', 'tecnico']);
?>
<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<?php
$erros = [];
$erro_sistema = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codigo = $_POST['codigo'] ?? '';
    $nome_empresa = $_POST['nome_empresa'] ?? '';
    $id_tipo_fornecedor = $_POST['id_tipo_fornecedor'] ?? '';
    $morada = $_POST['morada'] ?? '';
    $codigo_postal = $_POST['codigo_postal'] ?? '';
    $nif = $_POST['nif'] ?? '';
    $contacto_empresa = $_POST['contacto_empresa'] ?? '';
    $email = $_POST['email'] ?? '';
    $website = $_POST['website'] ?? '';
    $pessoa_contacto = $_POST['pessoa_contacto'] ?? '';
    $telefone_contacto = $_POST['telefone_contacto'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    $codigo = trim($codigo);
    $nome_empresa = trim($nome_empresa);
    $morada = trim($morada);
    $codigo_postal = trim($codigo_postal);
    $nif = trim($nif);
    $contacto_empresa = trim($contacto_empresa);
    $email = trim($email);
    $website = trim($website);
    $pessoa_contacto = trim($pessoa_contacto);
    $telefone_contacto = trim($telefone_contacto);
    $observacoes = trim($observacoes);

    if (empty($codigo)) {
        $erros[] = "O código do fornecedor é obrigatório.";
    }

    if (empty($nome_empresa)) {
        $erros[] = "O nome da empresa é obrigatório.";
    } elseif (preg_match('/^\d+$/', $nome_empresa)) {
        $erros[] = "O nome da empresa não pode conter apenas números.";
    }

    if (empty($id_tipo_fornecedor)) {
        $erros[] = "O tipo de fornecedor é obrigatório.";
    }

    if (empty($morada)) {
        $erros[] = "A morada é obrigatória.";
    }

    if (empty($codigo_postal)) {
        $erros[] = "O código postal é obrigatório.";
    }

    if (empty($nif)) {
        $erros[] = "O NIF é obrigatório.";
    } elseif (!preg_match('/^\d{9}$/', $nif)) {
        $erros[] = "O NIF deve ter 9 dígitos.";
    }

    if (empty($contacto_empresa)) {
        $erros[] = "O contacto da empresa é obrigatório.";
    } elseif (!preg_match('/^\d{9}$/', preg_replace('/\D/', '', $contacto_empresa))) {
        $erros[] = "O contacto da empresa deve ter 9 dígitos.";
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
    } elseif (!preg_match('/^\d{9,12}$/', preg_replace('/\D/', '', $telefone_contacto))) {
        $erros[] = "O número telefónico da pessoa de contacto deve ter entre 9 e 12 dígitos.";
    }

    if (empty($erros)) {

        $codigo = strtoupper($codigo);
        $nome_empresa = ucwords(strtolower($nome_empresa));
        $morada = ucwords(strtolower($morada));
        $pessoa_contacto = ucwords(strtolower($pessoa_contacto));
        $email = strtolower($email);
        $website = strtolower($website);

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
                INSERT INTO fornecedores (
                    codigo, nome_empresa, morada, codigo_postal, nif,
                    contacto_empresa, email, website, pessoa_contacto,
                    telefone_contacto, observacoes, id_tipo_fornecedor
                ) VALUES (
                    :codigo, :nome_empresa, :morada, :codigo_postal, :nif,
                    :contacto_empresa, :email, :website, :pessoa_contacto,
                    :telefone_contacto, :observacoes, :id_tipo_fornecedor
                )
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
                ':id_tipo_fornecedor' => $id_tipo_fornecedor
            ]);

            registar_log('INSERIR_FORNECEDOR', 'Foi inserido um novo fornecedor.');
            $_SESSION['mensagem_sucesso'] = "Fornecedor inserido com sucesso.";
            header('Location: listar.php');
            exit;

        } catch (PDOException $err) {
            registar_log(
                'ERRO_SISTEMA',
                'Erro ao inserir fornecedor: ' . $err->getMessage()
            );
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }

        $ligacao = null;
    }
}
?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-0 pb-4 px-4">
                <div class="d-flex justify-content-center mt-1">
                    <div class="card admin-card w-100 shadow rounded" style="max-width: 950px;">
                         <div class="card-body">
                            <h2 class="mb-4"><strong><i class="fa-solid fa-square-plus me-2"></i> Inserir novo fornecedor</strong></h2>
                            <form action="#" method="post" novalidate>

                                <!-- Código,Designação e Tipo de fornecedor -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="texto_codigo" class="form-label">Código<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo" name="codigo" placeholder="Ex: FOR.001" value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_nome" class="form-label">Nome da empresa<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_nome" name="nome_empresa" placeholder="Ex: Dräger" value="<?= htmlspecialchars($_POST['nome_empresa'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_tipo_fornecedor" class="form-label">Tipo de fornecedor<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_tipo_fornecedor" name="id_tipo_fornecedor" required>
                                            <option value="">Escolha uma opção</option>
                                            <option value="1" <?= (($_POST['id_tipo_fornecedor'] ?? '') == '1') ? 'selected' : '' ?>>Fabricante</option>
                                            <option value="2" <?= (($_POST['id_tipo_fornecedor'] ?? '') == '2') ? 'selected' : '' ?>>Distribuidor/fornecedor comercial</option>
                                            <option value="3" <?= (($_POST['id_tipo_fornecedor'] ?? '') == '3') ? 'selected' : '' ?>>Empresa de assistência técnica</option>
                                            <option value="4" <?= (($_POST['id_tipo_fornecedor'] ?? '') == '4') ? 'selected' : '' ?>>Fornecedor de consumíveis/acessórios</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Morada e Código postal -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="texto_morada" class="form-label">Morada<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_morada" name="morada" placeholder="Ex: Rua Engenheiro Frederico Ulrich TecMaia, nº21, Moreira" value="<?= htmlspecialchars($_POST['morada'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_codigo_postal" class="form-label">Código postal<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo_postal" name="codigo_postal" placeholder="Ex: 4470-605" value="<?= htmlspecialchars($_POST['codigo_postal'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <!-- NIF e Contacto da empresa -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_NIF" class="form-label">NIF<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_NIF" name="nif" placeholder="Ex: 500123456" value="<?= htmlspecialchars($_POST['nif'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_contacto_telefonico" class="form-label">Contacto da empresa<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="texto_contacto_telefonico" name="contacto_empresa" placeholder="Ex: 211 554 587" value="<?= htmlspecialchars($_POST['contacto_empresa'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <!-- Email e Website -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_email" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="texto_email" name="email" placeholder="Ex: geral@drager.pt" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_website" class="form-label">Website<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_website" name="website" placeholder="Ex: https://www.drager.com/pt-br_br/Home" value="<?= htmlspecialchars($_POST['website'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <!-- Pessoa de contacto e Número telefónico -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_pessoa_contacto" class="form-label">Pessoa de contacto<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_pessoa_contacto" name="pessoa_contacto" placeholder="Ex: Rafael Alves" value="<?= htmlspecialchars($_POST['pessoa_contacto'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_numero_telefonico" class="form-label">Número telefónico (pessoa de contacto)<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="texto_numero_telefonico" name="telefone_contacto" placeholder="Ex: +351 999 999 999" value="<?= htmlspecialchars($_POST['telefone_contacto'] ?? '') ?>" required>
                                    </div>
                                </div>

                                <!-- Observações -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="texto_observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="texto_observacoes" name="observacoes" placeholder="Ex: Fornecedor especializado em equipamentos de ventilação, anestesia e monitorização hospitalar." rows="4"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
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