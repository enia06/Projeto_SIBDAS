<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
require_once __DIR__ . '/../../includes/validacoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
redirect_if_not_allowed(['administrador', 'tecnico']);
?>

<?php
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/private/login/login.php');
    exit;
}

// Recolhe e desencripta o ID do equipamento da URL
$idEquipamentoEncrypted = $_GET['id_equipamento'] ?? null;
$idEquipamento = aes_decrypt($idEquipamentoEncrypted);

if (!$idEquipamento || !is_numeric($idEquipamento)) {
    header('Location: ' . BASE_URL . '/private/views/equipamentos/listar.php');
    exit;
}

$erros = [];
$erro_sistema = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $codigo_interno = trim($_POST['codigo_interno'] ?? '');
    $numero_serie = trim($_POST['numero_serie'] ?? '');
    $categoria = $_POST['categoria'] ?? '';
    $tipo_entrada = $_POST['tipo_entrada'] ?? '';
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');
    $ano_fabrico = $_POST['ano_fabrico'] ?? '';
    $data_aquisicao = $_POST['data_aquisicao'] ?? '';
    $custo_aquisicao = trim($_POST['custo_aquisicao'] ?? '');
    $estado_atual = $_POST['estado_atual'] ?? '';
    $criticidade = $_POST['criticidade'] ?? '';
    $observacoes_equipamento = trim($_POST['observacoes_equipamento'] ?? '');

    // Fornecedor
    $id_fornecedor = $_POST['id_fornecedor'] ?? '';

    // Localização
    $id_localizacao = $_POST['id_localizacao'] ?? '';

    // Documentação
    $codigo_documento = trim($_POST['codigo_documento'] ?? '');
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $nome_localizacao_documento = trim($_POST['nome_localizacao_documento'] ?? '');
    $data_emissao = $_POST['data_emissao'] ?? '';
    $data_validade = $_POST['data_validade'] ?? '';
    $id_fornecedor_documento = $_POST['id_fornecedor_documento'] ?? '';
    $observacoes_documento = trim($_POST['observacoes_documento'] ?? '');

    // Garantia
    $codigo_garantia = trim($_POST['codigo_garantia'] ?? '');
    $data_inicio = $_POST['data_inicio'] ?? '';
    $data_fim = $_POST['data_fim'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $existencia_contrato = $_POST['existencia_contrato'] ?? '';
    $tipo_contrato = $_POST['tipo_contrato'] ?? '';
    $entidade_responsavel = trim($_POST['entidade_responsavel'] ?? '');
    $periodicidade = $_POST['periodicidade'] ?? '';
    $observacoes_garantia = trim($_POST['observacoes_garantia'] ?? '');

    $erros = array_merge($erros, validar_nome_equipamento($nome));
    if (empty($codigo_interno)) $erros[] = "O código interno é obrigatório.";
    if (empty($numero_serie)) $erros[] = "O número de série é obrigatório.";
    if (empty($categoria)) $erros[] = "A categoria é obrigatória.";
    if (empty($tipo_entrada)) $erros[] = "O tipo de entrada é obrigatório.";
    if (empty($marca)) $erros[] = "A marca é obrigatória.";
    if (empty($modelo)) $erros[] = "O modelo é obrigatório.";

    if (empty($fabricante)) {
        $erros[] = "O fabricante é obrigatório.";
    } elseif (preg_match('/^\d+$/', $fabricante)) {
        $erros[] = "O fabricante não pode conter apenas números.";
    }

    if (empty($ano_fabrico)) {
        $erros[] = "O ano de fabrico é obrigatório.";
    } elseif (!preg_match('/^\d{4}$/', $ano_fabrico)) {
        $erros[] = "O ano de fabrico deve ter 4 dígitos.";
    } elseif ($ano_fabrico < 1980 || $ano_fabrico > 2026) {
        $erros[] = "O ano de fabrico deve estar entre 1980 e 2026.";
    }

    if (empty($data_aquisicao)) $erros[] = "A data de aquisição é obrigatória.";

    if (empty($custo_aquisicao)) {
        $erros[] = "O custo de aquisição é obrigatório.";
    } elseif (!is_numeric(str_replace(',', '.', $custo_aquisicao))) {
        $erros[] = "O custo de aquisição deve ser numérico.";
    }

    if (empty($estado_atual)) $erros[] = "O estado atual é obrigatório.";
    if (empty($criticidade)) $erros[] = "A criticidade é obrigatória.";

    if (empty($id_fornecedor)) {
    $erros[] = "É obrigatório associar um fornecedor.";
    }

    if (empty($id_localizacao)) {
        $erros[] = "É obrigatório associar uma localização.";
    }

    if (empty($codigo_documento)) {
        $erros[] = "O código do documento é obrigatório.";
    }

    if (empty($tipo_documento)) {
        $erros[] = "O tipo de documento é obrigatório.";
    }

    if (empty($nome_localizacao_documento)) {
        $erros[] = "O nome/localização do documento é obrigatório.";
    }

    if (empty($data_emissao)) {
        $erros[] = "A data de emissão do documento é obrigatória.";
    }

    if (!empty($data_validade) && !empty($data_emissao) && $data_validade < $data_emissao) {
        $erros[] = "A data de validade não pode ser anterior à data de emissão.";
    }

    if (empty($codigo_garantia)) {
        $erros[] = "O código da garantia é obrigatório.";
    }

    if (empty($data_inicio)) {
        $erros[] = "A data de início da garantia é obrigatória.";
    }

    if (empty($data_fim)) {
        $erros[] = "A data de fim da garantia é obrigatória.";
    }

    if (!empty($data_inicio) && !empty($data_fim) && $data_fim < $data_inicio) {
        $erros[] = "A data de fim da garantia não pode ser anterior à data de início.";
    }

    if (empty($estado)) {
        $erros[] = "O estado da garantia é obrigatório.";
    }

    if (empty($existencia_contrato)) {
        $erros[] = "É obrigatório indicar se existe contrato de manutenção.";
    }

    if ($existencia_contrato == 'sim') {
        if (empty($tipo_contrato)) {
            $erros[] = "O tipo de contrato é obrigatório quando existe contrato de manutenção.";
        }

        if (empty($entidade_responsavel)) {
            $erros[] = "A entidade responsável é obrigatória quando existe contrato de manutenção.";
        } elseif (preg_match('/^\d+$/', $entidade_responsavel)) {
            $erros[] = "A entidade responsável não pode conter apenas números.";
        }

        if (empty($periodicidade)) {
            $erros[] = "A periodicidade é obrigatória quando existe contrato de manutenção.";
        }
    }

    if ($existencia_contrato == 'nao' && !empty($tipo_contrato)) {
        $erros[] = "Não deve ser indicado tipo de contrato quando não existe contrato de manutenção.";
    }

    if (empty($erros)) {
        $nome = ucwords(strtolower($nome));
        $codigo_interno = strtoupper($codigo_interno);
        $numero_serie = strtoupper($numero_serie);
        $marca = ucwords(strtolower($marca));
        $modelo = ucwords(strtolower($modelo));
        $fabricante = ucwords(strtolower($fabricante));
        $custo_aquisicao = str_replace(',', '.', $custo_aquisicao);
        $codigo_documento = strtoupper($codigo_documento);
        $codigo_garantia = strtoupper($codigo_garantia);
        $entidade_responsavel = ucwords(strtolower($entidade_responsavel));

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
                UPDATE equipamentos SET
                    nome = :nome,
                    codigo_interno = :codigo_interno,
                    numero_serie = :numero_serie,
                    marca = :marca,
                    modelo = :modelo,
                    fabricante = :fabricante,
                    ano_fabrico = :ano_fabrico,
                    data_aquisicao = :data_aquisicao,
                    custo_aquisicao = :custo_aquisicao,
                    observacoes = :observacoes,
                    id_categoria = :id_categoria,
                    id_tipo_entrada = :id_tipo_entrada,
                    id_estado = :id_estado,
                    id_criticidade = :id_criticidade,
                    id_localizacao = :id_localizacao
                    WHERE id_equipamento = :id_equipamento
            ");

            $comando->execute([
                ':nome' => $nome,
                ':codigo_interno' => $codigo_interno,
                ':numero_serie' => $numero_serie,
                ':marca' => $marca,
                ':modelo' => $modelo,
                ':fabricante' => $fabricante,
                ':ano_fabrico' => $ano_fabrico,
                ':data_aquisicao' => $data_aquisicao,
                ':custo_aquisicao' => $custo_aquisicao,
                ':observacoes' => $observacoes_equipamento,
                ':id_categoria' => $categoria,
                ':id_tipo_entrada' => $tipo_entrada,
                ':id_estado' => $estado_atual,
                ':id_criticidade' => $criticidade,
                ':id_localizacao' => $id_localizacao,
                ':id_equipamento' => $idEquipamento
            ]);

            // Atualizar fornecedor associado
            $comando = $ligacao->prepare("
                DELETE FROM equipamento_fornecedor
                WHERE id_equipamento = :id_equipamento
            ");

            $comando->execute([
                ':id_equipamento' => $idEquipamento
            ]);

            $comando = $ligacao->prepare("
                INSERT INTO equipamento_fornecedor
                (id_equipamento, id_fornecedor)
                VALUES
                (:id_equipamento, :id_fornecedor)
            ");

            $comando->execute([
                ':id_equipamento' => $idEquipamento,
                ':id_fornecedor' => $id_fornecedor
            ]);

            // Atualizar documentação
            $comando = $ligacao->prepare("
                UPDATE documentos SET
                    codigo_documento = :codigo_documento,
                    nome_localizacao_documento = :nome_localizacao_documento,
                    data_emissao = :data_emissao,
                    data_validade = :data_validade,
                    observacoes = :observacoes,
                    id_tipo_documento = :id_tipo_documento,
                    id_fornecedor = :id_fornecedor
                WHERE id_equipamento = :id_equipamento
            ");

            $comando->execute([
                ':codigo_documento' => $codigo_documento,
                ':nome_localizacao_documento' => $nome_localizacao_documento,
                ':data_emissao' => $data_emissao,
                ':data_validade' => !empty($data_validade) ? $data_validade : null,
                ':observacoes' => $observacoes_documento,
                ':id_tipo_documento' => $tipo_documento,
                ':id_fornecedor' => !empty($id_fornecedor_documento) ? $id_fornecedor_documento : null,
                ':id_equipamento' => $idEquipamento
            ]);

            // Atualizar garantia/contrato
            $comando = $ligacao->prepare("
                UPDATE garantias_contratos SET
                    codigo_garantia = :codigo_garantia,
                    data_inicio = :data_inicio,
                    data_fim = :data_fim,
                    existe_contrato = :existe_contrato,
                    entidade_responsavel = :entidade_responsavel,
                    observacoes = :observacoes,
                    id_estado_garantia = :id_estado_garantia,
                    id_tipo_contrato = :id_tipo_contrato,
                    id_periodicidade = :id_periodicidade
                WHERE id_equipamento = :id_equipamento
            ");

            $comando->execute([
                ':codigo_garantia' => $codigo_garantia,
                ':data_inicio' => $data_inicio,
                ':data_fim' => $data_fim,
                ':existe_contrato' => ($existencia_contrato == 'sim') ? 1 : 0,
                ':entidade_responsavel' => !empty($entidade_responsavel) ? $entidade_responsavel : null,
                ':observacoes' => $observacoes_garantia,
                ':id_estado_garantia' => $estado,
                ':id_tipo_contrato' => !empty($tipo_contrato) ? $tipo_contrato : null,
                ':id_periodicidade' => !empty($periodicidade) ? $periodicidade : null,
                ':id_equipamento' => $idEquipamento
            ]);

            header('Location: listar.php');
            exit;

        } catch (PDOException $err) {
            $erro_sistema = "Erro ao atualizar os dados: " . $err->getMessage();
        }

        $ligacao = null;
    }
}

$equipamento = null;
$fornecedores = [];
$localizacoes = [];
$fornecedor_atual = null;
$documento = null;
$garantia = null;

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
        FROM equipamentos
        WHERE id_equipamento = :id_equipamento
    ");

    $comando->execute([
        ':id_equipamento' => $idEquipamento
    ]);

    $equipamento = $comando->fetch(PDO::FETCH_OBJ);

    if (!$equipamento) {
        header('Location: ' . BASE_URL . '/private/views/equipamentos/listar.php');
        exit;
    }

    $comando = $ligacao->prepare("
        SELECT id_fornecedor
        FROM equipamento_fornecedor
        WHERE id_equipamento = :id_equipamento
        LIMIT 1
    ");

    $comando->execute([':id_equipamento' => $idEquipamento]);
    $fornecedor_atual = $comando->fetch(PDO::FETCH_OBJ);

    $comando = $ligacao->prepare("
        SELECT *
        FROM documentos
        WHERE id_equipamento = :id_equipamento
        LIMIT 1
    ");

    $comando->execute([':id_equipamento' => $idEquipamento]);
    $documento = $comando->fetch(PDO::FETCH_OBJ);

    $comando = $ligacao->prepare("
        SELECT *
        FROM garantias_contratos
        WHERE id_equipamento = :id_equipamento
        LIMIT 1
    ");

    $comando->execute([':id_equipamento' => $idEquipamento]);
    $garantia = $comando->fetch(PDO::FETCH_OBJ);

    $comando = $ligacao->prepare("
        SELECT id_fornecedor, codigo, nome_empresa
        FROM fornecedores
        ORDER BY codigo
    ");

    $comando->execute();
    $fornecedores = $comando->fetchAll(PDO::FETCH_ASSOC);

    $comando = $ligacao->prepare("
        SELECT id_localizacao, codigo, edificio, piso, servico_departamento
        FROM localizacoes
        ORDER BY codigo
    ");

    $comando->execute();
    $localizacoes = $comando->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $err) {
    $erro_sistema = "Erro na ligação à base de dados.";
}

$ligacao = null;

$abrir_garantias = !empty($erros) || !empty($erro_sistema);

include '../../includes/header.php';
include '../../includes/nav.php';

?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-0 pb-4 px-4">
                <div class="d-flex justify-content-center mt-1">
                    <div class="card admin-card w-100 shadow rounded" style="max-width: 950px;">
                         <div class="card-body">
                            <h2 class="mb-4"><strong><i class="fa-solid fa-square-plus me-2"></i> Editar equipamento</strong></h2>
                            <form action="editar.php?id_equipamento=<?= htmlspecialchars($idEquipamentoEncrypted) ?>" method="post" novalidate>
                            
                                <ul class="nav nav-tabs justify-content-center mb-4" id="equipamentoTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link <?= !$abrir_garantias ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#equipamento"><i class="fa-solid fa-laptop-medical me-1"></i>Equipamento </button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#fornecedor"><i class="fa-solid fa-truck-medical me-1"></i>Fornecedor</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#localizacao"><i class="fa-solid fa-house-medical-flag me-1"></i>Localização</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#documentacao"><i class="fa-solid fa-clipboard-user me-1"></i>Documentação</button>
                                    </li>

                                    <li class="nav-item">
                                        <button class="nav-link <?= $abrir_garantias ? 'active' : 'disabled' ?>" data-bs-toggle="tab" data-bs-target="#garantias"><i class="fa-solid fa-receipt me-1"></i>Garantias/Contratos</button>
                                    </li>
                                </ul>

                                
                                <div class="tab-content">
                                    <div class="tab-pane fade <?= !$abrir_garantias ? 'show active' : '' ?>" id="equipamento">
                                        <!-- Designação -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="texto_nome" class="form-label">Nome do equipamento<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_nome" name="nome" value="<?= htmlspecialchars($equipamento->nome) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Código interno de inventário e Número de série -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_código_interno" class="form-label">Código interno<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_codigo_interno" name="codigo_interno" value="<?= htmlspecialchars($equipamento->codigo_interno) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_numero_serie" class="form-label">Número de série<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_numero_serie" name="numero_serie" value="<?= htmlspecialchars($equipamento->numero_serie) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Categoria/Grupo e Tipo de entrada -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_categoria" class="form-label">Categoria<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_categoria" name="categoria" required>
                                                    <option value="">Escolha uma opção</option>
                                                    <option value="1" <?= ($equipamento->id_categoria == 1) ? 'selected' : '' ?>>Monitorização</option>
                                                    <option value="2" <?= ($equipamento->id_categoria == 2) ? 'selected' : '' ?>>Suporte de vida</option>
                                                    <option value="3" <?= ($equipamento->id_categoria == 3) ? 'selected' : '' ?>>Terapia</option>
                                                    <option value="4" <?= ($equipamento->id_categoria == 4) ? 'selected' : '' ?>>Diagnóstico</option>
                                                    <option value="5" <?= ($equipamento->id_categoria == 5) ? 'selected' : '' ?>>Laboratório</option>
                                                    <option value="6" <?= ($equipamento->id_categoria == 6) ? 'selected' : '' ?>>Esterilização</option>
                                                    <option value="7" <?= ($equipamento->id_categoria == 7) ? 'selected' : '' ?>>Reabilitação</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_tipentrada" class="form-label">Tipo de entrada<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_tipentrada" name="tipo_entrada" required>
                                                    <option value="">Escolha uma opção</option>
                                                    <option value="1" <?= ($equipamento->id_tipo_entrada == 1) ? 'selected' : '' ?>>Compra</option>
                                                    <option value="2" <?= ($equipamento->id_tipo_entrada == 2) ? 'selected' : '' ?>>Doação</option>
                                                    <option value="3" <?= ($equipamento->id_tipo_entrada == 3) ? 'selected' : '' ?>>Aluguer</option>
                                                    <option value="4" <?= ($equipamento->id_tipo_entrada == 4) ? 'selected' : '' ?>>Empréstimo</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Marca e Modelo -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_marca" class="form-label">Marca<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_marca" name="marca" value="<?= htmlspecialchars($equipamento->marca) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_modelo" class="form-label">Modelo<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_modelo" name="modelo" value="<?= htmlspecialchars($equipamento->modelo) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Fabricante e Ano de fabrico -->
                                        <div class="row mb-3">
                                            <div class="col-md-8">
                                                <label for="texto_fabricante" class="form-label">Fabricante<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_fabricante" name="fabricante" value="<?= htmlspecialchars($equipamento->fabricante) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ano_fabrico" class="form-label">Ano de fabrico<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" min="1980" max="2026" value="<?= htmlspecialchars($equipamento->ano_fabrico) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Data e Custo de aquisição -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="data_aquisicao" class="form-label">Data de aquisição<span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="data_aquisicao" name="data_aquisicao" value="<?= htmlspecialchars($equipamento->data_aquisicao) ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_custo_aquisicao" class="form-label">Custo de aquisição<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_custo_aquisicao" name="custo_aquisicao" value="<?= htmlspecialchars($equipamento->custo_aquisicao) ?>" required>
                                            </div>
                                        </div>

                                        <!-- Estado atual e Criticidade -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_estado_atual" class="form-label">Estado atual<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_estado_atual" name="estado_atual" required>
                                                    <option value="">Escolha uma opção</option>
                                                    <option value="1" <?= ($equipamento->id_estado == 1) ? 'selected' : '' ?>>Ativo</option>
                                                    <option value="2" <?= ($equipamento->id_estado == 2) ? 'selected' : '' ?>>Inativo</option>
                                                    <option value="3" <?= ($equipamento->id_estado == 3) ? 'selected' : '' ?>>Em manutenção</option>
                                                    <option value="4" <?= ($equipamento->id_estado == 4) ? 'selected' : '' ?>>Em calibração</option>
                                                    <option value="5" <?= ($equipamento->id_estado == 5) ? 'selected' : '' ?>>Em quarentena</option>
                                                    <option value="6" <?= ($equipamento->id_estado == 6) ? 'selected' : '' ?>>Abatido</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_criticidade" class="form-label">Criticidade<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_criticidade" name="criticidade" required>
                                                    <option value="">Escolha uma opção</option>
                                                    <option value="1" <?= ($equipamento->id_criticidade == 1) ? 'selected' : '' ?>>Baixa</option>
                                                    <option value="2" <?= ($equipamento->id_criticidade == 2) ? 'selected' : '' ?>>Média</option>
                                                    <option value="3" <?= ($equipamento->id_criticidade == 3) ? 'selected' : '' ?>>Alta</option>
                                                    <option value="4" <?= ($equipamento->id_criticidade == 4) ? 'selected' : '' ?>>Suporte de vida</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Observações -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="texto_observacoes" class="form-label">Observações</label>
                                                <textarea class="form-control" id="observacoes_equipamento" name="observacoes_equipamento" rows="4"><?= htmlspecialchars($equipamento->observacoes) ?></textarea>
                                            </div>
                                        </div>

                                        <!-- Botões -->
                                        <div class="d-flex justify-content-center gap-3 mb-4">
                                            <a href="listar.php" class="btn admin-btn-cancel">
                                                <i class="fa-solid fa-xmark me-1"></i>Cancelar
                                            </a>

                                            <button type="button" class="btn admin-btn-save btn-next-tab" data-next="#fornecedor">
                                                Seguinte <i class="fa-solid fa-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="fornecedor">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Associar fornecedor<span class="text-danger">*</span></label>
                                                <select class="form-select" name="id_fornecedor" required>
                                                    <option value="">Selecione um fornecedor</option>
                                                    <?php foreach ($fornecedores as $fornecedor): ?>
                                                        <option value="<?= $fornecedor['id_fornecedor'] ?>"
                                                            <?= ($fornecedor_atual && $fornecedor_atual->id_fornecedor == $fornecedor['id_fornecedor']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($fornecedor['codigo'] . ' - ' . $fornecedor['nome_empresa']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botões -->
                                        <div class="d-flex justify-content-between mb-4">
                                            <button type="button" class="btn admin-btn-cancel btn-prev-tab" data-prev="#equipamento">
                                                <i class="fa-solid fa-arrow-left me-1"></i>Anterior
                                            </button>

                                            <button type="button" class="btn admin-btn-save btn-next-tab" data-next="#localizacao">
                                                Seguinte <i class="fa-solid fa-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="localizacao">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                 <label class="form-label">Associar localização<span class="text-danger">*</span></label>
                                                <select class="form-select" name="id_localizacao" required>
                                                    <option value="">Selecione uma localização</option>
                                                    <?php foreach ($localizacoes as $localizacao): ?>
                                                        <option value="<?= $localizacao['id_localizacao'] ?>"
                                                            <?= ($equipamento->id_localizacao == $localizacao['id_localizacao']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($localizacao['codigo'] . ' - ' . $localizacao['edificio'] . ', ' . $localizacao['piso'] . ' - ' . $localizacao['servico_departamento']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botões -->
                                        <div class="d-flex justify-content-center gap-3 mb-4">
                                            <button type="button" class="btn admin-btn-cancel btn-prev-tab" data-prev="#fornecedor">
                                                <i class="fa-solid fa-arrow-left me-1"></i>Anterior
                                            </button>

                                            <button type="button" class="btn admin-btn-save btn-next-tab" data-next="#documentacao">
                                                Seguinte <i class="fa-solid fa-arrow-right ms-1"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="documentacao">
                                        <div class="row mb-3">
                                            <!-- Código e tipo de documento -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_codigo_documento" class="form-label">Código<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_codigo_documento" name="codigo_documento" value="<?= htmlspecialchars($documento->codigo_documento ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_tipo" class="form-label">Tipo de documento<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_tipo" name="tipo_documento" required>
                                                        <option value="">Escolha uma opção</option>
                                                        <option value="1" <?= (($documento->id_tipo_documento ?? '') == 1) ? 'selected' : '' ?>>Manual do Utilizador</option>
                                                        <option value="2" <?= (($documento->id_tipo_documento ?? '') == 2) ? 'selected' : '' ?>>Manual Técnico</option>
                                                        <option value="3" <?= (($documento->id_tipo_documento ?? '') == 3) ? 'selected' : '' ?>>Certificado CE</option>
                                                        <option value="4" <?= (($documento->id_tipo_documento ?? '') == 4) ? 'selected' : '' ?>>Ficha Técnica</option>
                                                        <option value="5" <?= (($documento->id_tipo_documento ?? '') == 5) ? 'selected' : '' ?>>Relatório de Manutenção</option>
                                                        <option value="6" <?= (($documento->id_tipo_documento ?? '') == 6) ? 'selected' : '' ?>>Certificado de Calibração</option>
                                                        <option value="7" <?= (($documento->id_tipo_documento ?? '') == 7) ? 'selected' : '' ?>>Relatório de Inspeção</option>
                                                        <option value="8" <?= (($documento->id_tipo_documento ?? '') == 8) ? 'selected' : '' ?>>Outro</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Nome/Localização do documento e upload do ficheiro -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_nome_localizacao" class="form-label">Nome/Localização do documento<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_nome_localizacao" name="nome_localizacao_documento" value="<?= htmlspecialchars($documento->nome_localizacao_documento ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="ficheiro_documento" class="form-label">Upload do ficheiro</label>
                                                    <input type="file" class="form-control" id="ficheiro_documento" name="ficheiro_documento" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png">
                                                </div>
                                            </div>

                                            <!-- Data de emissão e de validade  -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_data_emissao" class="form-label">Data de emissão<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_emissao" name="data_emissao" value="<?= htmlspecialchars($documento->data_emissao ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_data_validade" class="form-label">Data de validade</label>
                                                    <input type="date" class="form-control" id="texto_data_validade" name="data_validade" value="<?= htmlspecialchars($documento->data_validade ?? '') ?>">
                                                </div>
                                            </div>

                                            <!--Fornecedor associados -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="texto_fornecedor" class="form-label">Fornecedor associado</label>
                                                    <select class="form-select" name="id_fornecedor_documento">
                                                        <option value="">Selecione um fornecedor</option>
                                                        <?php foreach ($fornecedores as $fornecedor): ?>
                                                            <option value="<?= $fornecedor['id_fornecedor'] ?>"
                                                                <?= (($documento->id_fornecedor ?? '') == $fornecedor['id_fornecedor']) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($fornecedor['codigo'] . ' - ' . $fornecedor['nome_empresa']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="texto_observacoes" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="observacoes_documento" name="observacoes_documento" rows="4"><?= htmlspecialchars($documento->observacoes ?? '') ?></textarea>
                                                </div>
                                            </div>

                                            <!-- Botões -->
                                            <div class="d-flex justify-content-center gap-3 mb-4">
                                                <button type="button" class="btn admin-btn-cancel btn-prev-tab" data-prev="#localizacao">
                                                    <i class="fa-solid fa-arrow-left me-1"></i>Anterior
                                                </button>

                                                <button type="button" class="btn admin-btn-save btn-next-tab" data-next="#garantias">
                                                    Seguinte <i class="fa-solid fa-arrow-right ms-1"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade <?= $abrir_garantias ? 'show active' : '' ?>" id="garantias">
                                        <div class="row mb-3">
                                            <!-- Código e Data de ínicio da validade -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_codigo_garantia" class="form-label">Código<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_codigo_garantia" name="codigo_garantia" value="<?= htmlspecialchars($garantia->codigo_garantia ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_data_inicio" class="form-label">Data de início da garantia<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_inicio" name="data_inicio" value="<?= htmlspecialchars($garantia->data_inicio ?? '') ?>" required>
                                                </div>
                                            </div>

                                            <!-- Data de fim da garantia e estado-->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_data_fim" class="form-label">Data de fim da garantia<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_fim" name="data_fim" value="<?= htmlspecialchars($garantia->data_fim ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_estado" class="form-label">Estado<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_estado" name="estado" required>
                                                        <option value="">Escolha uma opção</option>
                                                        <option value="1" <?= (($garantia->id_estado_garantia ?? '') == 1) ? 'selected' : '' ?>>Ativa</option>
                                                        <option value="2" <?= (($garantia->id_estado_garantia ?? '') == 2) ? 'selected' : '' ?>>A expirar</option>
                                                        <option value="3" <?= (($garantia->id_estado_garantia ?? '') == 3) ? 'selected' : '' ?>>Expirada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Existência e tipo de contrato de manutenção -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_existencia_contrato" class="form-label">Existência de contrato de manutenção<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_existencia_contrato" name="existencia_contrato" required>
                                                        <option value="">Escolha uma opção</option>
                                                        <option value="sim" <?= (($garantia->existe_contrato ?? '') == 1) ? 'selected' : '' ?>>Sim</option>
                                                        <option value="nao" <?= (($garantia->existe_contrato ?? '') === 0 || ($garantia->existe_contrato ?? '') === '0') ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_tipo_contrato" class="form-label">Tipo de contrato</label>
                                                    <select class="form-select" id="texto_tipo_contrato" name="tipo_contrato">
                                                        <option value="">Escolha uma opção</option>
                                                        <option value="1" <?= (($garantia->id_tipo_contrato ?? '') == 1) ? 'selected' : '' ?>>Manutenção preventiva</option>
                                                        <option value="2" <?= (($garantia->id_tipo_contrato ?? '') == 2) ? 'selected' : '' ?>>Manutenção corretiva</option>
                                                        <option value="3" <?= (($garantia->id_tipo_contrato ?? '') == 3) ? 'selected' : '' ?>>Manutenção preventiva e corretiva</option>
                                                        <option value="4" <?= (($garantia->id_tipo_contrato ?? '') == 4) ? 'selected' : '' ?>>Manutenção completa</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Entidade responsável e periodicidade -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_entidade" class="form-label">Entidade responsável</label>
                                                    <input type="text" class="form-control" id="texto_entidade" name="entidade_responsavel" value="<?= htmlspecialchars($garantia->entidade_responsavel ?? '') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_periodicidade" class="form-label">Periodicidade</label>
                                                    <select class="form-select" id="texto_periodicidade" name="periodicidade">
                                                        <option value="">Escolha uma opção</option>
                                                        <option value="1" <?= (($garantia->id_periodicidade ?? '') == 1) ? 'selected' : '' ?>>Mensal</option>
                                                        <option value="2" <?= (($garantia->id_periodicidade ?? '') == 2) ? 'selected' : '' ?>>Trimestral</option>
                                                        <option value="3" <?= (($garantia->id_periodicidade ?? '') == 3) ? 'selected' : '' ?>>Semestral</option>
                                                        <option value="4" <?= (($garantia->id_periodicidade ?? '') == 4) ? 'selected' : '' ?>>Anual</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="texto_observacoes" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="observacoes_garantia" name="observacoes_garantia" rows="4"><?= htmlspecialchars($garantia->observacoes ?? '') ?></textarea>
                                                </div>
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

                                            <!-- Botões -->
                                            <div class="d-flex justify-content-center gap-3 mb-4">
                                                <button type="button" class="btn admin-btn-cancel btn-prev-tab" data-prev="#documentacao">
                                                    <i class="fa-solid fa-arrow-left me-1"></i>Anterior
                                                </button>

                                                <button type="submit" class="btn admin-btn-save">
                                                    <i class="fa-regular fa-floppy-disk me-1"></i>Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="../../../assets/js/1241327.js"></script>

<?php include '../../includes/footer.php'; ?>