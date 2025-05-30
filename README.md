Feirinha Hippie

Uma plataforma web para exposição e venda de artesanatos, onde artesãos podem se cadastrar, publicar produtos com foto e visitantes podem navegar e buscar itens.

Objetivo do projeto

A proposta da Feirinha Hippie é criar um sistema de exposição e venda de artesanatos online, permitindo:

Cadastro de artesãos com upload de foto de perfil e preenchimento de dados pessoais.

Login e controle de sessão para artesãos.

Listagem de artesãos em cards clicáveis para visualizar perfil individual.

Cadastro de produtos com foto, descrição e preço.

Exibição de produtos em exposição, com busca por nome e filtragem por categoria.

Responsividade no menu e estilização uniforme dos cards de artesãos e produtos.

Como configurar e executar

Pré-requisitos

PHP 5.4.17

USBWebserver (ou similar: XAMPP, WAMP)

Git (para clonar o repositório)

Clonar o repositório

git clone https://github.com/LuchoBn/FERINHAS.git
cd FERINHAS

Configurar o servidor local

Copie o diretório FERINHAS para a pasta de projetos do USBWebserver (ex.: root/).

Certifique-se de que a pasta uploads/ (e subpastas) tenha permissão de escrita.

Banco de dados

O arquivo base.bdd já está incluído no projeto.

No painel do USBWebserver, importe base.bdd:

Abra o phpMyAdmin.

Crie um novo banco de dados (ex.: ferinhas).

Selecione o banco criado e clique em "Importar".

Escolha o arquivo base.bdd e execute.

Atualize as credenciais em includes/conexao.php, se necessário.

Acessar a aplicação

Inicie o USBWebserver.

No navegador, acesse:

http://localhost/FERINHAS/

Funcionalidades principais

Cadastro de artesãos com upload de foto de perfil e preenchimento de dados pessoais.

Login e controle de sessão para artesãos.

Listagem de artesãos em cards clicáveis para visualizar perfil individual.

Cadastro de produtos com foto, descrição e preço.

Exibição de produtos em exposição, com busca por nome e filtragem por categoria.

Menu responsivo e estilização uniforme dos cards de artesãos e produtos.
