<?php
include 'includes/header.php';
include 'includes/conexao.php';

$result = $conn->query("SELECT * FROM artesao");

echo "<h2 class='menu'>Artesãos</h2><div class='artesao-lista'>";

while ($row = $result->fetch_assoc()) {
    // Se não tiver foto cadastrada, usa a imagem padrão
    $foto = (!empty($row['foto_artesao'])) ? $row['foto_artesao'] : 'img/padrao_artesao.png';

    echo "<div class='artesao-card'>";
    echo "<img src='img/padrao_artesao.png' alt='{$row['nome_artesao']}' class='foto-artesao'>";
    echo "<h3>{$row['nome_artesao']}</h3>";
    echo "<p>{$row['descricao_artesao']}</p>";
    echo "<a href='perfil_artesao.php?id={$row['id_artesao']}' class='btn-verde'>Ver perfil</a>";
    echo "</div>";
}

echo "</div>";
include 'includes/footer.php';
?>
