# Sistema de Gerenciamento de Contatos - Fruitfy

## Como executar o projeto

1. **Clonar o repositório**

   ```bash
   git clone https://github.com/LucasSch2410/junior-backend-test.git
   cd junior-backend-test
   ```

2. **Instalar dependências do PHP**

   ```bash
   composer install
   ```

3. **Configurar ambiente**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configurar banco de dados**
   ```bash
   touch database/database.sqlite
   ```

5. **Executar migrações**

   ```bash
   php artisan migrate
   ```

6. **Instalar dependências frontend**

   ```bash
   npm install
   npm run build
   ```

7. **Iniciar servidor de desenvolvimento**

   ```bash
   php artisan serve
   ```

   Acesse: [http://localhost:8000/contacts](http://localhost:8000/contacts)

## 📋 Rotas disponíveis

- `GET /contacts` — Lista todos os contatos (com paginação)
- `POST /contacts` — Cria um novo contato
- `PUT /contacts/{contact}` — Atualiza um contato existente
- `DELETE /contacts/{contact}` — Remove um contato

## ✨ Funcionalidades

- **CRUD completo** de contatos
- **Busca** por nome, e-mail, telefone e notas
- **Paginação** com 10 itens por página
- **Validação** de formulários
- **Notificações por e-mail** ao excluir contatos
- **Interface responsiva** com PrimeVue

## 🛠️ Tecnologias utilizadas

- **Backend**: Laravel 11
- **Frontend**: Vue 3, Inertia.js, PrimeVue, TypeScript
- **Banco de Dados**: SQLite
- **Estilização**: TailwindCSS
- **Ferramentas de Desenvolvimento**: Vite, Composer, npm

## 📝 Notas de desenvolvimento

- O projeto segue os padrões do Laravel
- Código limpo e organizado
- Documentação clara e objetiva
- Fácil manutenção e extensão
- Tipagem com TypeScript

## 📬 Contato

Em caso de dúvidas ou sugestões, entre em contato:
- **Nome**: Lucas Schroeder
- **E-mail**: [seu-email@exemplo.com](mailto:lucasschroeder2410@gmail.com)
- **GitHub**: [LucasSch2410](https://github.com/LucasSch2410)

---

Desenvolvido com ❤️ por Lucas
