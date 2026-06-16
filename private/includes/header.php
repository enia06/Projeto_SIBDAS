<?php
require_once __DIR__ . '/../../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/datatables.min.css">
    
    <!-- Bootstrap CSS & custom CSS -->
    <link rel="stylesheet" href="/sibdas/1241327/Projeto_SIBDAS_/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sibdas/1241327/Projeto_SIBDAS_/assets/css/1241327.css"> 

    <!-- Google Fonts -->     
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,300;0,700;1,400&display=swap" rel="stylesheet"> 

    <!-- Favicon -->
    <link rel="shortcut icon" href="/sibdas/1241327/Projeto_SIBDAS_/assets/img/logo branco.png" type="image/png">

    <!-- Fontawesome  -->
    <link rel="stylesheet" href="/sibdas/1241327/Projeto_SIBDAS_/assets/fontawesome/all.min.css">

    <!-- jQuery -->
    <script src="<?= BASE_URL ?>/assets/jquery-3.6.0.min.js"></script>

    <!-- DataTables -->
    <script src="<?= BASE_URL ?>/assets/datatables.min.js"></script>

</head>

<body class="<?php echo $body_class ?? ''; ?>">