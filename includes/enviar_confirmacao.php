<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclui as classes do PHPMailer manualmente
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

function enviarEmailConfirmacao($destinatario, $nome, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP do Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'litoral.arte.sp@gmail.com';  // seu e-mail
        $mail->Password   = 'xrva yxuc drnl brgr';         // senha de app do Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Remetente e destinatário
        $mail->setFrom('litoral.arte.sp@gmail.com', 'Feirinha Hippie');
        $mail->addAddress($destinatario, $nome);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de e-mail';

        // LINK DE CONFIRMAÇÃO – MUITO IMPORTANTE: troque pelo seu domínio real
        $link = "hippie.ct.ws/confirmar.php?token=$token";
        $mail->Body    = "Olá $nome, clique no link abaixo para confirmar seu e-mail:<br><a href='$link'>$link</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Para debugar você pode ativar o echo:
        // echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        return false;
    }
}
?>
