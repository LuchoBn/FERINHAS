<?php include 'includes/header.php'; ?>

<!-- Banner com fundo e chamada -->
<section class="banner-home" style="background: url('img/banner.jpg') center/cover no-repeat; height: 300px; display: flex; align-items: center; justify-content: center; color: white; text-shadow: 1px 1px 3px black;">
    <h1>Bem-vindo à Feirinha Hippie!</h1>
</section>

<!-- Sobre a feirinha -->
<section style="display: flex; gap: 30px; padding: 40px; align-items: center; max-width: 1000px; margin: auto;">
    <img src="img/feirinha.jpg" alt="Feirinha" style="width: 300px; border-radius: 20px;">
    <div>
        <h2>Sobre nós</h2>
        <p>Promovemos o artesanato local, conectando artesãos com a comunidade. Explore criações únicas e apoie o talento da região.</p>
        <a href="sobre.php"><button style="margin-top: 10px; padding: 10px 20px; border-radius: 20px; background: #009688; color: white; border: none;">Saber mais</button></a>
    </div>
</section>

<!-- Destaque de Artesãos -->
<section style="padding: 40px; background-color: #f4f4f4;">
    <h2 style="text-align: center;">Artesãos em destaque</h2>
    <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
        <div style="text-align: center;">
            <img src="img/artesao1.jpg" alt="Artesão 1" style="width: 150px; border-radius: 50%;">
            <p>Maria Artesã</p>
        </div>
        <div style="text-align: center;">
            <img src="img/artesao2.jpg" alt="Artesão 2" style="width: 150px; border-radius: 50%;">
            <p>João Criativo</p>
        </div>
        <div style="text-align: center;">
            <img src="img/artesao3.jpg" alt="Artesão 3" style="width: 150px; border-radius: 50%;">
            <p>Lúcia Natural</p>
        </div>
    </div>
</section>

<!-- Produtos em destaque -->
<section style="padding: 40px;">
    <h2 style="text-align: center;">Produtos em destaque</h2>
    <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
        <div style="border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 200px; text-align: center;">
            <img src="img/produto1.jpg" alt="Produto 1" style="width: 100%; border-radius: 10px;">
            <p>Colar artesanal</p>
        </div>
        <div style="border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 200px; text-align: center;">
            <img src="img/produto2.jpg" alt="Produto 2" style="width: 100%; border-radius: 10px;">
            <p>Bolsinha de crochê</p>
        </div>
        <div style="border: 1px solid #ccc; border-radius: 10px; padding: 10px; width: 200px; text-align: center;">
            <img src="img/produto3.jpg" alt="Produto 3" style="width: 100%; border-radius: 10px;">
            <p>Arte em madeira</p>
        </div>
    </div>
</section>

<!-- Botão explorar -->
<div style="text-align: center; margin: 40px;">
    <a href="ver-produtos.php">
        <button style="padding: 15px 30px; background-color: #009688; color: white; border: none; border-radius: 30px; font-size: 16px;">
            Explorar produtos
        </button>
    </a>
</div>

<?php include 'includes/footer.php'; ?>
