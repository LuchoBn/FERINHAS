<?php include 'includes/header.php'; include 'includes/conexao.php';
$result = $conn->query("SELECT * FROM exposicao JOIN arte ON exposicao.id_arte = arte.id_arte");
echo "<h2 class='menu'>Produtos em Exposição</h2><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><strong>{$row['titulo_arte']}</strong>: {$row['descricao_arte']}</li>";
}
echo "</ul>";
include 'includes/footer.php'; ?>