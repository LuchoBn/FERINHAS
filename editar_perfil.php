
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<div class="container">
    <h2>Editar Perfil</h2>
    <form action="processar_edicao.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_artesao" value="1">
        <label>Nome:</label>
        <input type="text" name="nome_artesao" required><br>
        <label>Email:</label>
        <input type="email" name="email_artesao" required><br>
        <label>Senha:</label>
        <input type="text" name="senha_artesao" required><br>
        <label>Foto de Perfil:</label>
        <input type="file" name="foto"><br>
        <button type="submit">Salvar Alterações</button>
    </form>
</div>
</body>
</html>
