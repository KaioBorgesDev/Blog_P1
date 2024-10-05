# Blog_P1

## Descrição
Este repositório se trata de uma avaliação da FATEC Campinas, onde a ideia proposta é criar um Sistema para um BLOG. A stack utilizada é composta por HTML/CSS, PHP e MySQL.

## Pré-requisitos
- Servidor MySQL em execução
- PHP instalado
- Servidor web (como Apache ou Nginx)

## Instruções de Configuração

### 1. Inicie o MySQL Server
Certifique-se de iniciar o MySQL server com uma instância de usuário com o nome `root` e a senha `270275`.

### 2. Criação do Banco de Dados
Crie um banco de dados chamado `Sistema_Postagem` (lembre-se de usar snake_case):

#### CREATE DATABASE Sistema_Postagem;

### 2. Criação as Tabelas
Após criar o banco de dados, execute os seguintes comandos SQL para criar as tabelas necessárias:

#### CREATE TABLE usuarios (
   #### id INT AUTO_INCREMENT PRIMARY KEY,
   #### nome VARCHAR(100) NOT NULL,
   #### email VARCHAR(100) UNIQUE NOT NULL,
   #### senha VARCHAR(255) NOT NULL,
   #### data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   #### tipo_usuario ENUM('admin', 'usuario') DEFAULT 'usuario'
#### );

#### CREATE TABLE postagens (
####  id INT AUTO_INCREMENT PRIMARY KEY,
#### id_usuario INT NOT NULL,
#### titulo VARCHAR(100) NOT NULL,
#### conteudo TEXT NOT NULL,
#### data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
#### status ENUM('rascunho', 'publicado') DEFAULT 'rascunho',
#### FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
#### );
