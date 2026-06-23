# 📰 Jornal Atlas — Sistema de Gestão de Notícias

Sistema web completo para postagem, revisão e publicação de notícias, desenvolvido como projeto acadêmico da disciplina de **Aplicações na Internet** (5° semestre, 2026).

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=flat&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)

---

<details open>
<summary><strong>1. Proposta e Objetivo</strong></summary>

### Proposta

O **Jornal Atlas** é um sistema de postagem de notícias composto por duas partes fundamentais:

1. **Site de Visualização** — Interface pública onde os visitantes leem notícias aprovadas, organizadas por categoria, seção e data de publicação.
2. **Área Administrativa** — Painel restrito com controle de sessão e de usuários, onde redatores criam notícias, revisores analisam e administradores gerenciam todo o sistema.

O projeto foi desenvolvido sem utilização de frameworks, empregando apenas **PHP puro**, **MySQL**, **HTML5**, **CSS3** e **JavaScript**, com o objetivo de demonstrar o domínio dos conceitos fundamentais de programação web, modelagem de dados e arquitetura de software.

### Objetivo Acadêmico

- Aplicar os conteúdos ministrados na disciplina de Aplicações na Internet (semestre 5°, 2026)
- Desenvolver um sistema funcional com autenticação, autorização e persistência de dados
- Demonstrar domínio de PHP, SQL, HTML, CSS e JavaScript em contexto real
- Documentar a modelagem do sistema, estrutura de código e regras de negócio

### Contexto

- **Disciplina:** Aplicações na Internet
- **Docente:** Eduardo Pareto
- **Período:** 5° semestre, 1° semestre de 2026
- **Formato:** Trabalho em grupo (máximo 4 alunos)

</details>

---

<details>
<summary><strong>2. Requisitos do Trabalho e Atendimento</strong></summary>

### Critérios de Avaliação e Evidências

| Critério | Nota | Como foi atendido |
|---|---|---|
| **Site de Visualização** | **3,0** | |
| Notícias mais novas e aprovadas | 1,0 | Homepage dinâmica com seções hero/nacional/internacional, ordenadas por `dataPublicacao DESC` |
| CSS elegante | 1,5 | Layout responsivo com design profissional, dark mode, carrossel, CKEditor 5 |
| Funcionamento geral | 0,5 | Rotas funcionais, busca em tempo real, navegação por categorias |
| **Site de Administração** | **7,0** | |
| Banco de Dados | 1,0 | 4 tabelas (Usuario, Noticia, Revisao, SolicitacaoCargo) com chaves estrangeiras |
| Cadastro de redatores e notícias | 2,0 | Formulários de cadastro/login, CRUD completo de notícias com CKEditor 5 |
| Gerenciamento de redatores | 1,5 | Painel de usuários (admin), exclusão, controle de permissões via 3 booleans |
| Gerenciamento da notícia | 2,5 | Criação, edição, exclusão, fluxo de revisão (aprovar/rejeitar/arquivar), reenvio |

### Requisitos Específicos Atendidos

| Requisito | Implementação |
|---|---|
| Sistema dividido em visualização e administração | Duas interfaces distintas: homepage pública e dashboard administrativo |
| Notícias da mais nova para a mais velha | `ORDER BY dataPublicacao DESC` em todas as queries públicas |
| Controle de sessão | `session_start()` + reidratação a cada requisição via `App::run()` |
| Controle de usuários | 4 perfis com permissões granulares (3 booleans) |
| Somente cadastrados podem redigir | `Auth::requireRedator()` em `NoticiaController` |
| Redatores com nome, nascimento, formação, email, assinatura | Tabela `Usuario` com todos os campos |
| Status 1-Escrita, 2-Aprovada, 3-Arquivada, 4-Rejeitada | Enum `StatusNoticia` com 5 valores (inclui RASCUNHO e EM_ANALISE) |
| Relacionamento 1:N entre Redator e Notícia | FK `redator_id` na tabela `Noticia` |
| Revisores com autorização para aprovar/rejeitar/arquivar | `Auth::requireRevisor()` + `RevisaoController` |

</details>

---

<details>
<summary><strong>3. Arquitetura e Estrutura do Projeto</strong></summary>

### Modelo Arquitetônico

O sistema adota uma arquitetura **MVC (Model-View-Controller)** com camada adicional de **Repository** para isolamento das consultas ao banco:

