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
                                        <input type="text" class="form-control" id="texto_codigo" placeholder="Ex: FOR.001" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_nome" class="form-label">Nome da empresa<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_nome" placeholder="Ex: Dräger" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_tipo_fornecedor" class="form-label">Tipo de fornecedor<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_tipo_fornecedor" name="tipo_fornecedor" required>
                                            <option value="" selected>Escolha uma opção</option>
                                            <option value="fabricante">Fabricante</option>
                                            <option value="distribuidor">Distribuidor/fornecedor comercial</option>
                                            <option value="assistencia_tecnica">Empresa de assistência técnica</option>
                                            <option value="consumiveis">Fornecedor de consumíveis/acessórios</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Morada e Código postal -->
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label for="texto_morada" class="form-label">Morada<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_morada" placeholder="Ex: Rua Engenheiro Frederico Ulrich TecMaia, nº21, Moreira " required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_codigo_postal" class="form-label">Código postal<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo_postal" placeholder="Ex: 4470-605" required>
                                    </div>
                                </div>

                                <!-- NIF e Contacto da empresa -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_NIF" class="form-label">NIF<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_NIF" placeholder="Ex: 500123456" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_contacto_telefonico" class="form-label">Contacto da empresa<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="texto_contacto_telefonico" placeholder="Ex: 211 554 587" required>
                                    </div>
                                </div>

                                <!-- Email e Website -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_email" class="form-label">Email<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_email" placeholder="Ex: geral@drager.pt" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_website" class="form-label">Website<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_website" placeholder="Ex: https://www.draeger.com/pt-br_br/Home" required> 
                                    </div>
                                </div>

                                <!-- Pessoa de contacto e Número telefónico -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_pessoa_contacto" class="form-label">Pessoa de contacto<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_pessoa_contacto" placeholder="Ex: Rafael Alves" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_numero_telefonico" class="form-label">Número telefónico (pessoa de contacto)<span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control" id="texto_numero_telefonico" placeholder="Ex: +351 999 999 999" required>
                                    </div>
                                </div>

                                <!-- Observações -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="texto_observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="texto_observacoes" placeholder="Ex: Fornecedor especializado em equipamentos de ventilação, anestesia e monitorização hospitalar." rows="4"></textarea>
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
                                <div class="alert alert-danger text-center d-none" role="alert"> Erro </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>                         

<?php include '../../includes/footer.php'; ?>