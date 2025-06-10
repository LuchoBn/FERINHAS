<?php
function enviarEmailConfirmacao($emailDestino, $nome, $token) {
    $apiKey = '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';  // Substitua pela sua chave API do Brevo

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
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
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
