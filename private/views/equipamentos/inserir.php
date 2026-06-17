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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Equipamento
    $nome = $_POST['nome'] ?? '';
    $codigo_interno = $_POST['codigo_interno'] ?? '';
    $numero_serie = $_POST['numero_serie'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $tipo_entrada = $_POST['tipo_entrada'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $fabricante = $_POST['fabricante'] ?? '';
    $ano_fabrico = $_POST['ano_fabrico'] ?? '';
    $data_aquisicao = $_POST['data_aquisicao'] ?? '';
    $custo_aquisicao = $_POST['custo_aquisicao'] ?? '';
    $estado_atual = $_POST['estado_atual'] ?? '';
    $criticidade = $_POST['criticidade'] ?? '';
    $observacoes_equipamento = $_POST['observacoes_equipamento'] ?? '';

    // Fornecedor
    $id_fornecedor = $_POST['id_fornecedor'] ?? '';

    // Localização
    $id_localizacao = $_POST['id_localizacao'] ?? '';

    // Documentação
    $codigo_documento = $_POST['codigo_documento'] ?? '';
    $tipo_documento = $_POST['tipo_documento'] ?? '';
    $nome_localizacao_documento = $_POST['nome_localizacao_documento'] ?? '';
    $data_emissao = $_POST['data_emissao'] ?? '';
    $data_validade = $_POST['data_validade'] ?? '';
    $id_fornecedor_documento = $_POST['id_fornecedor_documento'] ?? '';
    $observacoes_documento = $_POST['observacoes_documento'] ?? '';

    // Garantia
    $codigo_garantia = $_POST['codigo_garantia'] ?? '';
    $data_inicio = $_POST['data_inicio'] ?? '';
    $data_fim = $_POST['data_fim'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $existencia_contrato = $_POST['existencia_contrato'] ?? '';
    $tipo_contrato = $_POST['tipo_contrato'] ?? '';
    $entidade_responsavel = $_POST['entidade_responsavel'] ?? '';
    $periodicidade = $_POST['periodicidade'] ?? '';
    $observacoes_garantia = $_POST['observacoes_garantia'] ?? '';

    // 2. Validar os dados
    $erros = [];

    // Remover espaços no início e no fim
    $nome = trim($nome);
    $codigo_interno = trim($codigo_interno);
    $numero_serie = trim($numero_serie);
    $marca = trim($marca);
    $modelo = trim($modelo);
    $fabricante = trim($fabricante);
    $custo_aquisicao = trim($custo_aquisicao);
    $observacoes_equipamento = trim($observacoes_equipamento);

    $codigo_documento = trim($codigo_documento);
    $nome_localizacao_documento = trim($nome_localizacao_documento);
    $observacoes_documento = trim($observacoes_documento);

    $codigo_garantia = trim($codigo_garantia);
    $entidade_responsavel = trim($entidade_responsavel);
    $observacoes_garantia = trim($observacoes_garantia);

    // -------------------------
    // Validação do equipamento
    // -------------------------

    if (empty($nome)) {
        $erros[] = "O nome do equipamento é obrigatório.";
    }

    if (empty($codigo_interno)) {
        $erros[] = "O código interno é obrigatório.";
    }

    if (empty($numero_serie)) {
        $erros[] = "O número de série é obrigatório.";
    }

    if (empty($categoria)) {
        $erros[] = "A categoria é obrigatória.";
    }

    if (empty($tipo_entrada)) {
        $erros[] = "O tipo de entrada é obrigatório.";
    }

    if (empty($marca)) {
        $erros[] = "A marca é obrigatória.";
    }

    if (empty($modelo)) {
        $erros[] = "O modelo é obrigatório.";
    }

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

    if (empty($data_aquisicao)) {
        $erros[] = "A data de aquisição é obrigatória.";
    }

    if (empty($custo_aquisicao)) {
        $erros[] = "O custo de aquisição é obrigatório.";
    } elseif (!is_numeric(str_replace(',', '.', $custo_aquisicao))) {
        $erros[] = "O custo de aquisição deve ser numérico.";
    }

    if (empty($estado_atual)) {
        $erros[] = "O estado atual é obrigatório.";
    }

    if (empty($criticidade)) {
        $erros[] = "A criticidade é obrigatória.";
    }

    if (empty($id_fornecedor)) {
        $erros[] = "É obrigatório associar um fornecedor.";
    }

    if (empty($id_localizacao)) {
        $erros[] = "É obrigatório associar uma localização.";
    }

    // -------------------------
    // Validação da documentação
    // -------------------------

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

    // Campo opcional, mas se for preenchido tem de ser válido
    if (!empty($id_fornecedor_documento) && !is_numeric($id_fornecedor_documento)) {
        $erros[] = "O fornecedor associado ao documento é inválido.";
    }

    // -------------------------
    // Validação da garantia
    // -------------------------

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

    // Se existir contrato, estes campos passam a ser obrigatórios
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

    // Se não existir contrato, não deve ser escolhido tipo de contrato
    if ($existencia_contrato == 'nao' && !empty($tipo_contrato)) {
        $erros[] = "Não deve ser indicado tipo de contrato quando não existe contrato de manutenção.";
    }

    // Mostrar erros para depuração
    echo "<pre>";
    print_r($erros);
    echo "</pre>";
    }
?>

<?php
$fornecedores = [
    ['id' => 1, 'codigo' => 'FOR.001', 'nome' => 'Medtronic'],
    ['id' => 2, 'codigo' => 'FOR.002', 'nome' => 'Philips'],
    ['id' => 3, 'codigo' => 'FOR.003', 'nome' => 'Dräger']
];

$localizacoes = [
    ['id' => 1, 'codigo' => 'LOC.001', 'nome' => 'Bloco A'],
    ['id' => 2, 'codigo' => 'LOC.002', 'nome' => 'Bloco B'],
    ['id' => 3, 'codigo' => 'LOC.003', 'nome' => 'Bloco C']
];
?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-0 pb-4 px-4">
                <div class="d-flex justify-content-center mt-1">
                    <div class="card admin-card w-100 shadow rounded" style="max-width: 950px;">
                         <div class="card-body">
                            <h2 class="mb-4"><strong><i class="fa-solid fa-square-plus me-2"></i> Inserir novo equipamento</strong></h2>
                            <form action="#" method="post" novalidate>
                            
                                <ul class="nav nav-tabs justify-content-center mb-4" id="equipamentoTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#equipamento"><i class="fa-solid fa-laptop-medical me-1"></i>Equipamento </button>
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
                                        <button class="nav-link disabled" data-bs-toggle="tab" data-bs-target="#garantias"><i class="fa-solid fa-receipt me-1"></i>Garantias/Contratos</button>
                                    </li>
                                </ul>

                                
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="equipamento">
                                        <!-- Designação -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="texto_nome" class="form-label">Nome do equipamento<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_nome" name="nome" placeholder="Ex: Ventilador pulmonar" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
                                            </div>
                                        </div>

                                        <!-- Código interno de inventário e Número de série -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_código_interno" class="form-label">Código interno<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_código_interno" name="codigo_interno" placeholder="Ex: 04.002.00" value="<?= htmlspecialchars($_POST['codigo_interno'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_numero_serie" class="form-label">Número de série<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_numero_serie" name="numero_serie" placeholder="Ex: EV500-2021-9934" value="<?= htmlspecialchars($_POST['numero_serie'] ?? '') ?>" required>
                                            </div>
                                        </div>

                                        <!-- Categoria/Grupo e Tipo de entrada -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_categoria" class="form-label">Categoria<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_categoria" name="categoria" required>
                                                    <option value="">Escolha uma opção</option>

                                                    <option value="monitorizacao"
                                                        <?= (($_POST['categoria'] ?? '') == 'monitorizacao') ? 'selected' : '' ?>>
                                                        Monitorização
                                                    </option>

                                                    <option value="suporte_vida"
                                                        <?= (($_POST['categoria'] ?? '') == 'suporte_vida') ? 'selected' : '' ?>>
                                                        Suporte de vida
                                                    </option>

                                                    <option value="terapia"
                                                        <?= (($_POST['categoria'] ?? '') == 'terapia') ? 'selected' : '' ?>>
                                                        Terapia
                                                    </option>

                                                    <option value="diagnostico"
                                                        <?= (($_POST['categoria'] ?? '') == 'diagnostico') ? 'selected' : '' ?>>
                                                        Diagnóstico
                                                    </option>

                                                    <option value="laboratorio"
                                                        <?= (($_POST['categoria'] ?? '') == 'laboratorio') ? 'selected' : '' ?>>
                                                        Laboratório
                                                    </option>

                                                    <option value="esterilizacao"
                                                        <?= (($_POST['categoria'] ?? '') == 'esterilizacao') ? 'selected' : '' ?>>
                                                        Esterilização
                                                    </option>

                                                    <option value="reabilitacao"
                                                        <?= (($_POST['categoria'] ?? '') == 'reabilitacao') ? 'selected' : '' ?>>
                                                        Reabilitação
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_tipentrada" class="form-label">Tipo de entrada<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_tipentrada" name="tipo_entrada" required>
                                                    <option value="">Escolha uma opção</option>

                                                    <option value="compra"
                                                        <?= (($_POST['tipo_entrada'] ?? '') == 'compra') ? 'selected' : '' ?>>
                                                        Compra
                                                    </option>

                                                    <option value="doacao"
                                                        <?= (($_POST['tipo_entrada'] ?? '') == 'doacao') ? 'selected' : '' ?>>
                                                        Doação
                                                    </option>

                                                    <option value="aluguer"
                                                        <?= (($_POST['tipo_entrada'] ?? '') == 'aluguer') ? 'selected' : '' ?>>
                                                        Aluguer
                                                    </option>

                                                    <option value="emprestimo"
                                                        <?= (($_POST['tipo_entrada'] ?? '') == 'emprestimo') ? 'selected' : '' ?>>
                                                        Empréstimo
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Marca e Modelo -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_marca" class="form-label">Marca<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_marca" name="marca" placeholder="Ex: Dräger" value="<?= htmlspecialchars($_POST['marca'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_modelo" class="form-label">Modelo<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_modelo" name="modelo" placeholder="Ex: Evita V500" value="<?= htmlspecialchars($_POST['modelo'] ?? '') ?>" required>
                                            </div>
                                        </div>

                                        <!-- Fabricante e Ano de fabrico -->
                                        <div class="row mb-3">
                                            <div class="col-md-8">
                                                <label for="texto_fabricante" class="form-label">Fabricante<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_fabricante" name="fabricante" placeholder="Ex: Dräger" value="<?= htmlspecialchars($_POST['fabricante'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="ano_fabrico" class="form-label">Ano de fabrico<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="ano_fabrico" name="ano_fabrico" min="1980" max="2026" placeholder="Ex: 2023" value="<?= htmlspecialchars($_POST['ano_fabrico'] ?? '') ?>" required>
                                            </div>
                                        </div>

                                        <!-- Data e Custo de aquisição -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="data_aquisicao" class="form-label">Data de aquisição<span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="data_aquisicao" name="data_aquisicao" value="<?= htmlspecialchars($_POST['data_aquisicao'] ?? '') ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_custo_aquisicao" class="form-label">Custo de aquisição<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="texto_custo_aquisicao" name="custo_aquisicao" placeholder="Ex: 500€" value="<?= htmlspecialchars($_POST['custo_aquisicao'] ?? '') ?>" required>
                                            </div>
                                        </div>

                                        <!-- Estado atual e Criticidade -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="texto_estado_atual" class="form-label">Estado atual<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_estado_atual" name="estado_atual" required>
                                                    <option value="">Escolha uma opção</option>

                                                    <option value="ativo"
                                                        <?= (($_POST['estado_atual'] ?? '') == 'ativo') ? 'selected' : '' ?>>
                                                        Ativo
                                                    </option>

                                                    <option value="inativo"
                                                        <?= (($_POST['estado_atual'] ?? '') == 'inativo') ? 'selected' : '' ?>>
                                                        Inativo
                                                    </option>

                                                    <option value="manutencao"
                                                        <?= (($_POST['estado_atual'] ?? '') == 'manutencao') ? 'selected' : '' ?>>
                                                        Em manutenção
                                                    </option>

                                                    <option value="calibracao"
                                                        <?= (($_POST['estado_atual'] ?? '') == 'calibracao') ? 'selected' : '' ?>>
                                                        Em calibração
                                                    </option>

                                                    <option value="quarentena"
                                                        <?= (($_POST['estado_atual'] ?? '') == 'quarentena') ? 'selected' : '' ?>>
                                                        Em quarentena
                                                    </option>

                                                    <option value="abatido"
                                                        <?= (($_POST['estado_atual'] ?? '') == 'abatido') ? 'selected' : '' ?>>
                                                        Abatido
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="texto_criticidade" class="form-label">Criticidade<span class="text-danger">*</span></label>
                                                <select class="form-select" id="texto_criticidade" name="criticidade" required>
                                                    <option value="">Escolha uma opção</option>

                                                    <option value="baixa"
                                                        <?= (($_POST['criticidade'] ?? '') == 'baixa') ? 'selected' : '' ?>>
                                                        Baixa
                                                    </option>

                                                    <option value="media"
                                                        <?= (($_POST['criticidade'] ?? '') == 'media') ? 'selected' : '' ?>>
                                                        Média
                                                    </option>

                                                    <option value="alta"
                                                        <?= (($_POST['criticidade'] ?? '') == 'alta') ? 'selected' : '' ?>>
                                                        Alta
                                                    </option>

                                                    <option value="suporte_de_vida"
                                                        <?= (($_POST['criticidade'] ?? '') == 'suporte_de_vida') ? 'selected' : '' ?>>
                                                        Suporte de vida
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Observações -->
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="observacoes_equipamento" class="form-label">Observações</label>
                                                <textarea class="form-control" id="observacoes_equipamento" name="observacoes_equipamento" rows="4"><?= htmlspecialchars($_POST['observacoes_equipamento'] ?? '') ?></textarea>
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

                                        <!-- Erros -->
                                        <div class="alert alert-danger text-center d-none" role="alert"> Erro </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="fornecedor">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Associar fornecedor</label>

                                                <select class="form-select" name="id_fornecedor" required>
                                                    <option value="">Selecione um fornecedor</option>
                                                    <?php if (isset($fornecedores)): ?>
                                                        <?php foreach ($fornecedores as $fornecedor): ?>
                                                            <option value="<?= $fornecedor['id'] ?>"
                                                                <?= (($_POST['id_fornecedor'] ?? '') == $fornecedor['id']) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($fornecedor['codigo']) ?> - <?= htmlspecialchars($fornecedor['nome']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Botões -->
                                        <div class="d-flex justify-content-center gap-3 mb-4">
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
                                                <label class="form-label">Associar localização</label>

                                                <select class="form-select" name="id_localizacao" required>
                                                    <option value="">Selecione uma localização</option>
                                                    <?php if (isset($localizacoes)): ?>
                                                        <?php foreach ($localizacoes as $localizacao): ?>
                                                            <option value="<?= $localizacao['id'] ?>"
                                                                <?= (($_POST['id_localizacao'] ?? '') == $localizacao['id']) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($localizacao['codigo']) ?> - <?= htmlspecialchars($localizacao['nome']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
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
                                                    <input type="text" class="form-control" id="texto_codigo_documento" name="codigo_documento" placeholder="Ex: DOC.001" value="<?= htmlspecialchars($_POST['codigo_documento'] ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_tipo" class="form-label">Tipo de documento<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_tipo" name="tipo_documento" required>
                                                        <option value="">Escolha uma opção</option>

                                                        <option value="manual_utilizador" <?= (($_POST['tipo_documento'] ?? '') == 'manual_utilizador') ? 'selected' : '' ?>>Manual do Utilizador</option>
                                                        <option value="manual_tecnico" <?= (($_POST['tipo_documento'] ?? '') == 'manual_tecnico') ? 'selected' : '' ?>>Manual Técnico</option>
                                                        <option value="certificado_ce" <?= (($_POST['tipo_documento'] ?? '') == 'certificado_ce') ? 'selected' : '' ?>>Certificado CE</option>
                                                        <option value="ficha_tecnica" <?= (($_POST['tipo_documento'] ?? '') == 'ficha_tecnica') ? 'selected' : '' ?>>Ficha Técnica</option>
                                                        <option value="relatorio_manutencao" <?= (($_POST['tipo_documento'] ?? '') == 'relatorio_manutencao') ? 'selected' : '' ?>>Relatório de Manutenção</option>
                                                        <option value="calibracao" <?= (($_POST['tipo_documento'] ?? '') == 'calibracao') ? 'selected' : '' ?>>Certificado de Calibração</option>
                                                        <option value="inspecao" <?= (($_POST['tipo_documento'] ?? '') == 'inspecao') ? 'selected' : '' ?>>Relatório de Inspeção</option>
                                                        <option value="outro" <?= (($_POST['tipo_documento'] ?? '') == 'outro') ? 'selected' : '' ?>>Outro</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Nome/Localização do documento e upload do ficheiro -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_nome_localizacao" class="form-label">Nome/Localização do documento<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_nome_localizacao" name="nome_localizacao_documento" placeholder="Ex: manual_monitor_3.pdf" value="<?= htmlspecialchars($_POST['nome_localizacao_documento'] ?? '') ?>" required>
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
                                                    <input type="date" class="form-control" id="texto_data_emissao" name="data_emissao" value="<?= htmlspecialchars($_POST['data_emissao'] ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_data_validade" class="form-label">Data de validade</label>
                                                    <input type="date" class="form-control" id="texto_data_validade" name="data_validade" value="<?= htmlspecialchars($_POST['data_validade'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <!--Fornecedor associados -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="texto_fornecedor" class="form-label">Fornecedor associado</label>
                                                    <select class="form-select" name="id_fornecedor_documento">
                                                        <option value="">Selecione um fornecedor</option>

                                                        <?php if (isset($fornecedores)): ?>
                                                            <?php foreach ($fornecedores as $fornecedor): ?>
                                                                <option value="<?= $fornecedor['id'] ?>"
                                                                    <?= (($_POST['id_fornecedor_documento'] ?? '') == $fornecedor['id']) ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($fornecedor['codigo']) ?> - <?= htmlspecialchars($fornecedor['nome']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="observacoes_documento" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="observacoes_documento" name="observacoes_documento" placeholder="Ex: Versão atual do documento. Revisão efetuada em janeiro de 2026." rows="4"><?= htmlspecialchars($_POST['observacoes_documento'] ?? '') ?></textarea>
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

                                    <div class="tab-pane fade" id="garantias">
                                        <div class="row mb-3">
                                            <!-- Código e Data de início da garantia -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_codigo_garantia" class="form-label">Código<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_codigo_garantia" name="codigo_garantia" placeholder="Ex: GAR.001" value="<?= htmlspecialchars($_POST['codigo_garantia'] ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_data_inicio" class="form-label">Data de início da garantia<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_inicio" name="data_inicio" value="<?= htmlspecialchars($_POST['data_inicio'] ?? '') ?>" required>
                                                </div>
                                            </div>

                                            <!-- Data de fim da garantia e estado-->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_data_fim" class="form-label">Data de fim da garantia<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_fim" name="data_fim" value="<?= htmlspecialchars($_POST['data_fim'] ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_estado" class="form-label">Estado<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_estado" name="estado" required>
                                                        <option value="">Escolha uma opção</option>

                                                        <option value="ativa" <?= (($_POST['estado'] ?? '') == 'ativa') ? 'selected' : '' ?>>Ativa</option>
                                                        <option value="expirar" <?= (($_POST['estado'] ?? '') == 'expirar') ? 'selected' : '' ?>>A expirar</option>
                                                        <option value="expirada" <?= (($_POST['estado'] ?? '') == 'expirada') ? 'selected' : '' ?>>Expirada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Existência e tipo de contrato de manutenção -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_existencia_contrato" class="form-label">Existência de contrato de manutenção<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_existencia_contrato" name="existencia_contrato" required>
                                                        <option value="">Escolha uma opção</option>

                                                        <option value="sim" <?= (($_POST['existencia_contrato'] ?? '') == 'sim') ? 'selected' : '' ?>>Sim</option>
                                                        <option value="nao" <?= (($_POST['existencia_contrato'] ?? '') == 'nao') ? 'selected' : '' ?>>Não</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_tipo_contrato" class="form-label">Tipo de contrato</label>
                                                    <select class="form-select" id="texto_tipo_contrato" name="tipo_contrato">
                                                        <option value="">Escolha uma opção</option>

                                                        <option value="manutencao_preventiva" <?= (($_POST['tipo_contrato'] ?? '') == 'manutencao_preventiva') ? 'selected' : '' ?>>Manutenção preventiva</option>
                                                        <option value="manutencao_corretiva" <?= (($_POST['tipo_contrato'] ?? '') == 'manutencao_corretiva') ? 'selected' : '' ?>>Manutenção corretiva</option>
                                                        <option value="manutencao_preventiva_corretiva" <?= (($_POST['tipo_contrato'] ?? '') == 'manutencao_preventiva_corretiva') ? 'selected' : '' ?>>Manutenção preventiva e corretiva</option>
                                                        <option value="manutencao_completa" <?= (($_POST['tipo_contrato'] ?? '') == 'manutencao_completa') ? 'selected' : '' ?>>Manutenção completa</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Entidade responsável e periodicidade -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_entidade" class="form-label">Entidade responsável</label>
                                                    <input type="text" class="form-control" id="texto_entidade" name="entidade_responsavel" placeholder="Ex: Dräger" value="<?= htmlspecialchars($_POST['entidade_responsavel'] ?? '') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_periodicidade" class="form-label">Periodicidade</label>
                                                    <select class="form-select" id="texto_periodicidade" name="periodicidade">
                                                        <option value="">Escolha uma opção</option>

                                                        <option value="mensal" <?= (($_POST['periodicidade'] ?? '') == 'mensal') ? 'selected' : '' ?>>Mensal</option>
                                                        <option value="semestral" <?= (($_POST['periodicidade'] ?? '') == 'semestral') ? 'selected' : '' ?>>Semestral</option>
                                                        <option value="trimestral" <?= (($_POST['periodicidade'] ?? '') == 'trimestral') ? 'selected' : '' ?>>Trimestral</option>
                                                        <option value="anual" <?= (($_POST['periodicidade'] ?? '') == 'anual') ? 'selected' : '' ?>>Anual</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="observacoes_garantia" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="observacoes_garantia" name="observacoes_garantia" placeholder="Ex: Contrato com suporte técnico incluído." rows="4"><?= htmlspecialchars($_POST['observacoes_garantia'] ?? '') ?></textarea>
                                                </div>
                                            </div>

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