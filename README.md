<p align="center">
<a href="https://img.shields.io/badge/PHP-8.3-blue"><img src="https://img.shields.io/badge/PHP-8.3-blue?logo=php" alt="PHP 8.3"></a>
<a href="https://img.shields.io/badge/Laravel-13-red"><img src="https://img.shields.io/badge/Laravel-13-red?logo=laravel" alt="Laravel 13"></a>
<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/license-MIT-green" alt="MIT License"></a>
</p>

# HelpDesk Lite

> Sistema leve de chamados para pequenas equipes acompanharem solicitações, prioridades, status e histórico de atendimento.

---

## O problema que resolve

Pequenas equipes perdem tempo gerenciando solicitações por e-mail, WhatsApp ou planilhas. O HelpDesk Lite centraliza tudo em um único lugar com rastreabilidade completa, histórico de atendimento e visibilidade de prioridades.

## Para quem é?

- Pequenas empresas com equipe de suporte interno
- Freelancers que atendem múltiplos clientes
- Agências digitais e software houses
- Recrutadores avaliando portfólio Laravel moderno

---

## Funcionalidades

- **Gestão de Chamados** — criação, edição, acompanhamento e histórico completo
- **Dashboard** — visão geral em tempo real com contadores por status e prioridade
- **Prioridades** — Baixa, Média, Alta e Crítica com badges coloridos
- **Status** — Aberto, Em Andamento, Aguardando Resposta, Resolvido e Fechado
- **Perfis de Acesso** — Admin, Atendente e Solicitante com permissões distintas
- **Comentários** — histórico de interações com suporte a notas internas
- **Filtros Avançados** — busca por título, status, prioridade, categoria e responsável
- **Categorias** — organização dos chamados por área (Infraestrutura, Software, RH etc.)
- **REST API** — endpoints para integração com sistemas externos (autenticado via Sanctum)
- **Numeração automática** — chamados com numeração única no formato `HD-2024-0001`

---

## Stack tecnológico

| Camada | Tecnologia |
|--------|-----------|
| Framework | Laravel 13.x |
| Linguagem | PHP 8.3 |
| Frontend Reativo | Livewire 4.x |
| CSS | Tailwind CSS 4.x |
| JavaScript | Alpine.js |
| Banco de Dados | SQLite (padrão) / MySQL |
| Autenticação | Laravel Breeze + Sanctum |
| Testes | Pest 4.x |
| Build | Vite |

---

## Início Rápido

### Pré-requisitos

- PHP 8.2+ com extensões: `pdo_sqlite`, `mbstring`, `openssl`, `curl`, `fileinfo`, `zip`
- Composer
- Node.js 18+

### Instalação

```bash
# Clonar o repositório
git clone https://github.com/gersonvinicius/laravel-helpdesk-lite.git
cd laravel-helpdesk-lite

# Instalar dependências PHP
composer install

# Instalar dependências JS e fazer o build
npm install && npm run build

# Copiar o arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Criar o banco de dados e executar as migrations com dados de demonstração
php artisan migrate:fresh --seed

# Iniciar o servidor de desenvolvimento
php artisan serve
```

