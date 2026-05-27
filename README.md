# 🎓 Projeto AINET - Aplicações para a Internet

Este repositório contém um projeto desenvolvido em equipa (3 elementos) no âmbito de uma Unidade Curricular da licenciatura. O foco deste trabalho foi a construção de uma solução full-stack robusta utilizando a framework **Laravel**, onde aplicámos os nossos conhecimentos no padrão MVC (Model-View-Controller), na segurança de rotas e na gestão de bases de dados relacionais.

---

## ⚙️ Como executar o Backend

Para arrancar com a infraestrutura, preparar a base de dados e povoá-la com dados de teste, abre o terminal na **pasta raiz do projeto** e corre os seguintes comandos:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```

---

## 💻 Como executar o Frontend

Como o projeto utiliza o Vite para compilação de assets em tempo real, precisarás de abrir um novo terminal (mantendo o do backend aberto) também na pasta raiz do projeto, e executar:

```bash
npm install
npm run dev
```

---

## 🔐 Credenciais de Acesso (Dados de Teste)

Ao correres o comando de migração com a flag --seed, foram gerados utilizadores de teste para poderes explorar a plataforma.
A password para todas estas contas é: 123

Membros da Direção (Board / Admin)

```bash
b1@mail.pt
b2@mail.pt
b3@mail.pt
b4@mail.pt
```

---

Funcionários (Employee)

```bash
e1@mail.pt
e2@mail.pt
e3@mail.pt
e4@mail.pt
```

---

Membros Regulares / Sócios (Member)
```bash
m1@mail.pt
m2@mail.pt
m3@mail.pt
m4@mail.pt
```

---
