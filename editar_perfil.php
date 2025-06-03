<?php
session_start();
include 'includes/conexao.php';
require_once 'includes/password.php';

// Verifica se usuário está logado
if (!isset($_SESSION['id_artesao'])) {
    header('Location: login.php');
    exit();
}

$id = $_SESSION['id_artesao'];
$erro = '';
$sucesso = '';

// Obtener datos actuales para mostrar en formulario
$stmt = $conn->prepare("SELECT nome_artesao, email_artesao, descricao_artesao, telefone_artesao, localizacao_artesao, foto_artesao FROM artesao WHERE id_artesao = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nome, $email, $descricao, $telefone, $localizacao, $foto);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizar_perfil'])) {
        // Actualizar datos perfil
        $nome_novo = ucfirst(strtolower(trim($_POST['nome'])));
        $descricao_novo = ucfirst(strtolower(trim($_POST['descricao'])));
        $telefone_novo = trim($_POST['telefone']);
        $localizacao_novo = ucfirst(strtolower(trim($_POST['localizacao'])));

        // Manejo de subida foto si hay
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $fotoNome = uniqid('perfil_') . ".{$ext}";
            move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/perfil/' . $fotoNome);

            // Actualizar con nueva foto
            $stmt = $conn->prepare("UPDATE artesao SET nome_artesao=?, descricao_artesao=?, telefone_artesao=?, localizacao_artesao=?, foto_artesao=? WHERE id_artesao=?");
            $stmt->bind_param("sssssi", $nome_novo, $descricao_novo, $telefone_novo, $localizacao_novo, $fotoNome, $id);
        } else {
            // Sin cambiar foto
            $stmt = $conn->prepare("UPDATE artesao SET nome_artesao=?, descricao_artesao=?, telefone_artesao=?, localizacao_artesao=? WHERE id_artesao=?");
            $stmt->bind_param("ssssi", $nome_novo, $descricao_novo, $telefone_novo, $localizacao_novo, $id);
        }

        if ($stmt->execute()) {
            $sucesso = "Perfil atualizado com sucesso!";
            // Refrescar datos para mostrar en formulario
            $nome = $nome_novo;
            $descricao = $descricao_novo;
            $telefone = $telefone_novo;
            $localizacao = $localizacao_novo;
            if (isset($fotoNome)) $foto = $fotoNome;
        } else {
            $erro = "Erro ao atualizar perfil.";
        }
        $stmt->close();
    }

    // Cambio de contraseña
    if (isset($_POST['atualizar_senha'])) {
        $senha_atual = $_POST['senha_atual'];
        $nova_senha = $_POST['nova_senha'];
        $confirma_senha = $_POST['confirma_senha'];

        // Obtener hash actual
        $stmt = $conn->prepare("SELECT senha_artesao FROM artesao WHERE id_artesao=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($senha_hash_bd);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($senha_atual, $senha_hash_bd)) {
            $erro = "Senha atual incorreta.";
        } elseif ($nova_senha !== $confirma_senha) {
            $erro = "A confirmação da nova senha não coincide.";
        } else {
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE artesao SET senha_artesao=? WHERE id_artesao=?");
            $stmt->bind_param("si", $nova_senha_hash, $id);
            if ($stmt->execute()) {
                $sucesso = "Senha alterada com sucesso!";
            } else {
                $erro = "Erro ao alterar a senha.";
            }
            $stmt->close();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<h2 class="menu">Editar Perfil</h2>

<div class="form-container">
    <?php if ($erro): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php elseif ($sucesso): ?>
        <p style="color: green;"><?php echo $sucesso; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="cadastro-form">
        <input type="hidden" name="atualizar_perfil" value="1">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($descricao); ?></textarea>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>">

        <label for="localizacao">Localização:</label>
        <input type="text" id="localizacao" name="localizacao" value="<?php echo htmlspecialchars($localizacao); ?>">

        <label for="foto">Foto de perfil:</label>
        <?php if ($foto): ?>
            <br>
            <img src="uploads/perfil/<?php echo htmlspecialchars($foto); ?>" alt="Foto de perfil" style="width: 120px; border-radius: 50%; margin-bottom: 10px;">
            <br>
        <?php endif; ?>
        <input type="file" id="foto" name="foto" accept="image/*">

        <button type="submit">Atualizar Perfil</button>
    </form>
</div>

<hr style="margin: 40px 0;">

<h2 class="menu">Alterar Senha</h2>
<div class="form-container">
    <form method="POST" class="cadastro-form">
        <input type="hidden" name="atualizar_senha" value="1">

        <label for="senha_atual">Senha Atual:</label>
        <input type="password" id="senha_atual" name="senha_atual" required>

        <label for="nova_senha">Nova Senha:</label>
        <input type="password" id="nova_senha" name="nova_senha" required>

        <label for="confirma_senha">Confirmar Nova Senha:</label>
        <input type="password" id="confirma_senha" name="confirma_senha" required>

        <button type="submit">Alterar Senha</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
