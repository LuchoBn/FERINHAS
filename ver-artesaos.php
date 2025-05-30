<?php
include 'includes/header.php';
include 'includes/conexao.php';

$result = $conn->query("SELECT * FROM artesao");
if (!$result) {
    echo "<p style='color:red;'>Erro na consulta: " . $conn->error . "</p>";
    include 'includes/footer.php';
    exit;
}

echo "<h2 class='menu'>Artesãos</h2><div class='artesao-lista'>";

while ($row = $result->fetch_assoc()) {
    $foto = !empty($row['foto_artesao'])
        ? "uploads/perfil/{$row['foto_artesao']}"
        : "img/padrao_artesao.png";

    echo "<a href='perfil_artesao.php?id={$row['id_artesao']}' class='artesao-card'>";
    echo "<img src='{$foto}' alt='{$row['nome_artesao']}' class='foto-artesao'>";
    echo "<h3>{$row['nome_artesao']}</h3>";
    echo "<p>{$row['descricao_artesao']}</p>";
    echo "</a>";
}

echo "</div>";
include 'includes/footer.php';
?>
