# Laravel 10 Task Manager

Um gerenciador de tarefas simples desenvolvido com Laravel 10. A aplicação utiliza banco de dados SQLite para facilitar o setup local e Mailtrap para o envio de e-mails durante o desenvolvimento.

## Requisitos

Para rodar o projeto, você precisa ter instalado:

- **PHP >= 8.1**
- **Composer**
- **Extensões PHP**:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
- **Node.js e npm** (caso deseje compilar assets front-end)

## Instalação Passo a Passo

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/seu-projeto.git
cd seu-projeto
```

### 2. Instale as dependências PHP

```bash
composer install
```

### 3. Configure o ambiente

Copie o arquivo `.env.example`:

```bash
cp .env.example .env
```

Edite o arquivo `.env` e atualize as seguintes configurações:

#### Banco de Dados SQLite

```env
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/completo/para/database/database.sqlite
```

> **Importante**: crie o arquivo SQLite vazio se ainda não existir:

```bash
mkdir -p database
touch database/database.sqlite
```

#### Mailtrap para envio de e-mails

Crie uma conta gratuita no [Mailtrap.io](https://mailtrap.io/), acesse seu inbox e configure:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario_mailtrap
MAIL_PASSWORD=sua_senha_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=admin@suaplicacao.com
MAIL_FROM_NAME="Task Manager"
```

Substitua `MAIL_USERNAME` e `MAIL_PASSWORD` com suas credenciais reais da Mailtrap.

### 4. Gere a key da aplicação

```bash
php artisan key:generate
```

### 5. Rode as migrações e seeders (se existirem)

```bash
php artisan migrate
php artisan db:seed # opcional, se quiser popular dados iniciais
```

### 6. Suba o servidor local

```bash
php artisan serve
```

Acesse a aplicação em [http://localhost:8000](http://localhost:8000)

---

## Compilação Frontend (Opcional)

Se estiver usando Laravel Mix ou Vite:

```bash
npm install
npm run dev
```
