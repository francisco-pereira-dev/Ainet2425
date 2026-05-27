# 🎓 Projeto AINET - Aplicações para a Internet

Este repositório contém um projeto desenvolvido em equipa (3 elementos) no âmbito de uma Unidade Curricular da licenciatura.
O foco deste trabalho foi a construção de uma solução *full-stack* robusta utilizando a framework **Laravel**, onde aplicámos os nossos conhecimentos no padrão MVC (Model-View-Controller), na segurança de rotas e na gestão de bases de dados relacionais.

## ⚙️ Como executar o Backend

Para arrancar com a infraestrutura, compilar o projeto e preparar a base de dados, abre o terminal na pasta raiz do teu projeto e corre os seguintes comandos:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 💻 Como executar o Frontend

Para iniciar a interface de utilizador, abre um novo terminal na pasta do frontend, instala as dependências necessárias e arranca o servidor de desenvolvimento:

```bash
npm install
npm run dev
```

---

