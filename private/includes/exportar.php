<?php

function obter_dados_exportacao(PDO $ligacao, string $tipo): array
{
    switch ($tipo) {
        case 'equipamentos':
            $sql = "
                SELECT 
                    e.nome,
                    e.codigo_interno,
                    e.numero_serie,
                    e.marca,
                    e.modelo,
                    e.fabricante,
                    c.categoria,
                    ee.estado,
                    cr.criticidade,
                    l.servico_departamento
                FROM equipamentos e
                LEFT JOIN categorias c ON e.id_categoria = c.id_categoria
                LEFT JOIN estados_equipamento ee ON e.id_estado = ee.id_estado
                LEFT JOIN criticidades cr ON e.id_criticidade = cr.id_criticidade
                LEFT JOIN localizacoes l ON e.id_localizacao = l.id_localizacao
                ORDER BY e.nome
            ";
            break;

        case 'documentacao':
            $sql = "
                SELECT 
                    d.codigo_documento,
                    td.tipo_documento,
                    e.nome AS equipamento,
                    d.nome_localizacao_documento,
                    d.ficheiro,
                    d.data_emissao,
                    d.data_validade
                FROM documentos d
                LEFT JOIN tipos_documento td ON d.id_tipo_documento = td.id_tipo_documento
                LEFT JOIN equipamentos e ON d.id_equipamento = e.id_equipamento
                ORDER BY d.codigo_documento
            ";
            break;

        case 'fornecedores':
            $sql = "
                SELECT 
                    f.codigo,
                    f.nome_empresa,
                    tf.tipo_fornecedor,
                    f.nif,
                    f.contacto_empresa,
                    f.email,
                    f.website,
                    f.pessoa_contacto,
                    f.telefone_contacto
                FROM fornecedores f
                LEFT JOIN tipos_fornecedor tf ON f.id_tipo_fornecedor = tf.id_tipo_fornecedor
                ORDER BY f.codigo
            ";
            break;

        case 'localizacoes':
            $sql = "
                SELECT 
                    codigo,
                    edificio,
                    piso,
                    servico_departamento,
                    acesso,
                    sala_gabinete,
                    responsavel
                FROM localizacoes
                ORDER BY codigo
            ";
            break;

        case 'garantias':
            $sql = "
                SELECT 
                    gc.codigo_garantia,
                    e.nome AS equipamento,
                    gc.data_inicio,
                    gc.data_fim,
                    eg.estado_garantia,
                    gc.existe_contrato,
                    tc.tipo_contrato,
                    p.periodicidade,
                    gc.entidade_responsavel
                FROM garantias_contratos gc
                LEFT JOIN equipamentos e ON gc.id_equipamento = e.id_equipamento
                LEFT JOIN estados_garantia eg ON gc.id_estado_garantia = eg.id_estado_garantia
                LEFT JOIN tipos_contrato tc ON gc.id_tipo_contrato = tc.id_tipo_contrato
                LEFT JOIN periodicidade p ON gc.id_periodicidade = p.id_periodicidade
                ORDER BY gc.codigo_garantia
            ";
            break;

        default:
            return [];
    }

    return $ligacao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function exportar_csv(array $dados, string $nome_ficheiro): void
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $nome_ficheiro . '.csv');

    $output = fopen('php://output', 'w');

    if (!empty($dados)) {
        fputcsv($output, array_keys($dados[0]), ';');

        foreach ($dados as $linha) {
            fputcsv($output, $linha, ';');
        }
    }

    fclose($output);
    exit;
}

function exportar_json(array $dados, string $nome_ficheiro): void
{
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename=' . $nome_ficheiro . '.json');

    echo json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function exportar_pdf(array $dados, string $titulo): void
{
    ?>
    <!DOCTYPE html>
    <html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($titulo) ?></title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            h1 { text-align: center; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #333; padding: 6px; }
            th { background-color: #eee; }
            @media print {
                button { display: none; }
            }
        </style>
    </head>
    <body>

        <button onclick="window.print()">Guardar como PDF</button>

        <h1><?= htmlspecialchars($titulo) ?></h1>

        <?php if (empty($dados)): ?>
            <p>Sem dados para exportar.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <?php foreach (array_keys($dados[0]) as $coluna): ?>
                            <th><?= htmlspecialchars($coluna) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($dados as $linha): ?>
                        <tr>
                            <?php foreach ($linha as $valor): ?>
                                <td><?= htmlspecialchars((string) $valor) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </body>
    </html>
    <?php
    exit;
}