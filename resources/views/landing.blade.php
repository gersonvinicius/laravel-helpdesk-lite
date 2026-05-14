<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk Lite — Sistema leve de chamados para pequenas equipes</title>
    <meta name="description" content="Sistema simples e moderno de gestão de chamados para pequenas empresas, freelancers e equipes de suporte interno.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-2 text-indigo-600 font-bold text-xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    HelpDesk Lite
                </div>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">Painel</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Entrar</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">Criar conta</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="pt-20 pb-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 text-indigo-700 text-sm font-medium rounded-full mb-6">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                Projeto open-source · Laravel 13 · Livewire · Tailwind CSS
            </div>
            <h1 class="text-5xl sm:text-6xl font-bold text-gray-900 leading-tight mb-6">
                Gerencie chamados<br>
                <span class="text-indigo-600">sem complicação</span>
            </h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Um sistema leve e moderno para pequenas equipes acompanharem solicitações,
                prioridades, status e histórico de atendimento em um único lugar.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Acessar Demo
                </a>
                <a href="https://github.com/gersonvinicius/laravel-helpdesk-lite" target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-all">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"/>
                    </svg>
                    Ver no GitHub
                </a>
            </div>
            <p class="mt-5 text-sm text-gray-400">
                Demo: <span class="font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-600">admin@example.com</span> /
                <span class="font-mono bg-gray-100 px-2 py-0.5 rounded text-gray-600">password</span>
            </p>
        </div>
    </section>

    <!-- Screenshot placeholder -->
    <section class="px-4 sm:px-6 lg:px-8 pb-20">
        <div class="max-w-5xl mx-auto">
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl border border-indigo-100 p-8 flex items-center justify-center min-h-64">
                <div class="text-center">
                    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-indigo-600 font-medium">Screenshot do sistema</p>
                    <p class="text-sm text-indigo-400 mt-1">Acesse a demo para ver em funcionamento</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Problema que resolve -->
    <section class="bg-gray-50 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">O problema que resolvemos</h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                    Pequenas equipes perdem tempo gerenciando solicitações por e-mail, WhatsApp ou planilhas.
                    Isso gera retrabalho, prazos perdidos e falta de rastreabilidade.
                </p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sem rastreabilidade</h3>
                    <p class="text-sm text-gray-500">Chamados perdidos em e-mails e chats sem histórico centralizado.</p>
                </div>
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Prazos perdidos</h3>
                    <p class="text-sm text-gray-500">Sem visibilidade de prioridades, chamados críticos ficam para depois.</p>
                </div>
                <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Sem responsável claro</h3>
                    <p class="text-sm text-gray-500">Ninguém sabe quem está cuidando de cada problema.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Funcionalidades -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Tudo que uma pequena equipe precisa</h2>
                <p class="text-gray-500 text-lg">Simples, sem excesso de funcionalidades.</p>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach([
                    ['icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'title' => 'Gestão de Chamados', 'desc' => 'Crie, edite, acompanhe e resolva chamados com histórico completo.'],
                    ['icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'title' => 'Dashboard', 'desc' => 'Visão geral dos chamados por status e prioridade em tempo real.'],
                    ['icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'title' => 'Prioridades e Status', 'desc' => 'Classifique chamados por prioridade (baixa a crítica) e status de atendimento.'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0', 'title' => 'Perfis de Acesso', 'desc' => 'Admin, Atendente e Solicitante com permissões específicas para cada perfil.'],
                    ['icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z', 'title' => 'Comentários', 'desc' => 'Histórico completo de comentários por chamado com autor e data.'],
                    ['icon' => 'M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z', 'title' => 'Filtros Avançados', 'desc' => 'Busque e filtre por status, prioridade, responsável ou categoria.'],
                ] as $feature)
                <div class="bg-white rounded-xl p-6 border border-gray-100 hover:border-indigo-200 hover:shadow-md transition-all">
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $feature['icon'] }}"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-gray-500">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Para quem é -->
    <section class="bg-indigo-600 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Para quem é o HelpDesk Lite?</h2>
            <p class="text-indigo-200 text-lg mb-12">Feito para equipes que querem organização sem complexidade.</p>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach(['Pequenas empresas', 'Freelancers', 'Equipes de suporte interno', 'Agências digitais', 'Software houses', 'Recrutadores avaliando portfólio'] as $item)
                <div class="bg-white/10 backdrop-blur rounded-xl px-5 py-4 text-white font-medium text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ $item }}
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stack -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Stack tecnológico</h2>
            <p class="text-gray-500 text-lg mb-12">Moderno, sem over-engineering.</p>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach(['Laravel 13', 'PHP 8.3', 'Livewire 4', 'Tailwind CSS 4', 'SQLite', 'Pest', 'Alpine.js', 'Vite'] as $tech)
                <span class="px-4 py-2 bg-gray-100 text-gray-700 font-medium text-sm rounded-lg">{{ $tech }}</span>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Roadmap Desktop -->
    <section class="bg-gray-50 py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-8 text-white text-center">
                <div class="inline-flex items-center gap-2 bg-white/20 px-3 py-1.5 rounded-full text-sm font-medium mb-6">
                    🗺️ Em construção
                </div>
                <h2 class="text-2xl font-bold mb-4">Roadmap: Versão Desktop</h2>
                <p class="text-indigo-100 text-lg leading-relaxed mb-6">
                    Este projeto foi pensado para funcionar inicialmente como uma aplicação web Laravel
                    e evoluir para uma versão desktop distribuível com <strong>NativePHP</strong>,
                    permitindo que qualquer pessoa baixe, instale e use o sistema sem configurar
                    nenhum ambiente de desenvolvimento.
                </p>
                <div class="grid sm:grid-cols-3 gap-4 text-left">
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-sm font-semibold text-indigo-200 mb-1">Fase 1 · Atual</div>
                        <div class="text-sm">Aplicação web Laravel completa e funcional</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-sm font-semibold text-indigo-200 mb-1">Fase 2 · Planejado</div>
                        <div class="text-sm">Integração com NativePHP para empacotamento</div>
                    </div>
                    <div class="bg-white/10 rounded-xl p-4">
                        <div class="text-sm font-semibold text-indigo-200 mb-1">Fase 3 · Futuro</div>
                        <div class="text-sm">Instalador .exe/.dmg para usuário final</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Pronto para experimentar?</h2>
            <p class="text-gray-500 text-lg mb-8">Acesse a demo com o usuário de demonstração ou instale em minutos.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                    Acessar Demo Agora
                </a>
            </div>
            <p class="mt-5 text-sm text-gray-400">
                <strong>admin@example.com</strong> / <strong>password</strong>
            </p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-gray-600 font-semibold">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                HelpDesk Lite
            </div>
            <p class="text-sm text-gray-400">Open-source · Licença MIT · Feito com Laravel</p>
        </div>
    </footer>
</body>
</html>
