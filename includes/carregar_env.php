<?php
function carregarEnv($caminho)
{
    if (!file_exists($caminho)) return;

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        if (strpos(trim($linha), '#') === 0) continue; // Ignora comentários
        list($chave, $valor) = explode('=', $linha, 2);
        $chave = trim($chave);
        $valor = trim($valor);
        putenv("$chave=$valor");
    }
}
?>
