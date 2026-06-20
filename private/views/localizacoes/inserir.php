<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

<?php
$erros = [];
$erro_sistema = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codigo = $_POST['codigo'] ?? '';
    $edificio = $_POST['edificio'] ?? '';
    $piso = $_POST['piso'] ?? '';
    $servico_departamento = $_POST['servico_departamento'] ?? '';
    $acesso = $_POST['acesso'] ?? '';
    $sala_gabinete = $_POST['sala_gabinete'] ?? '';
    $responsavel = $_POST['responsavel'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    $codigo = trim($codigo);
    $edificio = trim($edificio);
    $piso = trim($piso);
    $servico_departamento = trim($servico_departamento);
    $acesso = trim($acesso);
    $sala_gabinete = trim($sala_gabinete);
    $responsavel = trim($responsavel);
    $observacoes = trim($observacoes);

    if (empty($codigo)) {
        $erros[] = "O código da localização é obrigatório.";
    }

    if (empty($edificio)) {
        $erros[] = "O edifício é obrigatório.";
    }

    if (empty($piso)) {
        $erros[] = "O piso é obrigatório.";
    }

    if (empty($servico_departamento)) {
        $erros[] = "O serviço/departamento é obrigatório.";
    }

    if (empty($acesso)) {
        $erros[] = "O tipo de acesso é obrigatório.";
    }

    if (empty($sala_gabinete)) {
        $erros[] = "A sala/gabinete é obrigatória.";
    }

    if (empty($responsavel)) {
        $erros[] = "O responsável é obrigatório.";
    } elseif (preg_match('/^\d+$/', $responsavel)) {
        $erros[] = "O responsável não pode conter apenas números.";
    }

    if (empty($erros)) {

        $codigo = strtoupper($codigo);
        $sala_gabinete = ucwords(strtolower($sala_gabinete));
        $responsavel = ucwords(strtolower($responsavel));

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
                INSERT INTO localizacoes (
                    codigo, edificio, piso, servico_departamento,
                    acesso, sala_gabinete, responsavel, observacoes
                ) VALUES (
                    :codigo, :edificio, :piso, :servico_departamento,
                    :acesso, :sala_gabinete, :responsavel, :observacoes
                )
            ");

            $comando->execute([
                ':codigo' => $codigo,
                ':edificio' => $edificio,
                ':piso' => $piso,
                ':servico_departamento' => $servico_departamento,
                ':acesso' => $acesso,
                ':sala_gabinete' => $sala_gabinete,
                ':responsavel' => $responsavel,
                ':observacoes' => $observacoes
            ]);

            header('Location: listar.php');
            exit;

        } catch (PDOException $err) {
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
                            <h2 class="mb-4"><strong><i class="fa-solid fa-square-plus me-2"></i> Inserir nova localização</strong></h2>
                            <form action="#" method="post" novalidate>
                                
                                <!-- Código, Edifício e Piso -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="texto_codigo" class="form-label">Código<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo" name="codigo" placeholder="Ex: LOC.001" value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_edificio" class="form-label">Edifício<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_edificio" name="edificio" required>
                                            <option value="">Escolha uma opção</option>
                                            <option value="Bloco A" <?= (($_POST['edificio'] ?? '') == 'Bloco A') ? 'selected' : '' ?>>Bloco A</option>
                                            <option value="Bloco B" <?= (($_POST['edificio'] ?? '') == 'Bloco B') ? 'selected' : '' ?>>Bloco B</option>
                                            <option value="Bloco C" <?= (($_POST['edificio'] ?? '') == 'Bloco C') ? 'selected' : '' ?>>Bloco C</option>
                                            <option value="Bloco D" <?= (($_POST['edificio'] ?? '') == 'Bloco D') ? 'selected' : '' ?>>Bloco D</option>
                                            <option value="Bloco E" <?= (($_POST['edificio'] ?? '') == 'Bloco E') ? 'selected' : '' ?>>Bloco E</option>
                                            <option value="Bloco F" <?= (($_POST['edificio'] ?? '') == 'Bloco F') ? 'selected' : '' ?>>Bloco F</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_piso" class="form-label">Piso<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_piso" name="piso" required>
                                            <option value="">Escolha uma opção</option>
                                            <option value="Piso 0" <?= (($_POST['piso'] ?? '') == 'Piso 0') ? 'selected' : '' ?>>Piso 0</option>
                                            <option value="Piso 1" <?= (($_POST['piso'] ?? '') == 'Piso 1') ? 'selected' : '' ?>>Piso 1</option>
                                            <option value="Piso 2" <?= (($_POST['piso'] ?? '') == 'Piso 2') ? 'selected' : '' ?>>Piso 2</option>
                                            <option value="Piso 3" <?= (($_POST['piso'] ?? '') == 'Piso 3') ? 'selected' : '' ?>>Piso 3</option>
                                            <option value="Piso 4" <?= (($_POST['piso'] ?? '') == 'Piso 4') ? 'selected' : '' ?>>Piso 4</option>
                                            <option value="Piso 5" <?= (($_POST['piso'] ?? '') == 'Piso 5') ? 'selected' : '' ?>>Piso 5</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Serviço/Departamento e Acesso -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_servico" class="form-label">Serviço/Departamento<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_servico" name="servico_departamento" required>
                                            <option value="">Escolha uma opção</option>
                                            <option value="Urgências" <?= (($_POST['servico_departamento'] ?? '') == 'Urgências') ? 'selected' : '' ?>>Urgências</option>
                                            <option value="Unidade de Cuidados Intensivos" <?= (($_POST['servico_departamento'] ?? '') == 'Unidade de Cuidados Intensivos') ? 'selected' : '' ?>>Unidade de Cuidados Intensivos</option>
                                            <option value="Pediatria" <?= (($_POST['servico_departamento'] ?? '') == 'Pediatria') ? 'selected' : '' ?>>Pediatria</option>
                                            <option value="Cardiologia" <?= (($_POST['servico_departamento'] ?? '') == 'Cardiologia') ? 'selected' : '' ?>>Cardiologia</option>
                                            <option value="Neurologia" <?= (($_POST['servico_departamento'] ?? '') == 'Neurologia') ? 'selected' : '' ?>>Neurologia</option>
                                            <option value="Ortopedia" <?= (($_POST['servico_departamento'] ?? '') == 'Ortopedia') ? 'selected' : '' ?>>Ortopedia</option>
                                            <option value="Radiologia" <?= (($_POST['servico_departamento'] ?? '') == 'Radiologia') ? 'selected' : '' ?>>Radiologia</option>
                                            <option value="Imagiologia" <?= (($_POST['servico_departamento'] ?? '') == 'Imagiologia') ? 'selected' : '' ?>>Imagiologia</option>
                                            <option value="Laboratório de Análises Clínicas" <?= (($_POST['servico_departamento'] ?? '') == 'Laboratório de Análises Clínicas') ? 'selected' : '' ?>>Laboratório de Análises Clínicas</option>
                                            <option value="Farmácia Hospitalar" <?= (($_POST['servico_departamento'] ?? '') == 'Farmácia Hospitalar') ? 'selected' : '' ?>>Farmácia Hospitalar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_acesso" class="form-label">Acesso<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_acesso" name="acesso" required>
                                            <option value="">Escolha uma opção</option>
                                            <option value="Acesso livre" <?= (($_POST['acesso'] ?? '') == 'Acesso livre') ? 'selected' : '' ?>>Acesso livre</option>
                                            <option value="Acesso autorizado" <?= (($_POST['acesso'] ?? '') == 'Acesso autorizado') ? 'selected' : '' ?>>Acesso autorizado</option>
                                            <option value="Acesso restrito" <?= (($_POST['acesso'] ?? '') == 'Acesso restrito') ? 'selected' : '' ?>>Acesso restrito</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Sala/Gabinete e Responsável -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_sala_gabinete" class="form-label">Sala/Gabinete<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_sala_gabinete" name="sala_gabinete" placeholder="Ex: Gabinete 03" value="<?= htmlspecialchars($_POST['sala_gabinete'] ?? '') ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_responsavel" class="form-label">Responsável<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_responsavel" name="responsavel" placeholder="Ex: Dra. Raquel Vieira" value="<?= htmlspecialchars($_POST['responsavel'] ?? '') ?>" required>
                                    </div>
                        
                                </div>

                                <!-- Observações -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="texto_observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="texto_observacoes" name="observacoes" placeholder="Ex: Localização sujeita a controlo de acesso por cartão." rows="4"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
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
