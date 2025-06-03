<?php
session_start();
include 'includes/conexao.php';
include 'includes/header.php';

// Verifica se é moderador
if (!isset($_SESSION['id_artesao']) || $_SESSION['role'] !== 'moderador') {
    die('<p style="text-align:center; color:red;">Acesso negado.</p>');
}

// Tratamento de aprovação/reprovação
if (isset($_GET['acao'], $_GET['id'])) {
    $acao = $_GET['acao']; // 'aprovar' ou 'rejeitar'
    $id = intval($_GET['id']);
    $status = ($acao === 'aprovar') ? 'aprovado' : 'rejeitado';
    $mod = $_SESSION['nome_artesao'];
    $coment = '';

    // Só busca o comentário se for rejeição
    if ($acao === 'rejeitar' && isset($_POST['comentario'])) {
        $coment = $conn->real_escape_string($_POST['comentario']);
    }

    $sql = "UPDATE produto 
            SET status_produto='$status', 
                moderador_produto='$mod', 
                comentario_moderacao='$coment' 
            WHERE id_produto=$id";
    $conn->query($sql);
}

// Lista produtos pendentes
$res = $conn->query("SELECT p.*, a.nome_artesao 
                     FROM produto p 
                     JOIN artesao a ON p.id_artesao = a.id_artesao 
                     WHERE p.status_produto = 'pendente'");

echo '<h2 class="menu" style="text-align:center;">Moderação de Produtos</h2>';
echo '<div class="artesao-lista">';

while ($p = $res->fetch_assoc()) {
    $img = !empty($p['imagem_produto']) ? "uploads/arte/{$p['imagem_produto']}" : 'img/produtos.png';

    echo "<div class='artesao-card produto-pendente'>";
    echo   "<img src='{$img}' class='foto-artesao' alt='{$p['nome_produto']}'>";
    echo   "<h3>{$p['nome_produto']}</h3>";
    echo   "<p><strong>Por:</strong> {$p['nome_artesao']}</p>";
    echo   "<p>{$p['descricao_produto']}</p>";
    echo   "<p><strong>R$ " . number_format($p['preco_produto'], 2, ',', '.') . "</strong></p>";

    // Botão de Aprovação
    echo "<form method='POST' action='?id={$p['id_produto']}&acao=aprovar' style='margin-top:10px;'>";
    echo   "<button type='submit' class='botao verde'>Aprovar</button>";
    echo "</form>";

    // Botão e formulário de Rejeição
    echo "<button onclick=\"document.getElementById('rej{$p['id_produto']}').style.display='block'\" class='botao vermelho'>Rejeitar</button>";

    echo "<div id='rej{$p['id_produto']}' style='display:none; margin-top:10px;'>";
    echo   "<form method='POST' action='?id={$p['id_produto']}&acao=rejeitar'>";
    echo     "<textarea name='comentario' placeholder='Motivo da rejeição' rows='3' style='width:100%;'></textarea><br>";
    echo     "<button type='submit' class='botao vermelho'>Confirmar rejeição</button>";
    echo   "</form>";
    echo "</div>";

    echo "</div>";
}

echo '</div>';
include 'includes/footer.php';
?>
