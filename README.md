# Sistema de Gerenciamento de Contatos - Fruitfy

Este é um sistema completo para gerenciamento de contatos, instalei docker para melhor compatibilidade e agilidade.

## Como configurar o projeto

Antes de iniciar, você precisa realizar a configuração inicial:

1.  **Clonar o repositório**

    ```bash
    git clone https://github.com/LucasSch2410/junior-backend-test.git
    cd junior-backend-test
    ```

2.  **Configurar as variáveis de ambiente**

    Copie o arquivo de exemplo e gere a chave:

    ```bash
    cp .env.example .env
    ```

## Iniciar o projeto

Após a configuração inicial, você pode iniciar o projeto de duas maneiras. Escolha a sua preferida:

* **[🐳 Executar com Docker](#-executando-com-docker)** (Recomendado, mais simples)
* **[⚙️ Executar Manualmente](#-executando-manualmente)** (Requer PHP e Node.js instalados)

<<<<<<< HEAD
   ```bash
   npm install
   npm run dev
   ```
=======
---
>>>>>>> d391d12 (feat(docker): new docker environment)

### ⚙️ Executando Manualmente

Se preferir não usar Docker, siga os passos abaixo para rodar o projeto localmente.

1.  **Instalar dependências do PHP**

    ```bash
    composer install
    ```

2.  **Instalar dependências do Frontend**

    ```bash
    npm install
    npm run build
    ```

3.  **Configurar banco de dados**

    Crie o arquivo do banco de dados SQLite.

    ```bash
    touch database/database.sqlite
    ```

4.  **Executar as Migrations**

    Este comando criará as tabelas necessárias no banco de dados.

    ```bash
    php artisan migrate
    ```

5.  **Iniciar o servidor de desenvolvimento**

    ```bash
    php artisan serve
    ```

    Após executar o comando, acesse: **[http://localhost:8000/contacts](http://localhost:8000/contacts)**

---

### 🐳 Executando com Docker

Este é o método mais fácil para subir o ambiente completo. As dependências são baixadas em tempo de execução, então aguarde um momento após o comando ser finalizado.

1.  **Execute o Docker Compose**

    ```bash
    docker-compose up -d
    ```

2.  **Acesse a aplicação**

    O comando irá configurar tudo o que é necessário e disponibilizar a aplicação em: **[http://localhost:8000/contacts](http://localhost:8000/contacts)**

> **Nota:** Certifique-se de que o Docker e o Docker Compose estejam instalados e em execução na sua máquina.

## 📋 Rotas disponíveis

-   `GET /contacts` — Lista todos os contatos (com paginação e busca)
-   `POST /contacts` — Cria um novo contato
-   `PUT /contacts/{contact}` — Atualiza um contato existente
-   `DELETE /contacts/{contact}` — Remove um contato e envia o e-mail de aviso ao Admin

## ✨ Funcionalidades

-   **CRUD completo** de contatos
-   **Busca** por nome, e-mail, telefone e notas
-   **Paginação** com 10 itens por página
-   **Validação** de formulários
-   **Notificações por e-mail** ao excluir contatos
-   **Interface responsiva** com PrimeVue

## 🛠️ Tecnologias utilizadas

-   **Backend**: Laravel 11
-   **Frontend**: Vue 3, Inertia.js, PrimeVue, TypeScript
-   **Banco de Dados**: SQLite
-   **Estilização**: TailwindCSS
-   **Ferramentas de Desenvolvimento**: Vite, Composer, npm

## 📝 Notas de desenvolvimento

-   O projeto segue os padrões do Laravel
-   Código limpo e organizado
-   Documentação clara e objetiva
-   Fácil manutenção e extensão
-   Tipagem com TypeScript

## 📬 Contato

Em caso de dúvidas ou sugestões, entre em contato:

-   **Nome**: Lucas Schroeder
-   **E-mail**: [lucasschroeder2410@gmail.com](mailto:lucasschroeder2410@gmail.com)
-   **GitHub**: [LucasSch2410](https://github.com/LucasSch2410)

---

Desenvolvido com ❤️ por Lucas
