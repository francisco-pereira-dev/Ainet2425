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

## 🔐 Credenciais de Acesso

A password para todas estas contas é: 123

Membros da Direção (Board / Admin)

```bash
Email: b1@mail.pt
Email: b2@mail.pt
Email: b3@mail.pt
Email: b4@mail.pt
```

---

Funcionários (Employee)

```bash
Email: e1@mail.pt
Email: e2@mail.pt
Email: e3@mail.pt
Email: e4@mail.pt
```

---

Membros Regulares / Sócios (Member)
```bash
Email: m1@mail.pt
Email: m2@mail.pt
Email: m3@mail.pt
Email: m4@mail.pt
```

---
