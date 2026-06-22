<?php
// Inicia a sessão (necessário para usar $_SESSION)
session_start();
// Inicializa a variável que irá conter os erros de validação
$validation_errors = [];

// --------------------------------------------------------------------
// RECOLHA DE MENSAGENS TEMPORÁRIAS DA SESSÃO
// --------------------------------------------------------------------

if (!empty($_SESSION['validation_errors'])) { // Verifica se existem erros de validação guardados na sessão
    $validation_errors = $_SESSION['validation_errors']; // Se existirem, copia-os para a variável local
    unset($_SESSION['validation_errors']); // Remove os erros da sessão para que não apareçam novamente numa recarga de página
}

$server_error = []; // Inicializa a variável que irá conter erros de servidor

if (!empty($_SESSION['server_error'])) { // Verifica se existe algum erro de servidor guardado na sessão
    $server_error = $_SESSION['server_error']; // Se existir, copia-o para a variável local
    unset($_SESSION['server_error']); // Remove o erro da sessão após ser lido
}
?>

<?php
$body_class = 'login-page';
include '../includes/header.php';
?> 

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9 col-11">
                <!-- Borda do formulário --> 
                <div class="card p-4">
                    <div>
                        <div class="position-relative mb-4">
                            <!-- Ícone do utilizador -->
                            <div class="login-icon"><i class="fa-solid fa-user"></i></div>
                            
                            <!-- Título -->
                            <h2 class="text-center"><strong>Login</strong></h2>
                        </div> 
                    </div>  
                    
                    <div class="row">
                        <div class="col">
                            <!-- Formulário -->
                            <form name="formulario" action="processa_login.php" method="post">
                                <!-- User -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Utilizador</label>
                                    
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        <input type="email" name="text_username" id="email" class="form-control">
                                    </div>
                                </div> 
                                
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Palavra-passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="text_password" id="password" class="form-control">
                                        <span class="input-group-text toggle-password" onclick="togglePassword()">
                                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                </div> 
                                
                                
                                <!-- Botões de preenchimento automático -->
                                 <!--
                                <div class="mt-4 mb-2 text-center">
                                    <button type="button" id="preencher_admin"
                                        class="btn btn-sm px-3 py-2 me-2 rounded-pill btn-outline-light">
                                        <i class="fa-solid fa-user-shield me-1"></i> Admin
                                    </button>

                                    <button type="button" id="preencher_tecnico"
                                        class="btn btn-sm px-3 py-2 me-2 rounded-pill btn-outline-light">
                                        <i class="fa-solid fa-screwdriver-wrench me-1"></i> Técnico
                                    </button>

                                    <button type="button" id="preencher_saude"
                                        class="btn btn-sm px-3 py-2 rounded-pill btn-outline-light">
                                        <i class="fa-solid fa-user-doctor me-1"></i> Prof. Saúde
                                    </button>
                                </div>
                                -->
                            

                                <div class="mb-3 text-center">
                                    <!-- Voltar à página inicial -->
                                    <a href="/sibdas/1241327/stay-this-positive/public/index.php" class="btn custom-btn-secondary px-4">Voltar<i class="fa-solid fa-rotate-left ms-2"></i></a>
                                    <!-- Submit -->
                                    <button type="submit" class="btn custom-btn-secondary px-4">Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i></button>
                                </div> 


                                <!-- -------------------------------------------------------------------- -->
                                <!-- APRESENTAÇÃO DE MENSAGENS DE ERRO (VALIDAÇÃO E SERVIDOR) -->
                                <!-- -------------------------------------------------------------------- -->
                                
                                <!-- Verifica se existem erros de validação -->
                                <?php if (!empty($validation_errors)) : ?>
                                    <!-- Se existirem, apresenta um alerta de erro (vermelho) usando as classes do Bootstrap -->
                                    <div class="alert alert-danger p-2 text-center">
                                        <!-- Percorre todos os erros de validação -->
                                        <?php foreach ($validation_errors as $error) : ?>
                                        <!-- Mostra cada erro dentro de uma <div>, escapando caracteres especiais para segurança -->
                                        <div><?= htmlspecialchars($error) ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Verifica se existe um erro de servidor -->
                                <?php if (!empty($server_error)) : ?>
                                    <!-- Apresenta também num alerta de erro (vermelho) -->
                                    <div class="alert alert-danger p-2 text-center">
                                        <!-- Mostra o erro do servidor, também escapado com htmlspecialchars -->
                                        <div><?= htmlspecialchars($server_error) ?></div>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="../../assets/js/1241327.js"></script>

    <script>
    /*
    document.querySelector("#preencher_admin").addEventListener("click", () => {
        const formulario = document.forms["formulario"];
        formulario["text_username"].value = "admin@staythispositive.pt";
        formulario["text_password"].value = "admin123";
    });

    document.querySelector("#preencher_tecnico").addEventListener("click", () => {
        const formulario = document.forms["formulario"];
        formulario["text_username"].value = "tecnico@staythispositive.pt";
        formulario["text_password"].value = "tecnico123";
    });

    document.querySelector("#preencher_saude").addEventListener("click", () => {
        const formulario = document.forms["formulario"];
        formulario["text_username"].value = "profsaude@staythispositive.pt";
        formulario["text_password"].value = "profsaude123";
    });
    */
    </script>
    
<?php include '../includes/footer.php'; ?>