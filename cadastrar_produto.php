<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

$id_artesao = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o usuário está logado
if (!isset($_SESSION['nome_artesao'])) {
    echo "<p>Você precisa estar logado para cadastrar um produto.</p>";
    include 'includes/footer.php';
    exit;
}

// Processa o cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_produto = $_POST['nome_produto'];
    $descricao_produto = $_POST['descricao_produto'];
    $preco_produto = floatval($_POST['preco_produto']);
    $imagem = 'img/ex1.png'; // imagem padrão

    $sql = "INSERT INTO produto (id_artesao, nome_produto, descricao_produto, preco_produto, imagem)
            VALUES ($id_artesao, '$nome_produto', '$descricao_produto', $preco_produto, '$imagem')";
    if ($conn->query($sql) === TRUE) {
        header("Location: perfil_artesao.php?id=$id_artesao");
        exit;
    } else {
        echo "<p>Erro ao cadastrar produto: " . $conn->error . "</p>";
    }
}
?>

<div class="form-container">
    <h2 class="menu">Cadastrar Produto</h2>
    <form method="POST" class="form-produto">
        <label>Nome do Produto:</label><br>
        <input type="text" name="nome_produto" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao_produto" required></textarea><br><br>

        <label>Preço (R$):</label><br>
        <input type="number" name="preco_produto" step="0.01" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
