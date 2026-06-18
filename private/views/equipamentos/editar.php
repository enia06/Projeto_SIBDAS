<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado
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

$erro_sistema = "";
$equipamento = null;

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

} catch (PDOException $err) {
    $erro_sistema = "Erro na ligação à base de dados.";
}

$ligacao = null;

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

                                        <!-- Erros -->
                                        <div class="alert alert-danger text-center d-none" role="alert"> Erro </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="fornecedor">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label class="form-label">Associar fornecedor</label>

                                                <select class="form-select">
                                                    <option selected> Selecione um fornecedor</option>
                                                    <option>FOR.001 - Medtronic</option>
                                                    <option>FOR.002 - Philips</option>
                                                    <option>FOR.003 - Dräger</option>
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
                                                <label class="form-label">Associar localização</label>

                                                <select class="form-select">
                                                    <option selected>Selecione uma localização</option>
                                                    <option>LOC.001 - Bloco A</option>
                                                    <option>LOC.002 - Bloco B</option>
                                                    <option>LOC.003 - Bloco C</option>
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
                                                    <input type="text" class="form-control" id="texto_codigo_documento" placeholder="Ex: DOC.001" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_tipo" class="form-label">Tipo de documento<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_tipo" name="tipo_documento" required>
                                                        <option selected>Escolha uma opção</option>
                                                        <option value="manual_utilizador">Manual do Utilizador</option>
                                                        <option value="manual_tecnico">Manual Técnico</option>
                                                        <option value="certificado_ce">Certificado CE</option>
                                                        <option value="ficha_tecnica">Ficha Técnica</option>
                                                        <option value="relatorio_manutencao">Relatório de Manutenção</option>
                                                        <option value="calibracao">Certificado de Calibração</option>
                                                        <option value="inspecao">Relatório de Inspeção</option>
                                                        <option value="outro">Outro</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Nome/Localização do documento e upload do ficheiro -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_nome_localizacao" class="form-label">Nome/Localização do documento<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_nome_localizacao" placeholder="Ex: manual_monitor_3.pdf" required>
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
                                                    <input type="date" class="form-control" id="texto_data_emissao" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_data_validade" class="form-label">Data de validade</label>
                                                    <input type="date" class="form-control" id="texto_data_validade">
                                                </div>
                                            </div>

                                            <!--Fornecedor associados -->
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="texto_fornecedor" class="form-label">Fornecedor associado</label>
                                                    <select class="form-select">
                                                        <option selected>Selecione um fornecedor</option>
                                                        <option>FOR.001 - Medtronic</option>
                                                        <option>FOR.002 - Philips</option>
                                                        <option>FOR.003 - Dräger</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="texto_observacoes" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="texto_observacoes" placeholder="Ex: Versão atual do documento. Revisão efetuada em janeiro de 2026." rows="4"></textarea>
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
                                            <!-- Código e Data de ínicio da validade -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_codigo_garantia" class="form-label">Código<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="texto_codigo_garantia" placeholder="Ex: GAR.001" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_data_inicio" class="form-label">Data de início da garantia<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_inicio" required>
                                                </div>
                                            </div>

                                            <!-- Data de fim da garantia e estado-->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_data_fim" class="form-label">Data de fim da garantia<span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" id="texto_data_fim" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_estado" class="form-label">Estado<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_estado" name="estado" required>
                                                        <option selected>Escolha uma opção</option>
                                                        <option value="ativa">Ativa</option>
                                                        <option value="expirar">A expirar</option>
                                                        <option value="expirada">Expirada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <!-- Existência e tipo de contrato de manutenção -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_existencia_contrato" class="form-label">Existência de contrato de manutenção<span class="text-danger">*</span></label>
                                                    <select class="form-select" id="texto_existencia_contrato" name="existencia_contrato" required>
                                                        <option selected>Escolha uma opção</option>
                                                        <option value="sim">Sim</option>
                                                        <option value="nao">Não</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_tipo_contrato" class="form-label">Tipo de contrato</label>
                                                    <select class="form-select" id="texto_tipo_contrato" name="tipo_contrato">
                                                        <option selected>Escolha uma opção</option>
                                                        <option value="manutencao_preventiva">Manutenção preventiva</option>
                                                        <option value="manutencao_corretiva">Manutenção corretiva</option>
                                                        <option value="manutencao_preventiva_corretiva">Manutenção preventiva e corretiva</option>
                                                        <option value="manutencao_completa">Manutenção completa</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Entidade responsável e periodicidade -->
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="texto_entidade" class="form-label">Entidade responsável</label>
                                                    <input type="text" class="form-control" id="texto_entidade" placeholder="Ex: Dräger">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="texto_periodicidade" class="form-label">Periodicidade</label>
                                                    <select class="form-select" id="texto_periodicidade" name="periodicidade">
                                                        <option selected>Escolha uma opção</option>
                                                        <option value="mensal">Mensal</option>
                                                        <option value="semestral">Semestral</option>
                                                        <option value="trimestral">Trimestral</option>
                                                        <option value="anual">Anual</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Observações -->
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <label for="texto_observacoes" class="form-label">Observações</label>
                                                    <textarea class="form-control" id="texto_observacoes" placeholder="Ex: Contrato com suporte técnico incluído." rows="4"></textarea>
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