<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
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
        <div class="menu-icon">&#9776;</div>
        <form action="buscar.php" method="GET" class="form-busca">
           <input type="text" name="q" placeholder="Buscar produto..." required>
           <button type="submit">🔍</button>
        </form>

        <div class="user">
            <?php
                if (isset($_SESSION['nome_cliente'])) {
                    echo $_SESSION['nome_cliente'] . ' | <a href="logout.php">Sair</a>';
                } else {
                    echo '<a href="login.php">Entrar</a>';
                }
            ?>
        </div>
    </div>
    <nav class="menu">
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
