# 🚗 Sistema Web de Locadora de Veículos

Este é um projeto web de gerenciamento de locações de veículos, desenvolvido com **PHP** utilizando o **framework CodeIgniter 4**, integrado com **MySQL** para persistência dos dados. A aplicação oferece uma interface moderna e funcional para administrar clientes, veículos, categorias, usuários e locações.

---

## ✨ Funcionalidades

✅ Cadastro, edição e exclusão de **clientes**  
🚗 Gerenciamento completo de **veículos** com categorias e status  
📁 Cadastro de **categorias de veículos** com valor da diária  
📅 Registro de **locações** com cálculo automático de valor e status  
🔐 Controle de **usuários** com níveis de acesso (admin e operador)  
📈 Painel administrativo com **consultas e listagens** de dados  
📦 Relacionamentos com **chaves estrangeiras** e integridade referencial  

---

## 🚀 Tecnologias Utilizadas

- **PHP 8.2+**
- **CodeIgniter 4**
- **MySQL / MariaDB**
- **HTML5 / CSS3 / Bootstrap**
- **JavaScript (interações simples)**

---

## 🗃️ Estrutura do Banco de Dados

As principais tabelas utilizadas no sistema são:

- `clientes`: cadastro de clientes  
- `veiculos`: informações dos veículos disponíveis  
- `categorias`: define o tipo de veículo e valor da diária  
- `locacoes`: registra locações com datas, valores e status  
- `usuarios`: gerenciamento de acesso ao sistema  

O arquivo `locadora_carros.sql` contém o **script completo** de criação e dados de exemplo para testes.

---

## 🛠 Como Rodar o Projeto

1. Instale PHP, Composer e MySQL/MariaDB no seu ambiente.
2. Clone este repositório:
   ```bash
   git clone <url-do-repo>

   Configure o banco de dados:

Crie o banco:
CREATE DATABASE locadora_carros CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

Configure o acesso ao banco no arquivo:
app/Config/Database.php

Instale dependências:
composer install

Inicie o servidor de desenvolvimento:
php spark serve

Acesse a aplicação:
http://localhost:8080/


📂 Estrutura de Pastas
locadora/
├─ app/
│ ├─ Controllers/
│ │ ├─ Clientes.php
│ │ ├─ Veiculos.php
│ │ ├─ Locacoes.php
│ │ └─ Usuarios.php
│ ├─ Models/
│ │ ├─ ClienteModel.php
│ │ ├─ VeiculoModel.php
│ │ ├─ LocacaoModel.php
│ │ └─ UsuarioModel.php
│ ├─ Views/
│ ├─ clientes/
│ ├─ veiculos/
│ ├─ locacoes/
│ └─ layout/
├─ public/
│ └─ index.php
└─ locadora_carros.sql


sql
Copy
Edit
CALL TesteCargaLocacoes(1000);
👥 Integrantes do Grupo
Luis Ricardo Holscher
Diego Rafael Muller
Guilherme Massinhani De Souza