```
┌─────────────────────────────────────────────────┐
│                    CLIENTE                       │
│              (Browser do Usuário)                │
└─────────────────────┬───────────────────────────┘
                      │ HTTP Request
                      ▼
┌─────────────────────────────────────────────────┐
│              ROTAS (App.php)                     │
│         Switch na URL via $_GET['url']           │
└─────────────────────┬───────────────────────────┘
                      │
                      ▼
┌─────────────────────────────────────────────────┐
│            CONTROLLERS                          │
│   Recebe requisição, valida, delega              │
│   Auth → Verifica login/permissões               │
└──────────┬──────────────────────┬───────────────┘
           │                      │
           ▼                      ▼
┌──────────────────┐   ┌─────────────────────────┐
│    MODELS (DTO)  │   │    REPOSITORIES          │
│  Objetos puros   │   │  Queries SQL estáticas   │
│  Getters/Setters │   │  Hydratation → Models    │
└──────────────────┘   └────────────┬────────────┘
                                    │
                                    ▼
                         ┌─────────────────────┐
                         │    DATABASE (PDO)    │
                         │   Singleton PDO      │
                         └──────────┬──────────┘
                                    │
                                    ▼
                         ┌─────────────────────┐
                         │      MySQL           │
                         │  4 tabelas           │
                         └─────────────────────┘
```

### Padrões Utilizados

- **MVC** — Separção de responsabilidades entre rotas, controllers, models e views
- **Repository Pattern** — Todas as consultas SQL ficam isoladas em classes estáticas (`*Repository`), nunca nos models
- **Models como DTO** — Models são objetos puros com getters/setters, sem lógica de negócio ou acesso a banco
- **Autoloader PSR-4 manual** — Namespace `App\X\Y` resolve para `app/X/Y.php` sem Composer
- **Singleton Database** — Conexão PDO compartilhada via `Database::getInstance()`

### Árvore de Diretórios

```
AtlasJornal/
├── app/
│   ├── Controllers/        # 10 controllers (Auth, Home, Noticia, Revisão, etc.)
│   ├── Core/               # Infraestrutura (App, Auth, Autoloader, Database, Enums, Helpers)
│   ├── Models/             # 4 models (Usuario, Noticia, Revisao, SolicitacaoCargo)
│   ├── Repositories/       # 4 repositories (queries SQL)
│   └── Views/              # 20 views organizadas por contexto
│       ├── admin/
│       ├── auth/
│       ├── dashboard/
│       ├── errors/
│       ├── home/
│       ├── noticia/
│       ├── profile/
│       ├── revisao/
│       ├── solicitacao/
│       └── usuarios/
├── config/
│   ├── config.php             # Detecção de ambiente (local vs produção)
│   └── database.example.php   # Credenciais do banco por ambiente
│
├── database/
│   ├── schema.sql          # DDL (criação das tabelas)
│   ├── seed.sql            # Dados iniciais (2 usuários + 41 notícias)
│   └── seed.php            # Seed via PHP
├── docs/                   # Documentação (DER, Modelo Lógico)
└── public/
    ├── index.php           # Front controller (bootstrap)
    ├── .htaccess           # Reescrita de URL → index.php
    └── assets/
        ├── css/style.css   # ~6400 linhas de CSS (inclui dark mode)
        ├── js/script.js    # Carrossel, dark mode, busca, share
        └── img/            # Imagens do site
```

### Autoloader Personalizado

O projeto **não utiliza Composer**. O autoloader em `app/Core/Autoloader.php` resolve classes seguindo a convenção PSR-4:

```
App\Controllers\HomeController  →  app/Controllers/HomeController.php
App\Models\Noticia              →  app/Models/Noticia.php
App\Repositories\NoticiaRepository → app/Repositories/NoticiaRepository.php
App\Core\Database               →  app/Core/Database.php
```

Enums (`StatusNoticia`, `AcaoRevisao`, `CargoSolicitado`, `StatusSolicitado`) são mapeados explicitamente para `app/Core/Enums.php` via classmap.

</details>

---

<details>
<summary><strong>4. Banco de Dados</strong></summary>

### Diagrama Entidade-Relacionamento (DER)

