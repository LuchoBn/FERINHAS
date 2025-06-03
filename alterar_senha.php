<?php
session_start();
include 'includes/conexao.php';
require_once 'includes/password.php';

// Verifica si el usuario está logueado
if (!isset($_SESSION['id_artesao'])) {
    header('Location: login.php');
    exit();
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirma_senha = $_POST['confirma_senha'];

    // Traer la contraseña actual de la BD
    $id = $_SESSION['id_artesao'];
    $stmt = $conn->prepare("SELECT senha_artesao FROM artesao WHERE id_artesao = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($senha_hash_bd);
    $stmt->fetch();
    $stmt->close();

    // Verificar senha atual
    if (!password_verify($senha_atual, $senha_hash_bd)) {
        $erro = "Senha atual incorreta.";
    } elseif ($nova_senha !== $confirma_senha) {
        $erro = "A confirmação da nova senha não coincide.";
    } else {
        // Hashear nova senha
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE artesao SET senha_artesao = ? WHERE id_artesao = ?");
        $stmt->bind_param("si", $nova_senha_hash, $id);
        if ($stmt->execute()) {
            $sucesso = "Senha alterada com sucesso!";
        } else {
            $erro = "Erro ao alterar a senha.";
        }
        $stmt->close();
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2 class="menu">Alterar Senha</h2>

<div class="form-container">
    <?php if ($erro): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php elseif ($sucesso): ?>
        <p style="color: green;"><?php echo $sucesso; ?></p>
    <?php endif; ?>

    <form method="POST" class="cadastro-form">
        <label for="senha_atual">Senha Atual:</label>
        <input type="password" id="senha_atual" name="senha_atual" required>

        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>

        <label for="confirma_senha">Confirmar Nova Senha:</label>
        <input type="password" id="confirma_senha" name="confirma_senha" required>

        <button type="submit">Alterar Senha</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
