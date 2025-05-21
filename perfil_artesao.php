<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

$id_artesao = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obter dados do artesão
$sql = "SELECT * FROM artesao WHERE id_artesao = $id_artesao";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $artesao = $result->fetch_assoc();
    $nome = $artesao['nome_artesao'];
    $descricao = $artesao['descricao_artesao'];
    $contato = $artesao['telefone_artesao'];
    $usuario_logado = isset($_SESSION['nome_artesao']) ? $_SESSION['nome_artesao'] : null;
    $sou_dono = $usuario_logado && strpos($nome, $usuario_logado) === 0;

    echo "<div class='perfil-wrapper'>
            <div class='perfil-container'>
                <img src='img/padrao_artesao.png' class='foto-artesao'>
                <div class='info-artesao'>
                    <h2>Feirinha de $nome</h2>
                    <p>$descricao</p>
                    <p><strong>Contato:</strong> $contato</p>
                </div>
            </div>
          </div>";

    echo "<h3 class='menu' style='text-align:center;'>Produtos cadastrados</h3>";

    $sql_produtos = "SELECT * FROM produto WHERE id_artesao = $id_artesao";
    $result_prod = $conn->query($sql_produtos);

    if ($result_prod->num_rows > 0) {
        echo "<div class='produtos-container'>";
        while ($p = $result_prod->fetch_assoc()) {
            echo "<div class='produto-card'>
                    <img src='img/produtos.png' class='img-produto'>
                    <h4>{$p['nome_produto']}</h4>
                    <p>{$p['descricao_produto']}</p>
                    <p><strong>Preço: R$" . number_format($p['preco_produto'], 2, ',', '.') . "</strong></p>
                  </div>";
        }
        echo "</div>";
    } else {
        echo "<p style='text-align:center;'>Este artesão ainda não cadastrou nenhum produto.</p>";
    }

    if ($sou_dono) {
        echo "<div style='text-align:center; margin: 20px;'>
                <a href='cadastrar_produto.php?id=$id_artesao' class='botao'>Cadastrar produto</a>
              </div>";
    }
} else {
    echo "<p style='text-align:center;'>Artesão não encontrado.</p>";
}

include 'includes/footer.php';
?>
