<?php include 'includes/header.php'; include 'includes/conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO exposicao (id_cliente, id_arte) VALUES ({$_POST['id_cliente']}, {$_POST['id_arte']})";
    $conn->query($sql);
    echo "<p>Produto cadastrado na exposição!</p>";
}
?>
<h2>Cadastro de Produto</h2>
<form method='POST' style='text-align:center;'>
    <input name='id_cliente' placeholder='ID do Cliente'><br><br>
    <input name='id_arte' placeholder='ID da Arte'><br><br>
    <button type='submit'>Cadastrar Produto</button>
</form>
<?php include 'includes/footer.php'; ?>