Acesse: [http://localhost:8000](http://localhost:8000)

---

## Usuários de demonstração

| Perfil | E-mail | Senha | Permissões |
|--------|--------|-------|-----------|
| Admin | admin@example.com | password | Acesso total |
| Atendente | atendente@example.com | password | Gerencia e atende chamados |
| Solicitante | solicitante@example.com | password | Cria e acompanha seus chamados |

---

## Comandos úteis

```bash
# Executar todos os testes
php ./vendor/bin/pest

# Formatar código
php ./vendor/bin/pint

# Recriar banco com dados de demonstração
php artisan migrate:fresh --seed

# Build para produção
npm run build

# Modo desenvolvimento com hot reload
npm run dev
```

---

## Estrutura do projeto

```
app/
├── Enums/
│   ├── TicketStatus.php       # Status dos chamados
│   ├── TicketPriority.php     # Prioridades
│   └── UserRole.php           # Perfis de usuário
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── TicketController.php
│   │   └── Api/TicketApiController.php
│   ├── Requests/              # Form Requests com validação
│   └── Policies/TicketPolicy.php
├── Models/
│   ├── Ticket.php
│   ├── TicketComment.php
│   ├── Category.php
│   └── User.php
└── Services/TicketService.php
```

---

## REST API

A API está disponível em `/api` e requer autenticação via token Sanctum.

```http
GET    /api/tickets          # Listar chamados (paginado)
GET    /api/tickets/{id}     # Detalhes de um chamado
POST   /api/tickets          # Criar chamado
PATCH  /api/tickets/{id}     # Atualizar chamado
GET    /api/tickets/stats    # Estatísticas gerais
```

---

## Segurança

- Autenticação via Laravel Breeze (sessão) e Sanctum (API)
- Autorização granular via Policy — usuários só acessam seus próprios dados
- Proteção CSRF em todos os formulários
- Validação de entrada em todos os endpoints via Form Requests

---

## Roadmap

### Fase 1 — MVP Web ✅
- [x] Gestão completa de chamados (CRUD)
- [x] Dashboard com métricas em tempo real
- [x] Sistema de comentários com notas internas
- [x] Três perfis de acesso com políticas de autorização
- [x] REST API autenticada com Sanctum
- [x] Testes automatizados com Pest (48 testes, 116 assertions)
- [x] Filtros avançados e paginação

### Fase 2 — UX & Personalização 🎨
- [ ] Tema escuro/claro com toggle in-app e persistência por usuário
- [ ] Suporte a múltiplos idiomas (pt-BR / en)
- [ ] Editor rich text nas descrições e comentários (TipTap)
- [ ] Upload de anexos nos chamados (imagens, PDFs, documentos)
- [ ] Avatar e perfil do usuário editáveis
- [ ] Tags personalizadas nos chamados
- [ ] Campos customizados por categoria (configuráveis pelo admin)

### Fase 3 — Comunicação & Notificações 🔔
- [ ] Sino de notificações in-app com contagem de não lidas
- [ ] Notificações por e-mail (novo chamado, mudança de status, novo comentário)
- [ ] Templates de e-mail personalizáveis pelo admin
- [ ] @menções em comentários com notificação para o usuário citado
- [ ] Respostas rápidas — snippets pré-definidos para atendentes
- [ ] Integração com Slack/Teams via webhooks

### Fase 4 — Administração, SLA & Relatórios 📊
- [ ] **Tela de Configurações completa:**
  - Geral: nome do sistema, logo, tema padrão, idioma
  - E-mail: SMTP (host, porta, credenciais, teste de envio)
  - Backup: agendamento automático, pasta destino, download manual do `.sql`
  - Relatórios: pasta destino, formato padrão (PDF / CSV)
- [ ] **Relatórios e métricas:**
  - Chamados por status, prioridade e categoria (gráficos com Chart.js)
  - Tempo médio de resolução por atendente
  - Desempenho da equipe por período
  - Exportação para PDF e CSV
- [ ] Configuração de SLA por prioridade (metas de resposta e resolução)
- [ ] Horário de funcionamento da equipe (útil para cálculo de SLA)
- [ ] Log de auditoria global — quem alterou o quê e quando

### Fase 5 — Distribuição & Instalador 📦
- [ ] **Wizard de instalação guiado** (primeira execução):
  - Preferência de tema (claro/escuro)
  - Idioma do sistema
  - Criação da conta administrador
  - Configuração do banco de dados
  - Configuração de e-mail (SMTP)
  - Nome e logotipo do sistema
- [ ] **Empacotamento para distribuição local** (usuário baixa e executa, acessa via navegador):
  - Docker Compose — self-hosting web com `docker compose up`
  - Installer Windows `.exe` com PHP + Nginx embutidos
  - Installer macOS `.dmg`
  - Installer Linux `.deb` / `.AppImage`
- [ ] Auto-updater integrado
- [ ] Deploy em nuvem (Railway / Render / VPS)
- [ ] Suporte a múltiplos bancos (MySQL / PostgreSQL além do SQLite padrão)

---

## Contribuindo

1. Fork o repositório
2. Crie uma branch: `git checkout -b feature/nome-da-feature`
3. Commit: `git commit -m 'feat: adiciona funcionalidade X'`
4. Push: `git push origin feature/nome-da-feature`
5. Abra um Pull Request

---

## Licença

Distribuído sob a licença [MIT](https://opensource.org/licenses/MIT).

---

> **Este projeto faz parte de um portfólio de desenvolvimento Laravel moderno.**
> Criado para demonstrar boas práticas com Laravel 13, Livewire 4, Tailwind CSS 4 e Pest.

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
