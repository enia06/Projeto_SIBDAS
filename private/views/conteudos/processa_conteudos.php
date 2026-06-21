<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: conteudos.php');
    exit;
}

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

    $secao = $_POST['secao'] ?? '';

    if ($secao == 'bem_vindo') {
        $comando = $ligacao->prepare("
            UPDATE bem_vindo_publico
            SET titulo = :titulo,
                descricao = :descricao,
                data_ultima_atualizacao = NOW()
            WHERE id_bem_vindo = 1
        ");

        $comando->execute([
            ':titulo' => trim($_POST['titulo'] ?? ''),
            ':descricao' => trim($_POST['descricao'] ?? '')
        ]);
    }

    if ($secao == 'sobre_nos') {
        $comando = $ligacao->prepare("
            UPDATE sobre_nos_publico
            SET titulo = :titulo,
                descricao = :descricao,
                texto_botao = :texto_botao,
                data_ultima_atualizacao = NOW()
            WHERE id_sobre_nos = 1
        ");

        $comando->execute([
            ':titulo' => trim($_POST['titulo'] ?? ''),
            ':descricao' => trim($_POST['descricao'] ?? ''),
            ':texto_botao' => trim($_POST['texto_botao'] ?? '')
        ]);
    }

    if ($secao == 'contactos') {
        $comando = $ligacao->prepare("
            UPDATE contactos_publico
            SET titulo = :titulo,
                texto_introdutorio = :texto_introdutorio,
                subtitulo_nome = :subtitulo_nome,
                subtitulo_email = :subtitulo_email,
                subtitulo_mensagem = :subtitulo_mensagem,
                texto_botao = :texto_botao,
                data_ultima_atualizacao = NOW()
            WHERE id_contacto = 1
        ");

        $comando->execute([
            ':titulo' => trim($_POST['titulo'] ?? ''),
            ':texto_introdutorio' => trim($_POST['texto_introdutorio'] ?? ''),
            ':subtitulo_nome' => trim($_POST['subtitulo_nome'] ?? ''),
            ':subtitulo_email' => trim($_POST['subtitulo_email'] ?? ''),
            ':subtitulo_mensagem' => trim($_POST['subtitulo_mensagem'] ?? ''),
            ':texto_botao' => trim($_POST['texto_botao'] ?? '')
        ]);
    }

    if ($secao == 'rodape') {
        $comando = $ligacao->prepare("
            UPDATE rodape_publico
            SET titulo_1 = :titulo_1,
                rua = :rua,
                codigo_postal = :codigo_postal,
                pais = :pais,
                titulo_2 = :titulo_2,
                dias_uteis = :dias_uteis,
                sabado_feriados = :sabado_feriados,
                domingo = :domingo,
                titulo_3 = :titulo_3,
                email = :email,
                telefone = :telefone,
                instagram = :instagram,
                facebook = :facebook,
                data_ultima_atualizacao = NOW()
            WHERE id_rodape = 1
        ");

        $comando->execute([
            ':titulo_1' => trim($_POST['titulo_1'] ?? ''),
            ':rua' => trim($_POST['rua'] ?? ''),
            ':codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
            ':pais' => trim($_POST['pais'] ?? ''),
            ':titulo_2' => trim($_POST['titulo_2'] ?? ''),
            ':dias_uteis' => trim($_POST['dias_uteis'] ?? ''),
            ':sabado_feriados' => trim($_POST['sabado_feriados'] ?? ''),
            ':domingo' => trim($_POST['domingo'] ?? ''),
            ':titulo_3' => trim($_POST['titulo_3'] ?? ''),
            ':email' => trim($_POST['email'] ?? ''),
            ':telefone' => trim($_POST['telefone'] ?? ''),
            ':instagram' => trim($_POST['instagram'] ?? ''),
            ':facebook' => trim($_POST['facebook'] ?? '')
        ]);
    }

    if ($secao == 'servicos') {
        $comando = $ligacao->prepare("
            UPDATE secao_servicos_publico
            SET titulo = :titulo,
                data_ultima_atualizacao = NOW()
            WHERE id_secao_servicos = 1
        ");

        $comando->execute([
            ':titulo' => trim($_POST['titulo_secao'] ?? '')
        ]);

        foreach ($_POST['servicos'] ?? [] as $id_servico => $servico) {
            $comando = $ligacao->prepare("
                UPDATE servicos_publico
                SET icone = :icone,
                    titulo = :titulo,
                    descricao = :descricao,
                    data_ultima_atualizacao = NOW()
                WHERE id_servico = :id_servico
            ");

            $comando->execute([
                ':icone' => trim($servico['icone'] ?? ''),
                ':titulo' => trim($servico['titulo'] ?? ''),
                ':descricao' => trim($servico['descricao'] ?? ''),
                ':id_servico' => $id_servico
            ]);
        }
    }

    $_SESSION['success_message'] = 'Conteúdo atualizado com sucesso.';

} catch (PDOException $err) {
    $_SESSION['server_error'] = 'Erro ao atualizar o conteúdo.';
}

header('Location: conteudos.php');
exit;