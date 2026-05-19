<?php

header('Content-Type: application/json');

// Segurança simples (opcional)
$token = "SUA_CHAVE_SECRETA";

if (!isset($_GET['token']) || $_GET['token'] !== $token) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Acesso negado"
    ]);
    exit;
}

// Caminho do projeto
$projectPath = __DIR__;

// Comando git pull
$command = "cd {$projectPath} && git pull 2>&1";

$output = shell_exec($command);

// Verifica retorno
if (
    strpos(strtolower($output), 'already up to date') !== false ||
    strpos(strtolower($output), 'files changed') !== false ||
    strpos(strtolower($output), 'updating') !== false
) {

    echo json_encode([
        "success" => true,
        "message" => "Pull realizado com sucesso",
        "output" => $output
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Erro ao executar git pull",
        "output" => $output
    ]);
}
