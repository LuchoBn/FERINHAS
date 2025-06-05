<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php include 'includes/conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feirinha Hippie</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="top-bar">
        <div id="menu-icon" class="menu-icon" aria-label="Abrir menu">&#9776;</div>

        <form action="buscar.php" method="GET" class="form-busca">
            <input type="text" name="q" placeholder="Buscar produto..." required>
            <button type="submit">🔍</button>
        </form>

        <div class="user">
            <?php
            
                if (isset($_SESSION['id_artesao'])) {
                    $stmt = $conn->prepare("SELECT foto_artesao FROM artesao WHERE id_artesao = ?");
                    $stmt->bind_param('i', $_SESSION['id_artesao']);
                    $stmt->execute();
                    $stmt->bind_result($fotoPerfil);
                    $stmt->fetch();
                    $stmt->close();

                    $imgSrc = !empty($fotoPerfil)
                        ? "uploads/perfil/{$fotoPerfil}"
                        : "img/padrao_artesao.png";

                    echo "<img class='user-photo' src='" . htmlspecialchars($imgSrc) . "' alt='Foto de perfil' />";
                    echo htmlspecialchars($_SESSION['nome_artesao']);
                    echo " | <a href=\"logout.php\">Sair</a>";
                } else {
                    echo '<a href="login.php">Entrar</a>';
                }
            ?>
        </div>
    </div>

    <nav class="menu" id="nav-menu">
        <a href="index.php">Home</a>
        <a href="ver-artesaos.php">Artesãos</a>
        <a href="ver-produtos.php">Feirinhas hippies</a>
        <a href="sobre.php">Sobre nós</a>
    </nav>

    <div class="logo-central">
        <img src="img/logo.png" alt="Logo" height="120">
    </div>
</header>

<main>
