
<?php
$con = mysqli_connect("localhost", "root", "usbw", "ferinhas");

if (!$con) {
    die("Erro na conexão: " . mysqli_connect_error());
}

$id_artesao = $_POST['id_artesao'];
$nome = $_POST['nome_artesao'];
$email = $_POST['email_artesao'];
$senha = $_POST['senha_artesao'];

$foto_nome = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $foto_nome = 'perfil_' . $id_artesao . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], 'imagens_perfil/' . $foto_nome);
}

$sql = "UPDATE artesao SET nome_artesao='$nome', email_artesao='$email', senha_artesao='$senha'";

if ($foto_nome != '') {
    $sql .= ", foto_artesao='$foto_nome'";
}

$sql .= " WHERE id_artesao=$id_artesao";

if (mysqli_query($con, $sql)) {
    echo "Cadastro atualizado com sucesso!";
} else {
    echo "Erro ao atualizar: " . mysqli_error($con);
}

mysqli_close($con);
?>
