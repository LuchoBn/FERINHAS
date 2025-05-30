<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

$id_artesao = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!isset($_SESSION['nome_artesao'])) {
    echo "<p>Você precisa estar logado para cadastrar um produto.</p>";
    include 'includes/footer.php';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_produto      = ucfirst(strtolower(trim($_POST['nome_produto'])));
    $descricao_produto = ucfirst(strtolower(trim($_POST['descricao_produto'])));
    $preco_produto     = floatval($_POST['preco_produto']);

    $imagemNome = null;
    if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] == 0) {
        $ext        = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagemNome = uniqid('arte_') . ".{$ext}";
        move_uploaded_file(
            $_FILES['imagem']['tmp_name'], 
            'uploads/arte/' . $imagemNome
        );
    }
    else {
        $imagemNome = 'padrao_produto.png';
    }

    $sql = "INSERT INTO produto 
        (id_artesao, nome_produto, descricao_produto, preco_produto, imagem_produto)
     VALUES
        ($id_artesao, '{$nome_produto}', '{$descricao_produto}', {$preco_produto}, '{$imagemNome}')";

    if ($conn->query($sql) === TRUE) {
        header("Location: perfil_artesao.php?id=$id_artesao");
        exit;
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar produto: " . $conn->error . "</p>";
    }
}
?>

<div class="form-container">
    <h2 class="menu">Cadastrar Produto</h2>
    <form method="POST" class="cadastro-form" enctype="multipart/form-data">
        <label>Nome do Produto:</label>
        <input type="text" name="nome_produto" required><br>
        <label>Descrição:</label>
        <textarea name="descricao_produto" required></textarea><br>
        <label>Preço (R$):</label>
        <input type="number" name="preco_produto" step="0.01" required><br>
        <label>Imagem do Produto:</label>
        <input type="file" name="imagem" accept="image/*" required>
        <img id="preview-produto" src="#" alt="Preview" style="display:none; width:200px; height:200px; object-fit:cover; margin-top:10px;
 border-radius:10px;"><br>

        <button type="submit">Cadastrar</button>
    </form>
</div>

<script>
const inp = document.querySelector('input[name="imagem"]');
const pr = document.getElementById('preview-produto');

inp.addEventListener('change', function() {
    const [file] = this.files;
    if (file) {
        pr.src = URL.createObjectURL(file);
        pr.style.display = 'block';
    }
});
</script>

<?php include 'includes/footer.php'; ?>