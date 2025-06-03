<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

$id_artesao = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obter dados do artesão
$sql = "SELECT * FROM artesao WHERE id_artesao = $id_artesao";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "<p style='text-align:center;'>Artesão não encontrado.</p>";
    include 'includes/footer.php';
    exit;
}

$artesao = $result->fetch_assoc();

// Prepara foto de perfil
$foto = !empty($artesao['foto_artesao'])
    ? "uploads/perfil/{$artesao['foto_artesao']}"   
    : "img/padrao_artesao.png";

$nome = $artesao['nome_artesao'];
$descricao = $artesao['descricao_artesao'];
$contato = $artesao['telefone_artesao'];
$usuario_logado = isset($_SESSION['nome_artesao']) ? $_SESSION['nome_artesao'] : null;
$sou_dono = $usuario_logado && strpos($nome, $usuario_logado) === 0;

// Exibe perfil
echo "<div class='perfil-wrapper'>
        <div class='perfil-container'>
            <img src='{$foto}' class='foto-artesao' style='width:200px;height:200px;object-fit:cover;'>
            <div class='info-artesao'>
                <h2>Feirinha de {$nome}</h2>
                <p>{$descricao}</p>
                <p><strong>Contato:</strong> {$contato}</p>
            </div>
        </div>
      </div>";

echo "<h3 class='menu' style='text-align:center;'>Produtos cadastrados</h3>";

$sql_produtos = $sou_dono
    ? "SELECT * FROM produto WHERE id_artesao = $id_artesao"
    : "SELECT * FROM produto WHERE id_artesao = $id_artesao AND status_produto = 'aprovado'";

$result_prod = $conn->query($sql_produtos);

if ($result_prod && $result_prod->num_rows > 0) {
    echo "<div class='artesao-lista'>";
    while ($p = $result_prod->fetch_assoc()) {
        $img = !empty($p['imagem_produto']) ? "uploads/arte/{$p['imagem_produto']}" : "img/produtos.png";
        $status = $p['status_produto'];

        // Estilo por status
        $classeStatus = 'produto-aprovado';
        $badge = "<span class='status-badge status-aprovado'>✔️ Aprovado</span>";

        if ($status === 'pendente') {
            $classeStatus = 'produto-pendente';
            $badge = "<span class='status-badge status-pendente'>⏳ Pendente</span>";
        } elseif ($status === 'recusado') {
            $classeStatus = 'produto-recusado';
            $badge = "<span class='status-badge status-recusado'>❌ Recusado</span>";
        }

        echo "<div class='artesao-card {$classeStatus}'>";
        echo   "<img src='{$img}' alt='{$p['nome_produto']}' class='foto-artesao'>";
        echo   "<h3>{$p['nome_produto']}</h3>";
        echo   "<p>{$p['descricao_produto']}</p>";
        echo   "<p><strong>R$ " . number_format($p['preco_produto'], 2, ',', '.') . "</strong></p>";
        echo   "{$badge}";

        if ($sou_dono) {
            echo "<div style='margin-top:10px;'>";
            echo   "<a href='editar_produto.php?id={$p['id_produto']}' class='botao'>✏️ Editar</a> ";
            echo   "<a href='excluir_produto.php?id={$p['id_produto']}' class='botao' onclick='return confirm(\"Deseja excluir este produto?\")'>🗑️ Excluir</a>";
            echo "</div>";
        }

        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<p style='text-align:center;'>Este artesão ainda não cadastrou nenhum produto.</p>";
}

// Botão cadastrar produto
if ($sou_dono) {
    echo "<div style='text-align:center; margin: 20px;'>
            <a href='cadastrar_produto.php?id=$id_artesao' class='botao'>➕ Cadastrar produto</a>
          </div>";
}

include 'includes/footer.php';
?>
