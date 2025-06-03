<?php 
include 'includes/header.php'; 
include 'includes/conexao.php';
require_once 'includes/password.php';  // ¡Muy importante!

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formateo de texto: primera letra mayúscula
    $nome        = ucfirst(strtolower(trim($_POST['nome'])));
    $email       = $conn->real_escape_string($_POST['email']);
    $senha_raw   = $_POST['senha'];
    $descricao   = ucfirst(strtolower(trim($_POST['descricao'])));
    $telefone    = $conn->real_escape_string(trim($_POST['telefone']));
    $localizacao = ucfirst(strtolower(trim($_POST['localizacao'])));

    // Hash de la contraseña
    $senha_hash = password_hash($senha_raw, PASSWORD_DEFAULT);

    // Manejo de subida de foto
    $fotoNome = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $ext      = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoNome = uniqid('perfil_') . ".{$ext}";
        move_uploaded_file(
            $_FILES['foto']['tmp_name'], 
            'uploads/perfil/' . $fotoNome
        );
    }

    // Inserción en BD (usar prepared statement por seguridad)
    $stmt = $conn->prepare("INSERT INTO artesao 
        (nome_artesao, email_artesao, senha_artesao, descricao_artesao, telefone_artesao, localizacao_artesao, foto_artesao) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nome, $email, $senha_hash, $descricao, $telefone, $localizacao, $fotoNome);

    if ($stmt->execute()) {
        echo '<p class="cadastro-ok">Cadastro realizado com sucesso!</p>';
    } else {
        echo '<p class="cadastro-ok" style="color:red;">Erro: ' . $stmt->error . '</p>';
    }

    $stmt->close();
}
?>

<h2 class="menu">Cadastro de Artesão</h2>
<div class="form-container">
  <form method="POST" class="cadastro-form" enctype="multipart/form-data">
    <label for="nome">Nome:</label>
    <input id="nome" name="nome" type="text" required>

    <label for="email">Email:</label>
    <input id="email" name="email" type="email" required>

    <label for="senha">Senha:</label>
    <input id="senha" name="senha" type="password" required>

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" rows="3"></textarea>

    <label for="telefone">Telefone:</label>
    <input id="telefone" name="telefone" type="text">

    <label for="localizacao">Localização:</label>
    <input id="localizacao" name="localizacao" type="text">

    <label for="foto">Foto de perfil:</label>
    <input id="foto" name="foto" type="file" accept="image/*">
    <img id="preview" src="#" alt="Preview" style="display:none; width:120px; margin-top:10px; border-radius:50%; align-self:center;">

    <button type="submit">Cadastrar</button>
  </form>
</div>

<script>
// Vista previa de la foto seleccionada
document.getElementById('foto').addEventListener('change', function() {
    const [file] = this.files;
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

<?php include 'includes/footer.php'; ?>
