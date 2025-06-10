<!-- Fechamento do "main" do header.php -->
</main>
<footer>
    <div class="footer-container">
        <img src="img/logo.png" alt="Logo" class="footer-logo">
        <div>
            <h4>Redes sociais</h4>
            <p>Instagram | YouTube | WhatsApp</p>
        </div>
        <div>
            <h4>Links úteis</h4>
            <ul>
                <li>Sobre nós</li>
                <li>Artesanatos</li>
                <li>Feirinhas hippies da baixada</li>
            </ul>
        </div>
    </div>
</footer>

<!-- Menu Lateral -->
<div id="sidebar" class="sidebar">
    <span class="close-btn" onclick="toggleSidebar()">✖</span>

    <div class="user-info">
        <?php
        $fotoSidebar = 'padrao_artesao.png';
        $nomeUsuario = isset($_SESSION['nome_artesao']) ? $_SESSION['nome_artesao'] : 'Visitante';
        $idUsuario = isset($_SESSION['id_artesao']) ? (int) $_SESSION['id_artesao'] : 0;

        if ($idUsuario > 0) {
            $stmt = $conn->prepare("SELECT foto_artesao FROM artesao WHERE id_artesao = ?");
            $stmt->bind_param('i', $idUsuario);
            $stmt->execute();
            $stmt->bind_result($fotoBanco);
            $stmt->fetch();
            $stmt->close();

            if (!empty($fotoBanco)) {
                $fotoSidebar = $fotoBanco;
            }
        }
        ?>
        <img src="uploads/perfil/<?php echo htmlspecialchars($fotoSidebar); ?>" class="sidebar-photo" alt="Foto de perfil">
        <p>Olá, <?php echo htmlspecialchars($nomeUsuario); ?></p>
    </div>

    <ul class="sidebar-menu">
        <?php if (!empty($_SESSION['id_artesao'])): ?>
            <li><a href="perfil_artesao.php?id=<?php echo $idUsuario; ?>">Ver Perfil</a></li>
            <li><a href="editar_perfil.php">Editar Perfil</a></li>
            <li><a href="cadastrar_produto.php?id=<?php echo $idUsuario; ?>">Adicionar Artesanato</a></li>
            
            <?php if (!empty($_SESSION['tipo']) && $_SESSION['tipo'] === 'moderador'): ?>
                <li><a href="moderar_produtos.php">Moderar Produtos</a></li>
            <?php endif; ?>
            
            <li><a href="logout.php">Sair</a></li>
        <?php else: ?>
            <li><a href="login.php">Entrar</a></li>
            <li><a href="cadastro_artesao.php">Criar Conta</a></li>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

document.getElementById('menu-icon').addEventListener('click', toggleSidebar);
</script>
