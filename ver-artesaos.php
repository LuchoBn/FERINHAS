<?php include 'includes/header.php'; include 'includes/conexao.php';
$result = $conn->query("SELECT * FROM artesao");
echo "<h2 class='menu'>Artesãos</h2><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><strong>{$row['nome_artesao']}</strong> - {$row['descricao_artesao']}</li>";
}
echo "</ul>";
include 'includes/footer.php'; ?>