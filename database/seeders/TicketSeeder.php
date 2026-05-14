<?php

namespace Database\Seeders;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use App\Support\TicketNumberGenerator;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $atendente = User::where('email', 'atendente@example.com')->first();
        $solicitante = User::where('email', 'solicitante@example.com')->first();

        $categories = Category::all()->keyBy('slug');

        $tickets = [
            [
                'title' => 'Computador não liga na sala de reuniões',
                'description' => 'O computador da sala de reuniões principal não está ligando desde ontem. Já verifiquei a tomada e o cabo de energia. O equipamento é essencial para as apresentações da semana.',
                'status' => TicketStatus::EmAndamento,
                'priority' => TicketPriority::Alta,
                'category' => 'hardware',
                'requester' => $solicitante,
                'assignee' => $atendente,
                'due_date' => now()->addDays(1)->toDateString(),
                'comments' => [
                    ['user' => $atendente, 'body' => 'Já estou verificando o equipamento. Parece ser problema na fonte de alimentação.'],
                    ['user' => $solicitante, 'body' => 'Obrigado! Precisamos que esteja funcionando até amanhã de manhã para a apresentação do cliente.'],
                ],
            ],
            [
                'title' => 'Acesso ao sistema de gestão bloqueado',
                'description' => 'Meu acesso ao sistema de gestão foi bloqueado após tentativas incorretas de senha. Preciso urgentemente para fechar o relatório mensal.',
                'status' => TicketStatus::Resolvido,
                'priority' => TicketPriority::Critica,
                'category' => 'acesso-e-permissoes',
                'requester' => $solicitante,
                'assignee' => $admin,
                'due_date' => null,
                'comments' => [
                    ['user' => $admin, 'body' => 'Acesso reativado. Por favor, redefina sua senha no primeiro acesso.'],
                    ['user' => $solicitante, 'body' => 'Perfeito! Já consegui acessar. Muito obrigado pela rapidez!'],
                ],
            ],
            [
                'title' => 'Lentidão na rede Wi-Fi do escritório',
                'description' => 'A rede Wi-Fi está muito lenta desde a atualização do roteador na semana passada. Todos os funcionários do andar 2 estão tendo problemas para acessar os sistemas.',
                'status' => TicketStatus::AguardandoResposta,
                'priority' => TicketPriority::Alta,
                'category' => 'rede',
                'requester' => $solicitante,
                'assignee' => $atendente,
                'due_date' => now()->addDays(3)->toDateString(),
                'comments' => [
                    ['user' => $atendente, 'body' => 'Analisando os logs do roteador. Preciso que você informe quais sistemas específicos apresentam mais lentidão.'],
                ],
            ],
            [
                'title' => 'Instalação do software de design',
                'description' => 'Preciso que o Adobe Illustrator seja instalado no meu computador para o novo projeto gráfico. Já tenho a licença aprovada pelo gestor.',
                'status' => TicketStatus::Aberto,
                'priority' => TicketPriority::Media,
                'category' => 'software',
                'requester' => $solicitante,
                'assignee' => null,
                'due_date' => now()->addDays(5)->toDateString(),
                'comments' => [],
            ],
            [
                'title' => 'Backup de dados não realizado',
                'description' => 'O sistema de backup automatizado não está realizando os backups noturnos há 3 dias. Os logs mostram falha na conexão com o servidor de armazenamento.',
                'status' => TicketStatus::EmAndamento,
                'priority' => TicketPriority::Critica,
                'category' => 'infraestrutura',
                'requester' => $admin,
                'assignee' => $atendente,
                'due_date' => now()->addDays(1)->toDateString(),
                'comments' => [
                    ['user' => $atendente, 'body' => 'Verificando a conectividade com o servidor de armazenamento. Parece ser um problema de certificado SSL expirado.'],
                    ['user' => $admin, 'body' => 'Por favor, priorize isso. Não podemos ficar sem backup.'],
                    ['user' => $atendente, 'body' => 'Certificado renovado. Executando backup manual agora para garantir. Sistema automático será restaurado em breve.'],
                ],
            ],
            [
                'title' => 'Solicitação de novo monitor',
                'description' => 'Gostaria de solicitar um segundo monitor para aumentar minha produtividade no trabalho com planilhas e documentos. Já vi que há equipamentos disponíveis no estoque.',
                'status' => TicketStatus::Aberto,
                'priority' => TicketPriority::Baixa,
                'category' => 'hardware',
                'requester' => $solicitante,
                'assignee' => null,
                'due_date' => null,
                'comments' => [],
            ],
            [
                'title' => 'E-mail corporativo não sincronizando',
                'description' => 'Meu e-mail corporativo parou de sincronizar no celular. Consigo acessar pelo browser mas o aplicativo apresenta erro de autenticação.',
                'status' => TicketStatus::Fechado,
                'priority' => TicketPriority::Media,
                'category' => 'software',
                'requester' => $solicitante,
                'assignee' => $atendente,
                'due_date' => null,
                'comments' => [
                    ['user' => $atendente, 'body' => 'Problema identificado: senha de app específico estava desabilitada. Configuração corrigida.'],
                    ['user' => $solicitante, 'body' => 'Funcionou perfeitamente! Obrigado.'],
                ],
            ],
        ];

        foreach ($tickets as $data) {
            $ticket = Ticket::create([
                'number' => TicketNumberGenerator::generate(),
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
                'priority' => $data['priority'],
                'category_id' => isset($data['category']) ? ($categories->get($data['category'])?->id) : null,
                'requester_id' => $data['requester']->id,
                'assignee_id' => $data['assignee']?->id,
                'due_date' => $data['due_date'],
                'closed_at' => in_array($data['status'], [TicketStatus::Resolvido, TicketStatus::Fechado]) ? now() : null,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            foreach ($data['comments'] as $comment) {
                TicketComment::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $comment['user']->id,
                    'body' => $comment['body'],
                    'internal' => false,
                ]);
            }
        }
    }
}
