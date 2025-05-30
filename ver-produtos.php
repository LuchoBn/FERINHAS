<?php
include 'includes/header.php';
include 'includes/conexao.php';

$sql = "
    SELECT p.*, a.nome_artesao, a.id_artesao
    FROM produto p
    JOIN artesao a ON p.id_artesao = a.id_artesao
";
$result = $conn->query($sql);
if (!$result) {
    echo "<p style='color:red;'>Erro na consulta: " . $conn->error . "</p>";
    include 'includes/footer.php';
    exit;
}

echo "<h2 class='menu'>Produtos em Exposição</h2><div class='artesao-lista'>";

while ($row = $result->fetch_assoc()) {
    $img = !empty($row['imagem_produto'])
        ? "uploads/arte/{$row['imagem_produto']}"
        : "img/produtos.png";

    echo "<a href='perfil_artesao.php?id={$row['id_artesao']}' class='artesao-card'>";
    echo "<img src='{$img}' alt='{$row['nome_produto']}' class='foto-artesao'>";
    echo "<h3>{$row['nome_produto']}</h3>";
    echo "<p>{$row['descricao_produto']}</p>";
    echo "<p><strong>R$ " . number_format($row['preco_produto'], 2, ',', '.') . "</strong></p>";
    echo "<p><em>Feito por: {$row['nome_artesao']}</em></p>";
    echo "</a>";
}

echo "</div>";
include 'includes/footer.php';
?>
