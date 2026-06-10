<?php include '../../includes/header.php'; ?>
<?php include '../../includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include '../../includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 pb-5 px-5">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="mb-0">
                            <strong>Gestão de Conteúdos Públicos</strong>
                        </h2>
                    </div>
                    <hr>
                    <p class="text-muted fs-5 mb-4">
                        Atualize os conteúdos apresentados na área pública do website.
                    </p>

                    <div class="row g-4 mb-5 justify-content-center">

                        <!-- Bem-vindo -->
                        <div class="col-lg-5 col-md-6">
                            <div class="card admin-card shadow rounded h-100">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="detail-section-title mb-0">
                                            <i class="fa-solid fa-house me-2"></i>Secção Bem-vindo
                                        </h5>

                                        <button class="btn admin-btn-save btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalBemVindo">
                                            <i class="fa-solid fa-file-pen me-1"></i>Editar
                                        </button>
                                    </div>

                                    <p><strong>Conteúdo editável:</strong></p>
                                    <p>- Título</p>
                                    <p>- Descrição</p>

                                    <p><strong>Última atualização:</strong></p>
                                    <p>02/04/2026</p>

                                </div>
                            </div>
                        </div>

                        <!-- Sobre Nós -->
                        <div class="col-lg-5 col-md-6">
                            <div class="card admin-card shadow rounded h-100">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="detail-section-title mb-0">
                                            <i class="fa-solid fa-circle-info me-2"></i>Secção Sobre Nós
                                        </h5>

                                        <button class="btn admin-btn-save btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalSobreNos">
                                            <i class="fa-solid fa-file-pen me-1"></i>Editar
                                        </button>
                                    </div>

                                    <p><strong>Conteúdo editável:</strong></p>
                                    <p>- Título</p>
                                    <p>- Descrição</p>
                                    <p>- Botão</p>

                                    <p><strong>Última atualização:</strong></p>
                                    <p>02/04/2026</p>

                                </div>
                            </div>
                        </div>

                        <!-- Serviços -->
                        <div class="col-lg-5 col-md-6">
                            <div class="card admin-card shadow rounded h-100">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="detail-section-title mb-0">
                                            <i class="fa-solid fa-screwdriver-wrench me-2"></i>Secção Serviços
                                        </h5>

                                        <button class="btn admin-btn-save btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalServicos">
                                            <i class="fa-solid fa-file-pen me-1"></i>Editar
                                        </button>
                                    </div>

                                    <p><strong>Conteúdo editável:</strong></p>
                                    <p>- Título</p>
                                    <p>- Cards com ícone, título e descrição</p>

                                    <p><strong>Última atualização:</strong></p>
                                    <p>02/04/2026</p>

                                </div>
                            </div>
                        </div>

                        <!-- Contactos -->
                        <div class="col-lg-5 col-md-6">
                            <div class="card admin-card shadow rounded h-100">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="detail-section-title mb-0">
                                            <i class="fa-solid fa-address-book me-2"></i>Secção Contacto
                                        </h5>

                                        <button class="btn admin-btn-save btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalContactos">
                                            <i class="fa-solid fa-file-pen me-1"></i>Editar
                                        </button>
                                    </div>

                                    <p><strong>Conteúdo editável:</strong></p>
                                    <p>- Título</p>
                                    <p>- Texto introdutório</p>
                                    <p>- Subtítulos</p>
                                    <p>- Botões</p>

                                    <p><strong>Última atualização:</strong></p>
                                    <p>02/04/2026</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rodapé -->
                        <div class="col-lg-5 col-md-6">
                            <div class="card admin-card shadow rounded h-100">
                                <div class="card-body">

                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="detail-section-title mb-0">
                                            <i class="fa-solid fa-window-maximize me-2"></i>Secção Rodapé
                                        </h5>

                                        <button class="btn admin-btn-save btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalRodape">
                                            <i class="fa-solid fa-file-pen me-1"></i>Editar
                                        </button>
                                    </div>

                                    <p><strong>Conteúdo editável:</strong></p>
                                    <p>- Localização</p>
                                    <p>- Horário</p>
                                    <p>- Contactos</p>

                                    <p><strong>Última atualização:</strong></p>
                                    <p>02/04/2026</p>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Bem-vindo -->
                        <div class="modal fade" id="modalBemVindo" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Secção Bem-vindo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-3" value="Bem-vindo à Stay This.Positive">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control" rows="4">"Inventário inteligente, saúde para toda a gente"</textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn admin-btn-save">Guardar alterações</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Sobre Nós -->
                        <div class="modal fade" id="modalSobreNos" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Secção Sobre Nós</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-3" value="Quem somos?">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="6">A Stay This.Positive é uma empresa dedicada à gestão de inventário hospitalar de equipamentos médicos. Disponibilizamos uma plataforma organizada, intuitiva e atualizada para consulta de informação relativa aos equipamentos médicos existentes. Através da nossa plataforma, é possível obter informações sobre fornecedores, localizações, documentação técnica, garantias e contratos associados a cada equipamento. Com a Stay This.Positive, nunca estará perdido!</textarea>

                                        <label class="form-label">Botão</label>
                                        <input type="text" class="form-control mb-3" value="Contacte-nos">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn admin-btn-save">Guardar alterações</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Serviços -->
                        <div class="modal fade" id="modalServicos" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Secção Serviços</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-3" value="Os nossos serviços">

                                        <h5 class="modal-group-title">Serviço 1</h5>

                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control mb-2" value="fa-solid fa-laptop-medical">

                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-2" value="Equipamentos">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="2">Consulte informações sobre os equipamentos e o seu estado atual</textarea>

                                        <hr>

                                        <h5 class="modal-group-title">Serviço 2</h5>

                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control mb-2" value="fa-solid fa-truck-medical">

                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-2" value="Fornecedores">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="2">Descubra os fornecedores responsáveis pela distribuição dos nossos equipamentos</textarea>

                                        <hr>

                                        <h5 class="modal-group-title">Serviço 3</h5>

                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control mb-2" value="fa-solid fa-house-medical-flag">

                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-2" value="Localizações">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="2">Localize de forma rápida qualquer equipamento nas nossas instalações</textarea>

                                        <hr>

                                        <h5 class="modal-group-title">Serviço 4</h5>

                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control mb-2" value="fa-solid fa-clipboard-user">

                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-2" value="Documentação técnica">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="2">Aceda a manuais e documentação técnica dos nossos equipamentos</textarea>

                                        <hr>

                                        <h5 class="modal-group-title">Serviço 5</h5>

                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control mb-2" value="fa-solid fa-receipt">

                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-2" value="Garantias e Contratos">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="2">Consulte as garantias e contratos associados a cada equipamento</textarea>

                                        <hr>

                                        <h5 class="modal-group-title">Serviço 6</h5>

                                        <label class="form-label">Ícone</label>
                                        <input type="text" class="form-control mb-2" value="fa-solid fa-file-waveform">

                                        <label class="form-label">Título</label>
                                        <input type="text" class="form-control mb-2" value="Dashboard">

                                        <label class="form-label">Descrição</label>
                                        <textarea class="form-control mb-3" rows="2">Acompanhe dados relevantes e obtenha uma visão geral sobre o nosso inventário</textarea>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn admin-btn-save">Guardar alterações</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Contactos -->
                        <div class="modal fade" id="modalContactos" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Contactos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <label class="form-label">Título</label>
                                        <input type="email" class="form-control mb-3" value="Contacto">

                                        <label class="form-label">Texto introdutório</label>
                                        <input type="text" class="form-control mb-3" value="Entre em contacto connosco para esclarecer qualquer dúvida. Estaremos aqui para ajudar!">

                                        <label class="form-label">Subtítulo 1</label>
                                        <input type="text" class="form-control mb-3" value="Nome:">

                                        <label class="form-label">Subtítulo 2</label>
                                        <input type="text" class="form-control mb-3" value="Email:">

                                        <label class="form-label">Subtítulo 3</label>
                                        <input type="text" class="form-control mb-3" value="Mensagem:">

                                        <label class="form-label">Botão</label>
                                        <input type="text" class="form-control mb-3" value="Enviar">
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn admin-btn-save">Guardar alterações</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Rodapé -->
                        <div class="modal fade" id="modalRodape" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Rodapé</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">

                                        <label class="form-label">Título 1</label>
                                        <input type="text" class="form-control mb-3" value="Localização">

                                        <label class="form-label">Rua</label>
                                        <input type="text" class="form-control mb-3" value="Rua dos Engenheiros nº24">

                                        <label class="form-label">Código postal</label>
                                        <input type="text" class="form-control mb-3" value="4920-327, Viana do Castelo">

                                        <label class="form-label">País</label>
                                        <input type="text" class="form-control mb-3" value="Portugal">

                                        <hr>

                                        <label class="form-label">Título 2</label>
                                        <input type="text" class="form-control mb-3" value="Horário">

                                        <label class="form-label">Dias úteis</label>
                                        <input type="text" class="form-control mb-3" value="Dias úteis (2º a 6º feira): 8h - 20h">

                                        <label class="form-label">Sábado e feriados</label>
                                        <input type="text" class="form-control mb-3" value="Sábado e Feriados: 8h - 13h">

                                        <label class="form-label">Domingo</label>
                                        <input type="text" class="form-control mb-3" value="Domingo: Encerrado">

                                        <hr>

                                        <label class="form-label">Título 3</label>
                                        <input type="text" class="form-control mb-3" value="Contactos">

                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control mb-3" value="Email: StayThis.Positive@gmail.com">

                                        <label class="form-label">Telefone</label>
                                        <input type="text" class="form-control mb-3" value="Telefone: 251 811 722">

                                        <label class="form-label">Instagram</label>
                                        <input type="text" class="form-control mb-3" value="Instagram: StayThis.Positive">

                                        <label class="form-label">Facebook</label>
                                        <input type="text" class="form-control mb-3" value="Facebook: StayThis.Positive">

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn admin-btn-save">Guardar alterações</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

<?php include '../../includes/footer.php'; ?>