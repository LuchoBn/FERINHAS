<?php
session_start();
include 'includes/conexao.php';

if (!isset($_SESSION['id_artesao'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    die('ID do produto não informado.');
}

$id_produto = intval($_GET['id']);
$id_artesao = $_SESSION['id_artesao'];

$sql = "DELETE FROM produto WHERE id_produto = ? AND id_artesao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_produto, $id_artesao);

if ($stmt->execute()) {
    $url_retorno = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'perfil.php';
    $msg = urlencode('Produto excluído com sucesso');

    if (strpos($url_retorno, '?') !== false) {
        $url_retorno .= "&msg=$msg";
    } else {
        $url_retorno .= "?msg=$msg";
    }
    
    header("Location: $url_retorno");
    exit();
} else {
    echo "Erro ao excluir produto: " . $conn->error;
}
