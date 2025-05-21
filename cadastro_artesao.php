<?php include 'includes/header.php'; include 'includes/conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO artesao (nome_artesao, email_artesao, senha_artesao, descricao_artesao, telefone_artesao, localizacao_artesao)
    VALUES ('{$_POST['nome']}', '{$_POST['email']}', '{$_POST['senha']}', '{$_POST['descricao']}', '{$_POST['telefone']}', '{$_POST['localizacao']}')";
    $conn->query($sql);
    echo '<p class="cadastro-ok">Cadastro realizado!</p>';
}
?>
<h2 class="menu">Cadastro de Artesão</h2>
<form method='POST' style='text-align:center;'>
    <input name='nome' placeholder='Nome'><br><br>
    <input name='email' type='email' placeholder='Email'><br><br>
    <input name='senha' type='password' placeholder='Senha'><br><br>
    <input name='descricao' placeholder='Descrição'><br><br>
    <input name='telefone' placeholder='Telefone'><br><br>
    <input name='localizacao' placeholder='Localização'><br><br>
    <button type='submit'>Cadastrar</button>
</form>
<?php include 'includes/footer.php'; ?>