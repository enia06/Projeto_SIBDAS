<?php
// Inicia a sessão para poder usar a variável $_SESSION
session_start();

// ---------------------------------------------------------------------------
// SEGURANÇA: Impede o utilizador de aceder diretamente a este script
// Este ficheiro deve ser acedido apenas através de submissão de formulário 
// Se for acedido diretamente, será redirecionado para o login
// --------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
// Redireciona para o formulário de login (interface pública)
header('Location: /sibdas/1241327/Projeto_SIBDAS_/private/login/login.php');
// Encerra a execução do script imediatamente após o redirecionamento
return;
}

// --------------------------------------------------------------------
// RECOLHA DE DADOS DO FORMULÁRIO
// --------------------------------------------------------------------
// Verifica se o campo 'text_username' foi enviado via POST. Se sim, guarda-o na variável $username. Caso contrário, usa string vazia.
$username = isset($_POST['text_username']) ? $_POST['text_username'] : '';
// O mesmo para o campo da password.
$password = isset($_POST['text_password']) ? $_POST['text_password'] : '';


// --------------------------------------------------------------------
// VALIDAÇÃO DOS DADOS
// --------------------------------------------------------------------

// Inicializa um array vazio para guardar mensagens de erro de validação
$validation_errors = [];

// Verifica se o nome de utilizador (username) é um endereço de email válido
// Se não for, adiciona uma mensagem de erro ao array
if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $validation_errors[] = 'O username tem que ser um email válido.';
}

// Verifica se o nome de utilizador tem um comprimento entre 5 e 50 caracteres
// Isto evita usernames demasiado curtos ou excessivamente longos
if (strlen($username) < 5 || strlen($username) > 50) {
    $validation_errors[] = 'O username deve ter entre 5 e 50 caracteres.';
}

// Verifica se a password tem um comprimento entre 6 e 12 caracteres
// Garante uma password minimamente segura, mas fácil de recordar
if (strlen($password) < 6 || strlen($password) > 12) {
    $validation_errors[] = 'A password deve ter entre 6 e 12 caracteres.';
}

// Se existirem erros de validação, guarda-os na sessão
// Depois, redireciona o utilizador de volta para o formulário de login
if (!empty($validation_errors)) {
    $_SESSION['validation_errors'] = $validation_errors;
    
    // Redireciona para a página de login (ou outro formulário)
    header('Location: /sibdas/1241327/Projeto_SIBDAS_/private/login/login.php'); // ou 'login_form.php'
    
    // Encerra o script para impedir execução posterior
    return;
}

// --------------------------------------------------------------------
// SIMULAÇÃO DE RESULTADO DE LOGIN (antes da ligação real à base de dados)
// --------------------------------------------------------------------
// Simula o resultado que viria de uma verificação à base de dados
// Neste caso, assume-se que o login é válido (status = 1)
// Mais tarde, esta variável será substituída por um resultado real vindo da BD
$result['status'] = 1; // 1 = login válido, 0 = inválido

// Verifica se o status retornado indica login inválido
if (!$result['status']) {
    
    // Se o login for inválido, guarda uma mensagem de erro na sessão
    $_SESSION['server_error'] = 'Login inválido';
    
    // Redireciona o utilizador novamente para o formulário de login
    header('Location: /sibdas/1241327/Projeto_SIBDAS_/private/login/login.php'); // ou 'login_form.php'
    
    // Encerra o script para não continuar o processamento
    return;
}


// --------------------------------------------------------------------
// APRESENTAÇÃO DE DADOS ENVIADOS
// --------------------------------------------------------------------
echo "Utilizador: " . $username . "<br>";
echo "Password: " . $password;
?>

<?php
require_once __DIR__ . '/../config/config.php';
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/nav.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>

            <!-- Conteúdo Principal -->
            <main class="col-12 pt-3 px-4 ps-md-5">
                <div class="d-flex justify-content-center align-items-center mb-3">
                    <h2 class="mb-0 display-5 fw-bold" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.25);">
                        <i class=""></i><strong>Bem-vindo à área administrativa</strong>
                    </h2>
                </div>
                <p class="text-center fs-5 text-muted">Para explorar esta nova área de gestão de inventário hospitalar deve:</p>
                
                <div class="admin-card shadow-sm pt-4 px-4 pb-1 mx-auto mt-4 mb-4" style="max-width: 550px;">
                    <div class="mb-5 mt-3">
                        <h5 class="text-decoration-underline mb-3"><i class="fa-solid fa-bars fs-4 me-3" style="color:#602323"></i>1. Abrir o menu lateral</h5>
                        <p class="text-muted">Selecione o botão do menu para visualizar as funcionalidades disponíveis</p>
                    </div>
                    <div class="mb-5">
                        <h5 class="text-decoration-underline mb-3"><i class="fa-solid fa-folder-open fs-4 me-3" style="color:#602323"></i>2. Selecionar uma área</h5>
                        <p class="text-muted">Escolha a secção que pretende explorar</p>
                    </div>
                    <div class="mb-5">
                        <h5 class="text-decoration-underline mb-3"><i class="fa-solid fa-pen-to-square fs-4 me-3" style="color:#602323"></i>3. Gerir informações</h5>
                        <p class="text-muted">Adicione, edite ou consulte dados do inventário hospitalar</p>
                    </div>
                </div>
            </main> 
        </div>
    </div>

<?php include 'includes/footer.php'; ?>

    