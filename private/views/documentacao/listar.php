<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 px-4 ps-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">
                        <i class=""></i><strong>Listagem de Documentos</strong>
                    </h2>
                </div>
                <hr> 

                <!-- Pesquisa, filtros, vista e ordenação -->
                <div class="d-flex flex-wrap align-items-center gap-2 mb-5 pb-2">
                    
                    <!-- Pesquisa -->
                    <div class="flex-grow-1">
                        <input type="text" class="form-control" placeholder="Pesquisar por código, tipo de documento ...">
                    </div>
                    
                    <!-- Filtros rápidos -->
                    <select class="form-select" style="max-width: 190px;">
                        <option value="" selected disabled>Tipo de documento</option>
                        <option value="manual_utilizador">Manual do Utilizador</option>
                        <option value="manual_tecnico">Manual Técnico</option>
                        <option value="certificado_ce">Certificado CE</option>
                        <option value="ficha_tecnica">Ficha Técnica</option>
                        <option value="relatorio_manutencao">Relatório de Manutenção</option>
                        <option value="calibracao">Certificado de Calibração</option>
                        <option value="inspecao">Relatório de Inspeção</option>
                        <option value="outro">Outro</option>
                    </select>

                    <select class="form-select" style="max-width: 145px;">
                        <option value="" selected disabled>Validade</option>
                        <option value="com_validade">Com validade</option>
                        <option value="sem_validade">Sem validade</option>
                        <option value="expirado">Expirado</option>
                    </select>

                    <!-- Botão de pesquisa -->
                    <button class="btn admin-btn-cancel filter-btn mt-0">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="text-muted">
                        Documentos registados: [número de registos]
                    </p>
                    <div class="d-flex gap-2">
                        <select class="form-select" style="width: 170px;">
                            <option value="" selected disabled>Ordenar por</option>
                            <option value="codigo">Código</option>
                            <option value="tipo_documento">Tipo de documento</option>
                            <option value="equipamento_associado">Equipamento associado</option>
                        </select>

                        <select class="form-select" style="width: 170px;">
                            <option value="" selected disabled>Sentido</option>
                            <option value="crescente">Crescente ↑</option>
                            <option value="decrescente">Decrescente ↓</option>
                            <option value="alfabetica">Alfabética A → Z</option>
                            <option value="alfabetica_invertida">Alfabética Z → A</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">    
                        <thead class="table-header">
                            <tr>
                                <th class="text-center">Código</th> 
                                <th class="text-center">Tipo do documento</th>
                                <th class="text-center">Equipamento associado</th> 
                                <th class="text-center">Data de validade</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                                
                        <tbody>
                            <tr>
                                <td class="text-center">[Código]</td> 
                                <td class="text-center">[Tipo do documento]</td>
                                <td class="text-center">[Equipamento associado]</td>     
                                <td class="text-center">[Data de validade]</td>
                                <td class="text-center">
                                    <a href="detalhes.php" class="btn btn-sm btn-outline-primary me-1"> 
                                        <i class="fa-solid fa-circle-info"></i> 
                                    </a>
                                
                                    <a href="remover.php" class="btn btn-sm btn-outline-danger me-1"> 
                                        <i class="fa-solid fa-trash-can"></i> 
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>                         

<?php include '../../includes/footer.php'; ?>