```
┌──────────────┐       ┌──────────────────┐       ┌──────────────────┐
│   Usuario    │       │     Noticia       │       │    Revisao       │
├──────────────┤       ├──────────────────┤       ├──────────────────┤
│ id (PK)      │◄──┐   │ id (PK)          │◄──┐   │ id (PK)          │
│ nome         │   └───│ redator_id (FK)  │   └───│ noticia_id (FK)  │
│ nascimento   │       │ titulo           │       │ revisor_id (FK)  │──► Usuario
│ formacao     │       │ resumo           │       │ acaoRealizada    │
│ assinatura   │       │ conteudo         │       │ dataRevisao      │
│ email        │       │ imagem           │       │ observacao       │
│ senha        │       │ categoria        │       └──────────────────┘
│ foto         │       │ secao            │
│ podeRedigir  │       │ status           │
│ podeRevisar  │       │ dataCriacao      │
│ isAdmin      │       │ dataPublicacao   │
└──────────────┘       │ dataEdicao       │
       ▲               └──────────────────┘
       │                        ▲
       │    ┌───────────────────┘
       │    │
       │    │  ┌──────────────────────┐
       │    │  │  SolicitacaoCargo    │
       │    │  ├──────────────────────┤
       └────┼──│ id (PK)              │
            │  │ usuario_id (FK)      │──► Usuario
            │  │ admin_id (FK)        │──► Usuario (nullable)
            │  │ cargo                │
            │  │ status               │
            │  │ dataSolicitacao      │
            │  │ dataResposta         │
            │  │ observacao           │
            │  └──────────────────────┘
```

### Tabelas

#### `Usuario` — Cadastro de usuários do sistema

| Coluna | Tipo | Restrição | Descrição |
|---|---|---|---|
| `id` | INT | PK, AUTO_INCREMENT | Identificador único |
| `nome` | VARCHAR(100) | NOT NULL | Nome completo |
| `nascimento` | DATE | NOT NULL | Data de nascimento |
| `formacao` | VARCHAR(150) | NOT NULL | Formação acadêmica |
| `assinatura` | VARCHAR(150) | NOT NULL | Nome para publicação |
| `email` | VARCHAR(150) | NOT NULL, UNIQUE | E-mail (login) |
| `senha` | VARCHAR(255) | NOT NULL | Hash bcrypt da senha |
| `foto` | VARCHAR(255) | NULL | Caminho da foto de perfil |
| `podeRedigir` | BOOLEAN | DEFAULT FALSE | Pode criar notícias |
| `podeRevisar` | BOOLEAN | DEFAULT FALSE | Pode revisar notícias |
| `isAdmin` | BOOLEAN | DEFAULT FALSE | Acesso total ao sistema |

#### `Noticia` — Notícias do sistema

| Coluna | Tipo | Restrição | Descrição |
|---|---|---|---|
| `id` | INT | PK, AUTO_INCREMENT | Identificador único |
| `redator_id` | INT | FK → Usuario(id) | Autor da notícia |
| `titulo` | VARCHAR(200) | NOT NULL | Título da notícia |
| `resumo` | VARCHAR(500) | NOT NULL | Resumo para cards |
| `conteudo` | TEXT | NOT NULL | Conteúdo completo (HTML via CKEditor) |
| `imagem` | VARCHAR(255) | NULL | Imagem de capa |
| `categoria` | VARCHAR(50) | NOT NULL | Categoria (POLÍTICA, ESPORTES, etc.) |
| `secao` | ENUM | NOT NULL | hero, nacional ou internacional |
| `status` | ENUM | DEFAULT 'RASCUNHO' | RASCUNHO, EM_ANALISE, APROVADA, ARQUIVADA, REJEITADA |
| `dataCriacao` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Data de criação |
| `dataPublicacao` | DATETIME | NULL | Data de publicação (setada na aprovação) |
| `dataEdicao` | DATETIME | NULL | Última edição |

#### `Revisao` — Histórico de revisões

| Coluna | Tipo | Restrição | Descrição |
|---|---|---|---|
| `id` | INT | PK, AUTO_INCREMENT | Identificador único |
| `revisor_id` | INT | FK → Usuario(id) | Revisor responsável |
| `noticia_id` | INT | FK → Noticia(id) | Notícia revisada |
| `acaoRealizada` | ENUM | NOT NULL | APROVAR, REJEITAR, ARQUIVAR, SOLICITAR_CORRECAO |
| `dataRevisao` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Data da revisão |
| `observacao` | TEXT | NULL | Observação do revisor |

#### `SolicitacaoCargo` — Solicitações de upgrade de cargo

| Coluna | Tipo | Restrição | Descrição |
|---|---|---|---|
| `id` | INT | PK, AUTO_INCREMENT | Identificador único |
| `usuario_id` | INT | FK → Usuario(id) | Usuário solicitante |
| `admin_id` | INT | FK → Usuario(id), NULL | Admin que respondeu |
| `cargo` | ENUM | DEFAULT 'REDATOR' | REDATOR ou REVISOR |
| `status` | ENUM | DEFAULT 'EM_ANALISE' | EM_ANALISE, APROVADA, REJEITADA |
| `dataSolicitacao` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Data da solicitação |
| `dataResposta` | DATETIME | NULL | Data da resposta |
| `observacao` | TEXT | NULL | Observação do admin |

