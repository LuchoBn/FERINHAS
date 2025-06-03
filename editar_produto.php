<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

// Verifica login
if (!isset($_SESSION['id_artesao'])) {
    die("<p style='color:red; text-align:center;'>Acesso negado.</p>");
}

$id_artesao = $_SESSION['id_artesao'];
$id_produto = isset($_GET['id']) ? intval($_GET['id']) : 0;
$mensagem = '';

// Buscar produto
$sql = "SELECT * FROM produto WHERE id_produto = $id_produto AND id_artesao = $id_artesao";
$res = $conn->query($sql);

if (!$res || $res->num_rows === 0) {
    die("<p style='color:red; text-align:center;'>Produto não encontrado ou acesso negado.</p>");
}

$produto = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_produto'];
    $descricao = $_POST['descricao_produto'];
    $preco = floatval($_POST['preco_produto']);

    // Atualiza imagem se foi enviada nova
    if (!empty($_FILES['imagem_produto']['name'])) {
        $nome_arquivo = uniqid() . '_' . basename($_FILES['imagem_produto']['name']);
        $caminho = "uploads/arte/" . $nome_arquivo;
        move_uploaded_file($_FILES['imagem_produto']['tmp_name'], $caminho);
        $imagem_sql = ", imagem_produto = '$nome_arquivo'";
    } else {
        $imagem_sql = "";
    }

    $update = "UPDATE produto 
               SET nome_produto = '$nome',
                   descricao_produto = '$descricao',
                   preco_produto = $preco,
                   status_produto = 'pendente',
                   comentario_moderacao = NULL
                   $imagem_sql
               WHERE id_produto = $id_produto AND id_artesao = $id_artesao";
    
    if ($conn->query($update)) {
        $mensagem = "<p style='color:green; text-align:center;'>Produto atualizado com sucesso! Agora aguardando nova aprovação.</p>";
        // Atualiza dados da imagem se foi alterada
        $res = $conn->query($sql);
        $produto = $res->fetch_assoc();
    } else {
        $mensagem = "<p style='color:red; text-align:center;'>Erro ao atualizar produto.</p>";
    }
}

// Prepara imagem atual
$img = !empty($produto['imagem_produto']) ? "uploads/arte/{$produto['imagem_produto']}" : "img/produtos.png";
?>

<h2 class="menu">Editar Produto</h2>

<?= $mensagem ?>

<div class="form-container">
    <form method="POST" enctype="multipart/form-data" class="cadastro-form">

        <label for="nome_produto">Nome do Produto:</label>
        <input type="text" id="nome_produto" name="nome_produto" value="<?= htmlspecialchars($produto['nome_produto']) ?>" required>

        <label for="descricao_produto">Descrição:</label>
        <textarea id="descricao_produto" name="descricao_produto" required><?= htmlspecialchars($produto['descricao_produto']) ?></textarea>

        <label for="preco_produto">Preço:</label>
        <input type="number" step="0.01" name="preco_produto" value="<?= htmlspecialchars($produto['preco_produto']) ?>" required>

        <label>Imagem atual:</label><br>
        <img src="<?= $img ?>" class="foto-artesao" style="width:200px;height:200px;object-fit:cover;"><br><br>

        <label for="imagem_produto">Nova imagem (opcional):</label>
        <input type="file" name="imagem_produto" accept="image/*">

        <button type="submit">Salvar alterações</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
