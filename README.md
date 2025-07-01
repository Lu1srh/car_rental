
# 🚗 Sistema Web de Locadora de Veículos

Projeto desenvolvido em **PHP com CodeIgniter 4** e banco de dados **MySQL/MariaDB**, com objetivo de gerenciar locações de veículos. O sistema permite cadastrar e administrar clientes, veículos, categorias, usuários e locações de forma eficiente e intuitiva.

---

## ✨ Funcionalidades

- ✅ Cadastro e gerenciamento de **clientes**  
- 🚘 Controle de **veículos** com status e categorias  
- 📁 Registro de **categorias** com valores por diária  
- 📅 Gerenciamento de **locações** (ativa, cancelada, finalizada)  
- 🔐 Sistema de **usuários** com níveis de acesso (admin/operador)  
- 📊 Visualização de dados com **relatórios e listagens**  
- 🧩 Suporte a **relacionamentos com integridade referencial**

---

## 🚀 Tecnologias Utilizadas

- PHP 8.2+
- CodeIgniter 4
- MySQL / MariaDB
- HTML5 / CSS3 / Bootstrap
- JavaScript

---

## 🗃️ Banco de Dados

O banco de dados está no arquivo `locadora_carros.sql`, que inclui:

- Tabelas: `clientes`, `veiculos`, `categorias`, `locacoes`, `usuarios`
- Chaves estrangeiras e índices otimizados
- Dados de exemplo para testes

---

## 📂 Estrutura de Pastas

```
locadora/
├─ app/
│  ├─ Controllers/
│  │  ├─ Clientes.php
│  │  ├─ Veiculos.php
│  │  ├─ Locacoes.php
│  │  └─ Usuarios.php
│  ├─ Models/
│  │  ├─ ClienteModel.php
│  │  ├─ VeiculoModel.php
│  │  ├─ LocacaoModel.php
│  │  └─ UsuarioModel.php
│  ├─ Views/
│     ├─ clientes/
│     ├─ veiculos/
│     ├─ locacoes/
│     └─ layout/
├─ public/
│  └─ index.php
└─ locadora_carros.sql
```

---

## 🛠 Como Rodar o Projeto

1. Instale PHP, Composer e MySQL/MariaDB.
2. Crie um banco de dados com o nome `locadora_carros`.
3. Importe o arquivo `locadora_carros.sql` via phpMyAdmin ou terminal.
4. Configure o arquivo `app/Config/Database.php` com os dados do seu banco.
5. Execute o projeto com:
   ```bash
   php spark serve
   ```
6. Acesse `http://localhost:8080`

---

## 👥 Integrantes do Grupo

- **Luis Ricardo Holscher**  
- **Diego Rafael Muller**  
- **Guilherme Massinhani De Souza**
