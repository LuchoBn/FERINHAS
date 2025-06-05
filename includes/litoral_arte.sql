-- Base de dados: litoral-art


DROP TABLE IF EXISTS `produto`;
DROP TABLE IF EXISTS `artesao`;

-- Criação da tabela de artesãos
CREATE TABLE IF NOT EXISTS `artesao` (
  `id_artesao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_artesao` varchar(100) NOT NULL,
  `email_artesao` varchar(100) NOT NULL UNIQUE,
  `senha_artesao` varchar(255) NOT NULL,
  `descricao_artesao` varchar(255),
  `telefone_artesao` char(11),
  `localizacao_artesao` varchar(100),
  `foto_artesao` varchar(255),
  `status_perfil` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  `moderador_perfil` varchar(100),
  `comentario_perfil` text,
  `role` enum('user','moderador','admin') DEFAULT 'user',
  `token_confirmacao` varchar(255),
  `email_confirmado` tinyint(1) DEFAULT 0,
  `confirmado` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id_artesao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Criação da tabela de produtos
CREATE TABLE IF NOT EXISTS `produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `id_artesao` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `descricao_produto` text,
  `preco_produto` decimal(10,2),
  `imagem_produto` varchar(255),
  `status_produto` enum('pendente','aprovado','rejeitado') DEFAULT 'pendente',
  `moderador_produto` varchar(100),
  `comentario_moderacao` text,
  PRIMARY KEY (`id_produto`),
  FOREIGN KEY (`id_artesao`) REFERENCES `artesao`(`id_artesao`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
