# DevWeb - Sistema de Cadastro de Alunos FIAP

Um sistema web CRUD para cadastro e gerenciamento de alunos, com tema visual da FIAP, desenvolvido em HTML, CSS, PHP e MySQL.

## 🎓 Sobre o Projeto

Este projeto foi reestruturado para ser um sistema de cadastro de alunos da FIAP, com interface moderna, carrossel de imagens, formulário responsivo e integração completa com banco de dados MySQL via PHP.

## ✨ Funcionalidades

- Cadastro de alunos (nome, e-mail, curso, RA, telefone)
- Listagem, edição e exclusão de alunos
- Interface responsiva e moderna com tema FIAP
- Carrossel de imagens no header
- Mensagens de sucesso/erro estilizadas
- Footer institucional FIAP

## 🛠️ Tecnologias Utilizadas

- HTML5
- CSS3 (Design Responsivo, tema FIAP)
- Bootstrap 5
- PHP (CRUD, conexão MySQL)
- MySQL (armazenamento dos alunos)
- JavaScript (para AJAX e interatividade)

## 📁 Estrutura do Projeto

```
DevWeb/
├── api/           # Backend PHP (CRUD, conexão, etc)
│   ├── crud.php
│   ├── config.php
│   └── api.php
├── assets/        # CSS, fontes, ícones
│   └── style.css
├── database/      # Scripts SQL, backups, docs do banco
├── images/        # Imagens do site (logos, banners, etc)
├── js/            # Scripts JS customizados
├── public/        # Arquivos acessíveis diretamente (HTML, PHP de interface)
│   ├── index.html
│   └── cadastrar_aluno.php
├── README.md
├── LICENSE
└── .gitignore
```

## 🚀 Como Usar

1. Clone o repositório:
```bash
git clone https://github.com/GU1LHERMESILV4/DevWeb.git
```

2. Importe o banco de dados usando o script em `database/`.
3. Configure o acesso ao banco em `api/config.php` se necessário.
4. Rode o projeto em um servidor local (XAMPP, WAMP, Laragon, ou PHP embutido):
   - Acesse `public/index.html` para a interface principal.
   - Acesse `public/cadastrar_aluno.php` para cadastro via PHP puro.

## 🆕 Mudanças Recentes

- Reorganização completa dos arquivos em pastas temáticas (api, assets, images, database, public, js)
- Novo tema visual FIAP (magenta, preto, branco)
- Carrossel de imagens no header
- Footer institucional FIAP
- Cadastro de alunos integrado ao banco de dados MySQL
- Mensagens de sucesso/erro estilizadas e pop-up de confirmação

## 🤝 Contribuição

Contribuições são bem-vindas! Siga o fluxo de fork, branch, commit e pull request.

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

---
Feito com ❤️ por [GU1LHERMESILV4](https://github.com/GU1LHERMESILV4)
