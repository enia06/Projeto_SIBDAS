<?php
require_once __DIR__ . '/../includes/funcoes.php';
redirect_if_not_logged();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/nav.php'; ?>

<?php if (isset($_SESSION['success_message'])) : ?>
    <div class="alert alert-success">
        <?= $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['server_error'])) : ?>
    <div class="alert alert-danger">
        <?= $_SESSION['server_error']; ?>
    </div>
    <?php unset($_SESSION['server_error']); ?>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">

        <?php include '../includes/sidebar.php'; ?>

        <main class="col-12 pt-3 pb-5 px-5">
            <h2 class="text-center"><strong>Alterar palavra-passe</strong></h2>
            <hr>

            <div class="d-flex justify-content-center">
                <div class="card admin-card shadow rounded p-4 w-100" style="max-width: 600px;">
                    <form action="processa_password.php" method="post">

                        <div class="mb-3">
                            <label class="form-label d-block text-center">Palavra-passe atual</label>
                            <input type="password" name="password_atual" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block text-center">Nova palavra-passe</label>
                            <input type="password" name="nova_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block text-center">Confirmar nova palavra-passe</label>
                            <input type="password" name="confirmar_password" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a href="../indexpriv.php" class="btn admin-btn-cancel">
                                Cancelar
                            </a>

                            <button type="submit" class="btn admin-btn-save">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>