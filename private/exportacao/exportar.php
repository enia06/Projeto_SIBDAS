<?php
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../includes/exportar.php';

redirect_if_not_logged();

$tipo = $_GET['tipo'] ?? '';
$formato = $_GET['formato'] ?? '';

$tipos_permitidos = ['equipamentos', 'documentacao', 'fornecedores', 'localizacoes', 'garantias'];
$formatos_permitidos = ['csv', 'json', 'pdf'];

if (!in_array($tipo, $tipos_permitidos) || !in_array($formato, $formatos_permitidos)) {
    header('Location: ' . BASE_URL . '/private/indexpriv.php');
    exit;
}

$ligacao = new PDO(
    "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8mb4",
    MYSQL_USERNAME,
    MYSQL_PASSWORD
);

$dados = obter_dados_exportacao($ligacao, $tipo);

$nomes = [
    'equipamentos' => 'equipamentos',
    'documentacao' => 'documentacao',
    'fornecedores' => 'fornecedores',
    'localizacoes' => 'localizacoes',
    'garantias' => 'garantias'
];

$titulos = [
    'equipamentos' => 'Listagem de Equipamentos',
    'documentacao' => 'Listagem de Documentação',
    'fornecedores' => 'Listagem de Fornecedores',
    'localizacoes' => 'Listagem de Localizações',
    'garantias' => 'Listagem de Garantias'
];

switch ($formato) {
    case 'csv':
        exportar_csv($dados, $nomes[$tipo]);
        break;

    case 'json':
        exportar_json($dados, $nomes[$tipo]);
        break;

    case 'pdf':
        exportar_pdf($dados, $titulos[$tipo]);
        break;
}