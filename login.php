<?php
session_start();
include 'includes/conexao.php';
require_once 'includes/password.php';

$erro = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email_cliente']);
    $senha = $_POST['senha_cliente'];

    $sql = "SELECT id_artesao, nome_artesao, senha_artesao, role FROM artesao WHERE email_artesao = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar contraseña usando password_verify
        if (password_verify($senha, $row['senha_artesao'])) {
            $_SESSION['id_artesao'] = $row['id_artesao'];
            $_SESSION['nome_artesao'] = explode(' ', $row['nome_artesao'])[0];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
            exit();
        } else {
            $erro = "Email ou senha inválidos.";
        }
    } else {
        $erro = "Email ou senha inválidos.";
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2 class="menu">Login do Artesão</h2>

<div class="form-container">
    <?php if (!empty($erro)): ?>
        <p class="cadastro-ok" style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST" class="cadastro-form">
        <label for="email_cliente">Email:</label>
        <input type="email" id="email_cliente" name="email_cliente" required>

        <label for="senha_cliente">Senha:</label>
        <input type="password" id="senha_cliente" name="senha_cliente" required>

        <button type="submit">Entrar</button>
    </form>

    <p style="text-align:center; margin-top: 15px;">
        Não tem conta? <a href="cadastro_artesao.php">Cadastre-se como artesão</a>
    </p>
</div>

<?php include 'includes/footer.php'; ?>
