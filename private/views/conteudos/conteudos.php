<?php
// --------------------------------------------------------------------
// SEGURANÇA: Proteção de acesso à página 
// Este ficheiro deve ser acedido apenas por utilizadores autenticados.
// Caso não exista sessão iniciada, o utilizador será redirecionado para o login.
// --------------------------------------------------------------------
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged(); // Inicia a sessão (se necessário) e verifica se o utilizador está autenticado

$mensagens = [];
$erro_mensagens = '';

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

    $comando = $ligacao->query("
        SELECT *
        FROM mensagens_contacto
        ORDER BY data_envio DESC
    ");

    $mensagens = $comando->fetchAll(PDO::FETCH_OBJ);
    $bem_vindo = $ligacao->query("SELECT * FROM bem_vindo_publico WHERE id_bem_vindo = 1")->fetch(PDO::FETCH_OBJ);
    $sobre_nos = $ligacao->query("SELECT * FROM sobre_nos_publico WHERE id_sobre_nos = 1")->fetch(PDO::FETCH_OBJ);
    $secao_servicos = $ligacao->query("SELECT * FROM secao_servicos_publico WHERE id_secao_servicos = 1")->fetch(PDO::FETCH_OBJ);
    $servicos = $ligacao->query("
        SELECT *
        FROM servicos_publico
        ORDER BY ordem ASC
    ")->fetchAll(PDO::FETCH_OBJ);
    $contactos = $ligacao->query("SELECT * FROM contactos_publico WHERE id_contacto = 1")->fetch(PDO::FETCH_OBJ);
    $rodape = $ligacao->query("SELECT * FROM rodape_publico WHERE id_rodape = 1")->fetch(PDO::FETCH_OBJ);

} catch (PDOException $err) {
    $erro_mensagens = 'Erro ao carregar as mensagens recebidas.';
    $bem_vindo = null;
    $sobre_nos = null;
    $secao_servicos = null;
    $servicos = [];
    $contactos = null;
    $rodape = null;
    }

$ligacao = null;
?>

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

                    <h4 class="detail-section-title mt-4"><i class="fa-solid fa-envelope me-2"></i>Visualize as mensagens recebidas</h4>
                    <div class="card admin-card shadow rounded mb-5">
                        <div class="card-body">

                            <?php if (!empty($erro_mensagens)) : ?>
                                <p class="text-danger"><?= htmlspecialchars($erro_mensagens) ?></p>

                            <?php elseif (count($mensagens) == 0) : ?>
                                <p class="text-muted mb-0">Ainda não existem mensagens recebidas.</p>

                            <?php else : ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-header">
                                            <tr>
                                                <th>Data</th>
                                                <th>Nome</th>
                                                <th>Email</th>
                                                <th>Mensagem</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach ($mensagens as $mensagem) : ?>
                                                <tr>
                                                    <td><?= date('d/m/Y H:i', strtotime($mensagem->data_envio)) ?></td>
                                                    <td><?= htmlspecialchars($mensagem->nome) ?></td>
                                                    <td><?= htmlspecialchars($mensagem->email) ?></td>
                                                    <td><?= nl2br(htmlspecialchars($mensagem->mensagem)) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h4 class="detail-section-title mt-4"><i class="fa-solid fa-globe me-2"></i>Atualize os conteúdos apresentados na área pública do website</h4>

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
                                    <p><?= !empty($bem_vindo->data_ultima_atualizacao) ? date('d/m/Y', strtotime($bem_vindo->data_ultima_atualizacao)) : 'Sem atualização' ?></p>

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
                                    <p><?= !empty($sobre_nos->data_ultima_atualizacao) ? date('d/m/Y', strtotime($sobre_nos->data_ultima_atualizacao)) : 'Sem atualização' ?></p>

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
                                    <p><?= !empty($secao_servicos->data_ultima_atualizacao) ? date('d/m/Y', strtotime($secao_servicos->data_ultima_atualizacao)) : 'Sem atualização' ?></p>

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
                                    <p><?= !empty($contactos->data_ultima_atualizacao) ? date('d/m/Y', strtotime($contactos->data_ultima_atualizacao)) : 'Sem atualização' ?></p>
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
                                    <p><?= !empty($rodape->data_ultima_atualizacao) ? date('d/m/Y', strtotime($rodape->data_ultima_atualizacao)) : 'Sem atualização' ?></p>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Bem-vindo -->
                        <div class="modal fade" id="modalBemVindo" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="processa_conteudos.php" method="post">
                                        <input type="hidden" name="secao" value="bem_vindo">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Secção Bem-vindo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="form-label">Título</label>
                                            <input type="text" name="titulo" class="form-control mb-3" value="<?= htmlspecialchars($bem_vindo->titulo ?? '') ?>">

                                            <label class="form-label">Descrição</label>
                                            <textarea name="descricao" class="form-control" rows="4"><?= htmlspecialchars($bem_vindo->descricao ?? '') ?></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn admin-btn-save">Guardar alterações</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Sobre Nós -->
                        <div class="modal fade" id="modalSobreNos" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="processa_conteudos.php" method="post">
                                        <input type="hidden" name="secao" value="sobre_nos">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Secção Sobre Nós</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="form-label">Título</label>
                                            <input type="text" name="titulo" class="form-control mb-3" value="<?= htmlspecialchars($sobre_nos->titulo ?? '') ?>">

                                            <label class="form-label">Descrição</label>
                                            <textarea name="descricao" class="form-control mb-3" rows="6"><?= htmlspecialchars($sobre_nos->descricao ?? '') ?></textarea>
                                            
                                            <label class="form-label">Botão</label>
                                            <input type="text" name="texto_botao" class="form-control mb-3" value="<?= htmlspecialchars($sobre_nos->texto_botao ?? '') ?>">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn admin-btn-save">Guardar alterações</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Serviços -->
                        <div class="modal fade" id="modalServicos" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="processa_conteudos.php" method="post">
                                        <input type="hidden" name="secao" value="servicos">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Secção Serviços</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="form-label">Título</label>
                                            <input type="text" name="titulo_secao" class="form-control mb-3" value="<?= htmlspecialchars($secao_servicos->titulo ?? '') ?>">

                                            <?php foreach ($servicos as $servico) : ?>
                                                <h5 class="modal-group-title">Serviço <?= htmlspecialchars($servico->ordem) ?></h5>

                                                <label class="form-label">Ícone</label>
                                                <input type="text" name="servicos[<?= $servico->id_servico ?>][icone]" class="form-control mb-2" value="<?= htmlspecialchars($servico->icone ?? '') ?>">

                                                <label class="form-label">Título</label>
                                                <input type="text" name="servicos[<?= $servico->id_servico ?>][titulo]" class="form-control mb-2" value="<?= htmlspecialchars($servico->titulo ?? '') ?>">

                                                <label class="form-label">Descrição</label>
                                                <textarea name="servicos[<?= $servico->id_servico ?>][descricao]" class="form-control mb-3" rows="2"><?= htmlspecialchars($servico->descricao ?? '') ?></textarea>

                                                <hr>
                                            <?php endforeach; ?>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn admin-btn-save">Guardar alterações</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Contactos -->
                        <div class="modal fade" id="modalContactos" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="processa_conteudos.php" method="post">
                                        <input type="hidden" name="secao" value="contactos">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Contactos</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="form-label">Título</label>
                                            <input type="text" name="titulo" class="form-control mb-3" value="<?= htmlspecialchars($contactos->titulo ?? '') ?>">

                                            <label class="form-label">Texto introdutório</label>
                                            <input type="text" name="texto_introdutorio" class="form-control mb-3" value="<?= htmlspecialchars($contactos->texto_introdutorio ?? '') ?>">

                                            <label class="form-label">Subtítulo 1</label>
                                            <input type="text" name="subtitulo_nome" class="form-control mb-3" value="<?= htmlspecialchars($contactos->subtitulo_nome ?? '') ?>">

                                            <label class="form-label">Subtítulo 2</label>
                                            <input type="text" name="subtitulo_email" class="form-control mb-3" value="<?= htmlspecialchars($contactos->subtitulo_email ?? '') ?>">

                                            <label class="form-label">Subtítulo 3</label>
                                            <input type="text" name="subtitulo_mensagem" class="form-control mb-3" value="<?= htmlspecialchars($contactos->subtitulo_mensagem ?? '') ?>">

                                            <label class="form-label">Botão</label>
                                            <input type="text" name="texto_botao" class="form-control mb-3" value="<?= htmlspecialchars($contactos->texto_botao ?? '') ?>">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn admin-btn-save">Guardar alterações</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- Modal Rodapé -->
                        <div class="modal fade" id="modalRodape" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form action="processa_conteudos.php" method="post">
                                        <input type="hidden" name="secao" value="rodape">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Rodapé</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="form-label">Título 1</label>
                                            <input type="text" name="titulo_1" class="form-control mb-3" value="<?= htmlspecialchars($rodape->titulo_1 ?? '') ?>">

                                            <label class="form-label">Rua</label>
                                            <input type="text" name="rua" class="form-control mb-3" value="<?= htmlspecialchars($rodape->rua ?? '') ?>">

                                            <label class="form-label">Código postal</label>
                                            <input type="text" name="codigo_postal" class="form-control mb-3" value="<?= htmlspecialchars($rodape->codigo_postal ?? '') ?>">

                                            <label class="form-label">País</label>
                                            <input type="text" name="pais" class="form-control mb-3" value="<?= htmlspecialchars($rodape->pais ?? '') ?>">

                                            <hr>

                                            <label class="form-label">Título 2</label>
                                            <input type="text" name="titulo_2" class="form-control mb-3" value="<?= htmlspecialchars($rodape->titulo_2 ?? '') ?>">

                                            <label class="form-label">Dias úteis</label>
                                            <input type="text" name="dias_uteis" class="form-control mb-3" value="<?= htmlspecialchars($rodape->dias_uteis ?? '') ?>">

                                            <label class="form-label">Sábado e feriados</label>
                                            <input type="text" name="sabado_feriados" class="form-control mb-3" value="<?= htmlspecialchars($rodape->sabado_feriados ?? '') ?>">

                                            <label class="form-label">Domingo</label>
                                            <input type="text" name="domingo" class="form-control mb-3" value="<?= htmlspecialchars($rodape->domingo ?? '') ?>">

                                            <hr>

                                            <label class="form-label">Título 3</label>
                                            <input type="text" name="titulo_3" class="form-control mb-3" value="<?= htmlspecialchars($rodape->titulo_3 ?? '') ?>">

                                            <label class="form-label">Email</label>
                                            <input type="text" name="email" class="form-control mb-3" value="<?= htmlspecialchars($rodape->email ?? '') ?>">

                                            <label class="form-label">Telefone</label>
                                            <input type="text" name="telefone" class="form-control mb-3" value="<?= htmlspecialchars($rodape->telefone ?? '') ?>">

                                            <label class="form-label">Instagram</label>
                                            <input type="text" name="instagram" class="form-control mb-3" value="<?= htmlspecialchars($rodape->instagram ?? '') ?>">

                                            <label class="form-label">Facebook</label>
                                            <input type="text" name="facebook" class="form-control mb-3" value="<?= htmlspecialchars($rodape->facebook ?? '') ?>">
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn admin-btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn admin-btn-save">Guardar alterações</button>
                                        </div>
                                    </form>

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