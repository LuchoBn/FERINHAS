<?php
session_start();
include 'includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email_cliente'];
    $senha = $_POST['senha_cliente'];

    $sql = "SELECT nome_cliente FROM cliente WHERE email_cliente = '$email' AND senha_cliente = '$senha'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['nome_cliente'] = explode(' ', $row['nome_cliente'])[0];
        header("Location: index.php");
        exit();
    } else {
        echo "Login inválido.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<h2 class="menu">Login</h2>
<form method='POST' style='text-align:center;'>
    <input type='email' name='email_cliente' placeholder='Email' required><br><br>
    <input type='password' name='senha_cliente' placeholder='Senha' required><br><br>
    <button type='submit'>Entrar</button>
</form>
<div class="cadastro-link">
  <p>Não tem conta? <a href="cadastro_artesao.php">Cadastre-se como artesão</a></p>
</div>
<?php include 'includes/footer.php'; ?>