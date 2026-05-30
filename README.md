# 🎓 Projeto AINET - Aplicações para a Internet

Este repositório contém um projeto desenvolvido em equipa (3 elementos) no âmbito da licenciatura em Engenharia Informática. O principal objetivo foi arquitetar e desenvolver uma solução full-stack escalável com recurso à framework **Laravel**. 

Durante o desenvolvimento, consolidámos a aplicação prática do padrão arquitetural **MVC** (Model-View-Controller), a implementação rigorosa de segurança e proteção de rotas, bem como a modelação e gestão de bases de dados relacionais.



## ⚙️ Como executar o Backend

Para inicializar o ambiente, configurar a base de dados e povoá-la automaticamente com dados de teste (seeding), abre o terminal na pasta raiz do projeto e executa os seguintes comandos:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
php artisan serve
```



## 💻 Como executar o Frontend

Este projeto tira partido do **Vite** para a compilação de assets otimizada e em tempo real (HMR). Num novo terminal (mantendo o servidor do backend em execução na pasta raiz), executa:

```bash
npm install
npm run dev
```



## 🔐 Credenciais de Acesso (Dados de Teste)

A execução das migrações com a flag `--seed` gera automaticamente múltiplos perfis com diferentes níveis de privilégio (Role-Based Access Control), permitindo testar todas as áreas restritas da plataforma de forma imediata. 

A password predefinida para todas as contas de teste é: 123

Membros da Direção (Board / Admin)

```bash
b1@mail.pt
b2@mail.pt
b3@mail.pt
b4@mail.pt
```

Funcionários (Employee)

```bash
e1@mail.pt
e2@mail.pt
e3@mail.pt
e4@mail.pt
```

Membros Regulares / Sócios (Member)
```bash
m1@mail.pt
m2@mail.pt
m3@mail.pt
m4@mail.pt
```
