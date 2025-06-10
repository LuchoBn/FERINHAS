<?php
include 'includes/header.php';
include 'includes/conexao.php';

$termo = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

echo "<h2 class='titulo-pagina'>Resultados para: <em>" . htmlspecialchars($termo) . "</em></h2>";

if ($termo != '') {
    $query = "SELECT p.*, a.nome_artesao 
              FROM produto p 
              JOIN artesao a ON p.id_artesao = a.id_artesao 
              WHERE p.status_produto = 'aprovado' 
              AND p.nome_produto LIKE '%$termo%'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='artesao-lista'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $imagem = !empty($row['imagem_produto'])
                ? "uploads/arte/{$row['imagem_produto']}"
                : "img/produtos.png";

            echo "<a href='perfil_artesao.php?id={$row['id_artesao']}' class='artesao-card'>";
            echo "<img src='{$imagem}' alt='{$row['nome_produto']}' class='foto-artesao'>";
            echo "<h3>{$row['nome_produto']}</h3>";
            echo "<p>{$row['descricao_produto']}</p>";
            echo "<p><strong>Preço:</strong> R$ " . number_format($row['preco_produto'], 2, ',', '.') . "</p>";
            echo "<p><em>Feito por:</em> {$row['nome_artesao']}</p>";
            echo "</a>";
        }
        echo "</div>";
    } else {
        echo "<p style='text-align:center;'>Nenhum produto encontrado.</p>";
    }
} else {
    echo "<p style='text-align:center;'>Nenhum termo de busca fornecido.</p>";
}

include 'includes/footer.php';
?>