### Dados Iniciais (Seed)

| Usuário | Email | Senha | Cargo |
|---|---|---|---|
| Eduardo P. | admin@jornalatlas.com | admin123 | Administrador |
| Maria Silva | revisor@jornalatlas.com | revisor123 | Revisor |

+ 41 notícias de exemplo distribuídas em 8 categorias (POLÍTICA, ECONOMIA, SAÚDE, ESPORTES, TECNOLOGIA, MUNDO, CULTURA, CIÊNCIA), cada uma com 1 hero e 4-5 notícias regulares.

</details>

---

<details>
<summary><strong>5. Regras de Negócio</strong></summary>

### Perfis de Usuário

O sistema possui 4 perfis de acesso, definidos por 3 permissões booleanas:

| Cargo | podeRedigir | podeRevisar | isAdmin | Descrição |
|---|---|---|---|---|
| **Leitor** | false | false | false | Apenas lê notícias públicas |
| **Redator** | true | false | false | Cria e edita suas próprias notícias |
| **Revisor** | true | true | false | Revisa notícias de outros redatores + cria as próprias |
| **Administrador** | true | true | true | Acesso total: gerencia usuários, notícias e solicitações |

### Fluxo de uma Notícia

```
RASCUNHO ──► EM_ANALISE ──► APROVADA (dataPublicacao = NOW())
    │              │
    │              ├──► REJEITADA ──► RASCUNHO (reenvio) ──► EM_ANALISE ...
    │              │
    │              └──► ARQUIVADA ──► RASCUNHO (reenvio) ──► EM_ANALISE ...
    │
    └──► EXCLUÍDA (somente pelo autor, se rascunho)
```

- **Rascunho:** Notícia em criação. Somente o autor pode editar ou excluir.
- **Em Análise:** Enviada para revisão. Revisor pode aprovar, rejeitar ou arquivar.
- **Aprovada:** Publicada no site. `dataPublicacao` é setada automaticamente.
- **Rejeitada:** Pode ser reenviada pelo autor, voltando para "Em Análise".
- **Arquivada:** Pode ser reenviada pelo autor, voltando para "Em Análise".

### Regras de Revisão

1. **Auto-revisão bloqueada:** Um redator não pode revisar a própria notícia (exceção: administradores)
2. **Edição pelo revisor:** Revisores podem editar notícias durante a análise
3. **Revisão salva:** Após editar no painel de revisão, o revisor é redirecionado de volta para `/revisao?noticia={id}`
4. **Edição de status:** Se uma notícia APROVADA/REJEITADA/ARQUIVADA for editada pelo autor, seu status volta automaticamente para EM_ANALISE

### Fluxo de Solicitação de Cargo

```
LEITOR ──► solicita REDATOR (precisa de formação + assinatura preenchidos)
              │
              ├──► APROVADA → Permissões atualizadas automaticamente
              │
              └──► REJEITADA → Usuário pode solicitar novamente

REDATOR ──► solicita REVISOR
              │
              ├──► APROVADA → Permissões atualizadas
              │
              └──► REJEITADA → Usuário pode solicitar novamente
```

- Usuários com cargo máximo (revisor/administrador) não podem solicitar upgrade
- Somente uma solicitação pendente por vez
- Administração visualiza, aprova ou rejeita com observação

### Regras de Exclusão

- **Notícias:** Somente o autor pode excluir rascunhos. Administradores podem excluir qualquer notícia.
- **Usuários:** Somente administradores podem excluir. Não é possível excluir a própria conta.

</details>

---

<details>
<summary><strong>6. Configuração em Ambiente Local</strong></summary>

### Pré-requisitos

