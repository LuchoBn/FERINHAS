<?php
include 'includes/header.php';
include 'includes/conexao.php';

echo "<div style='max-width:600px; margin:50px auto; padding:20px; border:1px solid #ccc; border-radius:10px; text-align:center;'>";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Busca artesão com o token
    $stmt = $conn->prepare("SELECT id_artesao, confirmado FROM artesao WHERE token_confirmacao = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $confirmado);
        $stmt->fetch();

        if ($confirmado) {
            echo "<h2 style='color: #009688;'>E-mail já confirmado!</h2>";
            echo "<p>Você já confirmou anteriormente. Pode fazer login normalmente.</p>";
        } else {
            // Confirma o e-mail
            $update = $conn->prepare("UPDATE artesao SET confirmado = 1 WHERE id_artesao = ?");
            $update->bind_param("i", $id);
            if ($update->execute()) {
                echo "<h2 style='color: green;'>E-mail confirmado com sucesso!</h2>";
                echo "<p>Agora você pode acessar sua conta normalmente.</p>";
                echo "<a href='login.php'><button style='margin-top:20px; padding:10px 20px; background:#009688; color:white; border:none; border-radius:20px;'>Ir para login</button></a>";
            } else {
                echo "<h2 style='color: red;'>Erro ao confirmar e-mail.</h2>";
            }
            $update->close();
        }
    } else {
        echo "<h2 style='color: red;'>Token inválido ou expirado.</h2>";
    }

    $stmt->close();
} else {
    echo "<h2 style='color: red;'>Token ausente.</h2>";
}

echo "</div>";
include 'includes/footer.php';
?>
