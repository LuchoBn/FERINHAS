<?php 
include 'includes/header.php'; 
include 'includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO artesao (nome_artesao, email_artesao, senha_artesao, descricao_artesao, telefone_artesao, localizacao_artesao)
    VALUES ('{$_POST['nome']}', '{$_POST['email']}', '{$_POST['senha']}', '{$_POST['descricao']}', '{$_POST['telefone']}', '{$_POST['localizacao']}')";
    $conn->query($sql);
    echo '<p class="cadastro-ok">Cadastro realizado com sucesso!</p>';
}
?>

<h2 class="menu">Cadastro de Artesão</h2>

<div class="form-container">
    <form method="POST" class="cadastro-form">
        <label for="nome">Nome:</label>
        <input id="nome" name="nome" type="text" required>

        <label for="email">Email:</label>
        <input id="email" name="email" type="email" required>

        <label for="senha">Senha:</label>
        <input id="senha" name="senha" type="password" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="3"></textarea>

        <label for="telefone">Telefone:</label>
        <input id="telefone" name="telefone" type="text">

        <label for="localizacao">Localização:</label>
        <input id="localizacao" name="localizacao" type="text">

        <button type="submit">Cadastrar</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