| Software | Versão Mínima | Onde baixar |
|---|---|---|
| PHP | 8.0+ (recomendado 8.4) | [php.net](https://www.php.net/downloads.php) |
| MySQL | 5.7+ ou MariaDB 10.3+ | [dev.mysql.com](https://dev.mysql.com/downloads/mysql/) |
| Servidor Web | Apache (incluído nos pacotes abaixo) | Ou PHP embutido |

> **Nota:** O PHP pode ser instalado independentemente (sem XAMPP/WAMP) para quem prefere usar o servidor embutido (`php -S`).

---

### Configuração Automática do Banco (Recomendado)

O projeto inclui um script PHP que cria o banco, as tabelas e popula os dados iniciais automaticamente:

```bash
# 1. Navegue até a pasta do projeto
cd AtlasJornal

# 2. Execute o setup (cria banco + tabelas + dados)
php database/setup.php
```

**O que o script faz:**
1. Conecta ao MySQL com as credenciais padrão (root sem senha)
2. Cria o banco `jornal_atlasdb` se não existir
3. Executa `database/schema.sql` (criação das 4 tabelas, idempotente com `IF NOT EXISTS`)
4. Limpa as tabelas existentes (TRUNCATE) para evitar duplicatas
5. Executa `database/seed.php` (2 usuários + 41 notícias)

> **Seguro para executar várias vezes:** O script é idempotente — pode ser executado novamente a qualquer momento sem erros. Ele recria os dados do zero.

> **Nota:** Se você alterou a senha do MySQL, edite as variáveis `$user` e `$password` no topo de `database/setup.php` antes de executar.

---

### Configuração Manual do Banco

Se preferir configurar manualmente, use **phpMyAdmin** ou **MySQL Workbench**:

#### Via phpMyAdmin

1. Acesse `http://localhost/phpmyadmin`
2. Aba "Banco de dados" → Nome: `jornal_atlasdb` → Criar
3. Aba "SQL" → Cole o conteúdo de `database/schema.sql` → Executar
4. Aba "SQL" → Cole o conteúdo de `database/seed.sql` → Executar

#### Via MySQL Workbench

1. [Baixe e instale](https://dev.mysql.com/downloads/workbench/) o MySQL Workbench
2. Conecte ao servidor MySQL local (credenciais padrão: root sem senha)
3. Aba "Query" → Execute o conteúdo de `database/schema.sql`
4. Execute o conteúdo de `database/seed.sql`

> **Vantagem do MySQL Workbench:** Interface desktop completa com visualização de ER, debugger de queries e gerenciamento de usuários do MySQL.

---

### Opção 1: WAMP Server

1. **Baixe e instale** o [WampServer](https://www.wampserver.com/) (versão 64-bit)
2. **Inicie o WAMP** — ícone verde na bandeja do sistema
3. **Configure o banco:**
   - **Automático:** Execute `php database/setup.php` no terminal
   - **Manual:** Acesse phpMyAdmin e execute os SQLs manualmente
4. **Copie a pasta do projeto** para `C:\wamp64\www\AtlasJornal`
5. **Acesse:** `http://localhost/AtlasJornal/public/`

---

### Opção 2: XAMPP

1. **Baixe e instale** o [XAMPP](https://www.apachefriends.org/)
2. **Inicie** o Apache e o MySQL no painel do XAMPP
3. **Configure o banco:**
   - **Automático:** Execute `php database/setup.php` no terminal
   - **Manual:** Acesse phpMyAdmin e execute os SQLs manualmente
4. **Copie a pasta** para `C:\xampp\htdocs\AtlasJornal`
5. **Acesse:** `http://localhost/AtlasJornal/public/`

---

### Opção 3: Laragon

1. **Baixe e instale** o [Laragon](https://laragon.org/) (versão Full)
2. **Inicie** o Apache e o MySQL (botão "Start All")
3. **Configure o banco:**
   - **Automático:** Execute `php database/setup.php` no terminal
   - **Manual:** Clique com botão direito → Database → phpMyAdmin e execute os SQLs
4. **Copie a pasta** para `C:\laragon\www\AtlasJornal`
5. **Acesse:** `http://localhost/AtlasJornal/public/`

> **Vantagem do Laragon:** Criador automático de hosts virtuais. Você pode acessar via `http://atlasjornal.test` configurando o virtual host.

---

### Opção 4: PHP Embutido (sem pacote)

Para quem tem PHP instalado separadamente (via `choco`, `scoop`, ou download direto):

```bash
# 1. Configure o banco primeiro
cd AtlasJornal
php database/setup.php

# 2. Navegue até a pasta public
cd public

# 3. Inicie o servidor embutido na porta 8000
php -S localhost:8000

# 4. Acesse
# http://localhost:8000
```

> **Importante:** O PHP embutido **não processa `.htaccess`**. Para acessar as rotas, use o parâmetro `?url=`:
> - `http://localhost:8000/?url=login`
> - `http://localhost:8000/?url=categoria/POLITICA`
> - `http://localhost:8000/?url=noticia/1`

Ou configure um Apache/Nginx com `mod_rewrite` habilitado para reescrita de URL.

---

### Gerenciadores de Banco de Dados

| Ferramenta | Tipo | Acesso | Observação |
|---|---|---|---|
| **phpMyAdmin** | Web | `http://localhost/phpmyadmin` | Incluído nos pacotes WAMP/XAMPP/Laragon |
| **MySQL Workbench** | Desktop | App independente | [Download](https://dev.mysql.com/downloads/workbench/) — mais completo para gerenciamento |
| **Laragon** | Desktop | Clique direito → Database | Inclui phpMyAdmin e HeidiSQL |

---

### Configuração do Banco (Ambiente Local)

O arquivo `config/database.php` detecta automaticamente o ambiente e usa credenciais locais:

```php
// config/database.php
if (APP_ENV === 'local') {
    return [
        'host'     => 'localhost',
        'database' => 'jornal_atlasdb',
        'user'     => 'root',
        'password' => '',
    ];
}
```

**Credenciais padrão por servidor:**

| Servidor | Usuário | Senha | Host |
|---|---|---|---|
| WAMP | root | *(vazio)* | localhost |
| XAMPP | root | *(vazio)* | localhost |
| Laragon | root | *(vazio)* | localhost |
| PHP embutido | root | *(vazio)* | localhost |

> **Nota:** Se você alterou a senha do MySQL no phpMyAdmin, atualize o campo `password` em `config/database.php` **e** em `database/setup.php`.

---

### Contas de Teste

| Perfil | Email | Senha |
|---|---|---|
| Administrador | admin@jornalatlas.com | admin123 |
| Revisor | revisor@jornalatlas.com | revisor123 |

</details>

---

<details>
<summary><strong>7. Ambiente Hospedado</strong></summary>

### Por que o InfinityFree?

O [InfinityFree](https://infinityfree.com/) foi escolhido como hospedagem por oferecer:

- **PHP 8.x e MySQL** gratuitamente, compatível com os requisitos do projeto
- **Suporte a `.htaccess`** com `mod_rewrite`, essencial para o sistema de rotas
- **Painel de controle** com phpMyAdmin para gerenciamento do banco
- **Sem necessidade de cartão de crédito**, ideal para projetos acadêmicos
- **Subdomínio gratuito** para acesso público ao sistema

### Estrutura de Deploy

No InfinityFree, a pasta do projeto é acessada diretamente pela raiz pública. A solução utilizada foi criar um `.htaccess` na **raiz do projeto** que redireciona tudo para `public/`:

```
AtlasJornal/                  ← Raiz acessada pelo servidor
├── .htaccess                 ← Redireciona para public/
├── app/                      ← Protegido (bloqueado pelo .htaccess)
├── config/                   ← Protegido
├── database/                 ← Protegido
└── public/                   ← Pasta pública (entry point)
    ├── .htaccess             ← Reescrita de URL
    └── index.php             ← Front controller
```

### Roteamento Dinâmico

O sistema detecta automaticamente se está rodando localmente ou em produção, ajustando o `BASE_URL` e as credenciais do banco:

#### Detecção de Ambiente (`config/config.php`)

```php
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

$isLocal = str_contains($host, 'localhost')
        || str_contains($host, '127.0.0.1');

define('APP_ENV', $isLocal ? 'local' : 'production');

if (APP_ENV === 'local') {
    // Local: precisa acessar a pasta public/ manualmente
    define('BASE_URL', '/AtlasJornal/public');
} else {
    // Produção: .htaccess já redireciona para public/
    define('BASE_URL', '');
}
```

#### Credenciais do Banco (`config/database.example.php`)

```php
if (APP_ENV === 'local') {
    return [
        'host'     => 'localhost',
        'database' => 'jornal_atlasdb',
        'user'     => 'root',
        'password' => '',
    ];
}

// Produção (InfinityFree)
return [
    'host'     => '**********************',
    'database' => '**********************',
    'user'     => '**************',
    'password' => '***********',
];
```

#### Reescrita de URL (`.htaccess` na raiz)

```apache
# Bloquear acesso direto a pastas sensíveis
RewriteRule ^(app|config|database)(/.*)?$ - [F,L]

# Redirecionar tudo para public/
RewriteRule ^$ public/ [L]
RewriteRule (.*) public/$1 [L]
```

#### Reescrita de URL (`public/.htaccess`)

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
```

### Fluxo Completo de Requisição

```
Requisição HTTP
    │
    ▼
.htaccess (raiz) ──► Redireciona para public/
    │
    ▼
public/.htaccess ──► Redireciona para index.php?url=...
    │
    ▼
index.php ──► config.php detecta APP_ENV
    │           ├── local → BASE_URL = '/AtlasJornal/public'
    │           └── production → BASE_URL = ''
    │
    ▼
App.php ──► Extrai rota de $_GET['url']
    │         ├── '' → HomeController::index()
    │         ├── 'login' → AuthController::login()
    │         ├── 'noticia/1' → HomeController::show(1)
    │         └── ...
    │
    ▼
Controller ──► Repository ──► Database ──► MySQL
    │
    ▼
View ──► url() e asset() usam BASE_URL para gerar links corretos
```



</details>

---

<details>
<summary><strong>8. Métodos HTTP e Rotas</strong></summary>

### Rotas Públicas (Sem autenticação)

| Método | Rota | Controller | Método | Descrição |
|---|---|---|---|---|
| GET | `/` | HomeController | `index()` | Homepage |
| GET | `/home` | HomeController | `index()` | Homepage (alias) |
| GET | `/sobre` | HomeController | `sobre()` | Página Sobre Nós |
| GET | `/anuncie` | HomeController | `anuncie()` | Página de anúncios |
| GET | `/contato` | HomeController | `contato()` | Página de contato |
| GET | `/codigo-de-etica` | HomeController | `institucional()` | Código de ética |
| GET | `/trabalhe-conosco` | HomeController | `institucional()` | Trabalhe conosco |
| GET | `/termos-de-uso` | HomeController | `institucional()` | Termos de uso |
| GET | `/politica-de-privacidade` | HomeController | `institucional()` | Política de privacidade |
| GET | `/suporte` | HomeController | `institucional()` | Suporte |
| GET | `/categoria/{slug}` | CategoryController | `index()` | Notícias por categoria |
| GET | `/busca?q=` | HomeController | `busca()` | Resultados de busca |
| GET | `/noticia/{id}` | HomeController | `show()` | Visualizar notícia |

### Autenticação

| Método | Rota | Controller | Método | Descrição |
|---|---|---|---|---|
| GET | `/login` | AuthController | `login()` | Formulário de login |
| POST | `/login` | AuthController | `authenticate()` | Processar login |
| GET | `/cadastro` | AuthController | `cadastro()` | Formulário de cadastro |
| POST | `/cadastro` | AuthController | `register()` | Processar cadastro |
| GET | `/logout` | AuthController | `logout()` | Encerrar sessão |

### Redator (podeRedigir = true)

| Método | Rota | Controller | Método | Descrição |
|---|---|---|---|---|
| GET | `/noticia/nova` | NoticiaController | `create()` | Formulário de nova notícia |
| POST | `/noticia/nova` | NoticiaController | `store()` | Criar notícia |
| GET | `/noticia/minhas` | NoticiaController | `minhas()` | Minhas notícias |
| GET | `/noticia/{id}/editar` | NoticiaController | `edit()` | Formulário de edição |
| POST | `/noticia/{id}/editar` | NoticiaController | `update()` | Atualizar notícia |
| GET | `/noticia/{id}/publicar` | NoticiaController | `publicar()` | Enviar para revisão |
| GET | `/noticia/{id}/reenviar` | NoticiaController | `reenviar()` | Reenviar para revisão |
| GET | `/noticia/{id}/excluir-rascunho` | NoticiaController | `excluirRascunho()` | Excluir rascunho |
| GET | `/revisao` | RevisaoController | `index()` | Painel de revisão (redator vê suas notícias) |
| GET | `/perfil` | ProfileController | `index()` | Meu perfil |
| POST | `/perfil` | ProfileController | `update()` | Atualizar perfil |
| POST | `/perfil/solicitar` | ProfileController | `solicitar()` | Solicitar upgrade de cargo |

### Revisor (podeRevisar = true)

| Método | Rota | Controller | Método | Descrição |
|---|---|---|---|---|
| GET | `/revisao` | RevisaoController | `index()` | Painel de revisão (todas as pendentes) |
| GET | `/revisao/aprovar/{id}` | RevisaoController | `aprovar()` | Aprovar notícia |
| GET | `/revisao/rejeitar/{id}` | RevisaoController | `rejeitar()` | Rejeitar notícia |
| GET | `/revisao/arquivar/{id}` | RevisaoController | `arquivar()` | Arquivar notícia |
| GET | `/admin/noticias` | AdminNoticiaController | `index()` | Gerenciar notícias |

### Administrador (isAdmin = true)

| Método | Rota | Controller | Método | Descrição |
|---|---|---|---|---|
| GET | `/dashboard` | DashboardController | `index()` | Dashboard com estatísticas |
| GET | `/admin/noticias` | AdminNoticiaController | `index()` | Lista de todas as notícias |
| GET | `/admin/noticias/excluir/{id}` | AdminNoticiaController | `delete()` | Excluir notícia |
| GET | `/admin/usuarios` | UsuarioController | `index()` | Gerenciar usuários |
| GET | `/admin/usuarios/excluir/{id}` | UsuarioController | `delete()` | Excluir usuário |
| GET | `/solicitacoes` | SolicitacaoController | `index()` | Gerenciar solicitações de cargo |
| GET | `/solicitacoes/aprovar/{id}` | SolicitacaoController | `aprovar()` | Aprovar solicitação |
| GET | `/solicitacoes/rejeitar/{id}` | SolicitacaoController | `rejeitar()` | Rejeitar solicitação |

</details>

---

<details>
<summary><strong>9. Fluxo de Uso</strong></summary>

### Fluxo Principal: Publicação de uma Notícia

```
1. CADASTRO
   Usuário acessa /cadastro → preenche dados → conta criada (leitor)

2. SOLICITAÇÃO DE CARGO
   Usuário acessa /perfil → clica "Solicitar Cargo" → escolhe REDATOR
   (precisa ter formação e assinatura preenchidos)

3. APROVAÇÃO DO CARGO
   Administrador acessa /solicitacoes → aprova solicitação
   Permissões do usuário são atualizadas automaticamente

4. CRIAÇÃO DA NOTÍCIA
   Redator acessa /noticia/nova → preenche:
   - Título, resumo, conteúdo (CKEditor 5), imagem, categoria, seção
   - Escolhe: "Salvar Rascunho" ou "Enviar para Análise"

5. REVISÃO
   Revisor acessa /revisao → vê notícias pendentes
   - Pode visualizar, editar, aprovar, rejeitar ou arquivar
   - Ao aprovar: dataPublicacao = NOW(), status = APROVADA

6. PUBLICAÇÃO
   Notícia aparece automaticamente na homepage
```

### Fluxo: Solicitação de Cargo

```
1. LEITOR → REDATOR
   /perfil → "Solicitar Cargo" → Solicitação criada (EM_ANALISE)
   /solicitacoes → Admin aprova → Permissões atualizadas

2. REDATOR → REVISOR
   /perfil → "Solicitar Cargo" → Solicitação criada (EM_ANALISE)
   /solicitacoes → Admin aprova → Permissões atualizadas

3. REVISOR → (já é cargo máximo, botão desabilitado)
```

### Fluxo: Reenvio de Notícia Rejeitada/Arquivada

```
1. Redator vê sua notícia rejeitada/arquivada em /noticia/minhas
2. Clica em "Revisar" ou acessa /noticia/{id}/editar
3. Edita o conteúdo conforme observação do revisor
4. Clica "Reenviar para Análise" → status volta para EM_ANALISE
5. Revisor analisa novamente
```

</details>

---

<details>
<summary><strong>10. Tecnologias Utilizadas</strong></summary>

| Tecnologia | Versão | Uso |
|---|---|---|
| **PHP** | 8.4 | Linguagem principal (backend) |
| **MySQL** | 8.x | Banco de dados relacional |
| **HTML5** | - | Estrutura das páginas |
| **CSS3** | - | Estilização (dark mode, responsivo) |
| **JavaScript** | ES6+ | Carrossel, dark mode toggle, busca em tempo real, share |
| **CKEditor 5** | 41.4.2 | Editor rico de texto para criação/edição de notícias |
| **Font Awesome** | 6.7.2 | Ícones em todo o sistema |
| **Google Fonts** | - | Playfair Display (títulos) + Inter (corpo) |

### Infraestrutura

| Componente | Tecnologia |
|---|---|
| Servidor local | WAMP / XAMPP / Laragon / PHP built-in |
| Hospedagem | InfinityFree (gratuito) |
| IDE | Visual Studio Code |
| Controle de versão | Git + GitHub |
| Autoloader | PSR-4 personalizado (sem Composer) |

</details>

---

<details>
<summary><strong>11. Integrantes</strong></summary>

| Nome | Matrícula |
|---|---|
| Vinicius Luis da Silva | 1250109403 |
| Gabriel Garcia Gonçalves de Carvalho | 1250202190 |
| João Vitor Tostes de Souza | 1250106169 |
| Guilherme Silva Timas Soares | 1250111076 |

**Orientador:** Eduardo Pareto — Disciplina de Aplicações na Internet

</details>

---

<p align="center">
  <sub>Disciplina de Aplicações na Internet — 5° Semestre — UVA 2026</sub>
</p>
