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
                            <form action="" method="post">
                                <!-- User -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Utilizador</label>
                                    
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>
                                </div> 
                                
                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Palavra-passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control">
                                        <span class="input-group-text toggle-password" onclick="togglePassword()">
                                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                        </span>
                                    </div>
                                </div> 

                                <p class="text-center mt-3">
                                    <a href ="#" class="forgot-password">Esqueceu-se da palavra-passe?</a>       
                                </p>

                                <div class="mb-3 text-center">
                                    <!-- Voltar à página inicial -->
                                    <a href="/sibdas/1241327/Projeto_SIBDAS_/public/index.php" class="btn custom-btn-secondary px-4">Voltar<i class="fa-solid fa-rotate-left ms-2"></i></a>
                                    <!-- Submit -->
                                    <button type="submit" class="btn custom-btn-secondary px-4">Entrar <i class="fa-solid fa-right-to-bracket ms-2"></i></button>

                                </div> 

                                <div class="alert alert-danger p-2 text-center d-none">
                                    <!-- Error messagem -->
                                    Erro: Utilizador ou palavra-passe inválidos
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="../../assets/js/1241327.js"></script>
    
<?php include '../includes/footer.php'; ?>