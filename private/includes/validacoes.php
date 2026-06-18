<?php

function validar_nome_equipamento(string $nome): array {
    $erros = [];

    if (empty(trim($nome))) {
        $erros[] = "O nome do equipamento é obrigatório.";
    }

    return $erros;
}