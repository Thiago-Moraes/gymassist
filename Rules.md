# Regras de Desenvolvimento - Projeto Laravel/Vue.js

Este documento define as regras e padrões de desenvolvimento a serem seguidos neste projeto. O objetivo é manter um código limpo, organizado e escalável, utilizando boas práticas de mercado.

## 1. Tecnologias

- **Backend:** Laravel (versão mais recente)
- **Frontend:** Vue.js (versão mais recente)
- **Ambiente:** Docker

## 2. Arquitetura

Adotamos os princípios do **Domain-Driven Design (DDD)** e da **Arquitetura Hexagonal**. A aplicação é dividida em três camadas principais:

1.  **Domain (Domínio):** O coração da aplicação. Contém a lógica de negócio, entidades, objetos de valor, eventos de domínio e interfaces de repositório. **Esta camada não depende de nenhuma outra.**
2.  **Application (Aplicação):** Orquestra o fluxo de dados e a execução dos casos de uso. Contém os *Application Services*. Depende apenas da camada de Domínio.
3.  **Infrastructure (Infraestrutura):** Contém os detalhes de implementação. Aqui ficam os controllers, as implementações dos repositórios (usando Eloquent), clientes de APIs externas, etc. Esta camada depende das outras duas.

### Estrutura de Pastas (Exemplo)

```
api/app/
├── Application/
│   └── User/
│       ├── CreateUser/
│       │   ├── CreateUserCommand.php
│       │   └── CreateUserService.php
│       └── ...
├── Domain/
│   └── User/
│       ├── Contract/
│       │   └── UserRepositoryInterface.php
│       ├── Entity/
│       │   └── User.php
│       └── Event/
│           └── UserCreated.php
└── Infrastructure/
    ├── Http/
    │   └── Controllers/
    │       └── UserController.php
    └── Persistence/
        └── Eloquent/
            └── UserRepository.php
```

## 3. Camadas e Responsabilidades

### Controllers (Infrastructure)

- Devem ser "magros" (*thin controllers*).
- Responsabilidade única: receber a requisição HTTP, validar os dados de entrada (usando Form Requests), chamar o `Service` correspondente e retornar uma resposta HTTP (JSON, view, etc.).
- **Não devem conter lógica de negócio.**

### Services (Application)

- Representam os casos de uso da aplicação (ex: `CreateUserService`, `UpdateProductService`).
- Orquestram a lógica de negócio, utilizando as entidades e os repositórios.
- Podem disparar eventos de domínio.
- Recebem DTOs (Data Transfer Objects) ou comandos como entrada.

### Repositories (Domain/Infrastructure)

- A **interface** do repositório (ex: `UserRepositoryInterface`) é definida na camada de **Domínio**.
- A **implementação** concreta (ex: `EloquentUserRepository`) fica na camada de **Infraestrutura**.
- São responsáveis pela persistência e recuperação de dados (consultas ao banco de dados).
- A injeção de dependência deve ser usada para que os `Services` dependam da interface, não da implementação.

## 4. Frontend (Vue.js)

- **Componentização:** Crie componentes pequenos, reutilizáveis e com responsabilidade única.
- **Gerenciamento de Estado:** Para estados complexos e compartilhados, utilize uma biblioteca como Pinia.
- **API Service:** Centralize todas as chamadas à API do backend em um único local (ex: `src/services/api.js`) para facilitar a manutenção.

## 5. Docker

- O ambiente de desenvolvimento local deve ser gerenciado pelo `docker-compose.yml`.
- O `Dockerfile` da aplicação deve ser otimizado para produção, utilizando multi-stage builds para reduzir o tamanho da imagem final.

## 6. Gerenciamento de Tarefas

Para cada nova funcionalidade ou atividade significativa:

1.  Um novo arquivo `.md` será criado na pasta `/tasks` com o nome da atividade (ex: `implementar-autenticacao.md`).
2.  Dentro deste arquivo, a atividade será quebrada em um checklist de subtarefas menores e gerenciáveis.
3.  A cada passo concluído, este arquivo será atualizado, marcando a subtarefa como feita (`[x]`).

Este processo garante visibilidade sobre o progresso e organiza o trabalho de forma clara.
