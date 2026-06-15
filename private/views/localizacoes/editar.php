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
                            <h2 class="mb-4"><strong><i class="fa-solid fa-pen-to-square me-2"></i> Editar localização</strong></h2>
                            <form action="#" method="post" novalidate>
                                <!-- Código,Edifício e Piso -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="texto_codigo" class="form-label">Código<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_codigo" placeholder="Ex: LOC.001" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_edificio" class="form-label">Edifício<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_edificio" name="edificio" required>
                                            <option value="" selected>Escolha uma opção</option>
                                            <option value="bloco_a">Bloco A</option>
                                            <option value="bloco_b">Bloco B</option>
                                            <option value="bloco_c">Bloco C</option>
                                            <option value="bloco_d">Bloco D</option>
                                            <option value="bloco_e">Bloco E</option>
                                            <option value="bloco_f">Bloco F</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="texto_piso" class="form-label">Piso<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_piso" placeholder="Ex: Piso 2" required>
                                    </div>
                                </div>

                                <!-- Serviço/Departamento e Acesso -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_servico" class="form-label">Serviço/Departamento<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_servico" name="servico_departamento" required>
                                            <option value="" selected>Escolha uma opção</option>
                                            <option value="urgencias">Urgências</option>
                                            <option value="uci">Unidade de Cuidados Intensivos</option>
                                            <option value="pediatria">Pediatria</option>
                                            <option value="cardiologia">Cardiologia</option>
                                            <option value="neurologia">Neurologia</option>
                                            <option value="ortopedia">Ortopedia</option>
                                            <option value="radiologia">Radiologia</option>
                                            <option value="imagiologia">Imagiologia</option>
                                            <option value="laboratorio_analises">Laboratório de Análises Clínicas</option>
                                            <option value="farmacia">Farmácia Hospitalar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_acesso" class="form-label">Acesso<span class="text-danger">*</span></label>
                                        <select class="form-select" id="texto_acesso" name="texto_acesso" required>
                                            <option value="" selected>Escolha uma opção</option>
                                            <option value="acesso_livre">Acesso livre</option>
                                            <option value="acesso_autorizado">Acesso autorizado</option>
                                            <option value="acesso_restrito">Acesso restrito</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Sala/Gabinete e Responsável -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="texto_sala_gabinete" class="form-label">Sala/Gabinete<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_sala_gabinete" placeholder="Ex: Gabinete 03" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="texto_responsavel" class="form-label">Responsável<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="texto_responsavel" placeholder="Ex: Dra. Raquel Vieira" required>
                                    </div>
                        
                                </div>

                                <!-- Observações -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="texto_observacoes" class="form-label">Observações</label>
                                        <textarea class="form-control" id="texto_observacoes" placeholder="Ex: Localização sujeita a controlo de acesso por cartão." rows="4"></textarea>
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