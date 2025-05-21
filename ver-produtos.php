<?php
include 'includes/header.php';
include 'includes/conexao.php';

// Consulta todos os produtos com o nome do artesão
$result = $conn->query("
    SELECT p.*, a.nome_artesao 
    FROM produto p 
    JOIN artesao a ON p.id_artesao = a.id_artesao
");

// Título da página
echo "<h2 class='menu'>Produtos em Exposição</h2><div class='artesao-lista'>";

while ($row = $result->fetch_assoc()) {
    // Se não tiver imagem cadastrada, usa imagem padrão
    $imagem = (!empty($row['imagem'])) ? $row['imagem'] : 'img/produtos.png';

    echo "<div class='artesao-card'>";
    echo "<img src='img/produtos.png' alt='{$row['nome_produto']}' class='foto-artesao'>";
    echo "<h3>{$row['nome_produto']}</h3>";
    echo "<p>{$row['descricao_produto']}</p>";
    echo "<p><strong>Preço:</strong> R$ " . number_format($row['preco_produto'], 2, ',', '.') . "</p>";
    echo "<p><em>Feito por:</em> {$row['nome_artesao']}</p>";
    echo "</div>";
}

echo "</div>";
include 'includes/footer.php';
?>
