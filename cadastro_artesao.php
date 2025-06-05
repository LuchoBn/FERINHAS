<?php 
include 'includes/header.php'; 
include 'includes/conexao.php';
require_once 'includes/password.php';  //senha encriptado
require_once 'includes/enviar_confirmacao.php'; // Função de envio de email

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formateo de texto
    $nome        = ucfirst(strtolower(trim($_POST['nome'])));
    $email       = $conn->real_escape_string($_POST['email']);
    $senha_raw   = $_POST['senha'];
    $descricao   = ucfirst(strtolower(trim($_POST['descricao'])));
    $telefone    = $conn->real_escape_string(trim($_POST['telefone']));
    $localizacao = ucfirst(strtolower(trim($_POST['localizacao'])));

    $senha_hash = password_hash($senha_raw, PASSWORD_DEFAULT);

    // Gera token de confirmação único
   $token = bin2hex(openssl_random_pseudo_bytes(16));


    // Foto de perfil
    $fotoNome = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoNome = uniqid('perfil_') . ".{$ext}";
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/perfil/' . $fotoNome);
    }

    // Inserção no banco com token e confirmado=0
    $stmt = $conn->prepare("INSERT INTO artesao 
        (nome_artesao, email_artesao, senha_artesao, descricao_artesao, telefone_artesao, localizacao_artesao, foto_artesao, token_confirmacao, confirmado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
    $stmt->bind_param("ssssssss", $nome, $email, $senha_hash, $descricao, $telefone, $localizacao, $fotoNome, $token);

    if ($stmt->execute()) {
        // Envia o e-mail de confirmação
        if (enviarEmailConfirmacao($email, $nome, $token)) {
            echo '<p class="cadastro-ok">Cadastro realizado! Verifique seu e-mail para confirmar.</p>';
        } else {
            echo '<p class="cadastro-ok" style="color:red;">Cadastro feito, mas falha ao enviar e-mail de confirmação.</p>';
        }
    } else {
        echo '<p class="cadastro-ok" style="color:red;">Erro no cadastro: ' . $stmt->error . '</p>';
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
// Preview da imagem de perfil
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
