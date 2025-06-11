<?php
require_once 'carregar_env.php';
carregarEnv(__DIR__ . '/brevo.env'); 

function enviarEmailConfirmacao($emailDestino, $nome, $token) {
    $apiKey = getenv('BREVO_API_KEY');  

    $data = [
        'sender' => ['name' => 'Litoral Arte', 'email' => 'litoral.art.sp@gmail.com'],
        'to' => [['email' => $emailDestino, 'name' => $nome]],
        'subject' => 'Confirme seu cadastro',
        'htmlContent' => "<p>Olá, $nome!</p>
                          <p>Obrigado por se cadastrar. Para confirmar seu e-mail, clique no link abaixo:</p>
                          <p><a href='http://hippie.ct.ws/confirmar.php?token=$token'>Confirmar e-mail</a></p>"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.brevo.com/v3/smtp/email');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [ //1930
        'accept: application/json',
        'api-key: ' . $apiKey,
        'content-type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 201) {
        return true;
    } else {
        error_log("Erro ao enviar e-mail: $response");
        return false;
    }
}
?>
