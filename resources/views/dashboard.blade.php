<x-app-layout>
    <x-slot name="title">Painel</x-slot>

    <!-- Cabeçalho -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Painel</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Olá, {{ auth()->user()->name }}! Aqui está um resumo dos chamados.</p>
    </div>

    <!-- Cards de stats -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <a href="{{ route('tickets.index') }}" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Total</span>
                <div class="w-8 h-8 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center group-hover:bg-gray-200 dark:group-hover:bg-gray-700 transition-colors">
                    <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</div>
            <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">chamados</div>
        </a>

        <a href="{{ route('tickets.index', ['status' => 'aberto']) }}" class="bg-white dark:bg-gray-900 rounded-xl border border-blue-100 dark:border-blue-900/50 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-blue-600 uppercase tracking-wide">Abertos</span>
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-blue-700">{{ $stats['abertos'] }}</div>
            <div class="text-xs text-blue-400 mt-1">aguardando atenção</div>
        </a>

        <a href="{{ route('tickets.index', ['status' => 'em_andamento']) }}" class="bg-white dark:bg-gray-900 rounded-xl border border-yellow-100 dark:border-yellow-900/50 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-yellow-600 uppercase tracking-wide">Em Andamento</span>
                <div class="w-8 h-8 bg-yellow-50 rounded-lg flex items-center justify-center group-hover:bg-yellow-100 transition-colors">
                    <svg class="w-4 h-4 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-yellow-700">{{ $stats['em_andamento'] }}</div>
            <div class="text-xs text-yellow-400 mt-1">sendo atendidos</div>
        </a>

        <a href="{{ route('tickets.index', ['status' => 'resolvido']) }}" class="bg-white dark:bg-gray-900 rounded-xl border border-green-100 dark:border-green-900/50 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-green-600 uppercase tracking-wide">Resolvidos</span>
                <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center group-hover:bg-green-100 transition-colors">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-green-700">{{ $stats['resolvidos'] }}</div>
            <div class="text-xs text-green-400 mt-1">concluídos</div>
        </a>

        <a href="{{ route('tickets.index', ['priority' => 'critica']) }}" class="bg-white dark:bg-gray-900 rounded-xl border border-red-100 dark:border-red-900/50 p-5 hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-red-600 uppercase tracking-wide">Críticos</span>
                <div class="w-8 h-8 bg-red-50 rounded-lg flex items-center justify-center group-hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-red-700">{{ $stats['criticos'] }}</div>
            <div class="text-xs text-red-400 mt-1">alta urgência</div>
        </a>
    </div>

    <!-- Chamados recentes -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h2 class="font-semibold text-gray-900 dark:text-white">Chamados Recentes</h2>
            <a href="{{ route('tickets.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Ver todos →</a>
        </div>

        @if ($recentTickets->isEmpty())
            <div class="py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 dark:text-gray-500 font-medium">Nenhum chamado ainda</p>
                <p class="text-gray-300 dark:text-gray-600 text-sm mt-1">Crie o primeiro chamado para começar</p>
                <a href="{{ route('tickets.create') }}" class="mt-4 inline-block text-sm text-indigo-600 hover:underline">Criar chamado</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-50 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Número</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Título</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Prioridade</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide hidden md:table-cell">Solicitante</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide hidden lg:table-cell">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($recentTickets as $ticket)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="font-mono text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium">
                                        {{ $ticket->number }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium truncate block">
                                        {{ $ticket->title }}
                                    </a>
                                    @if ($ticket->category)
                                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ $ticket->category->name }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->status->badgeClass() }}">
                                        {{ $ticket->status->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority->badgeClass() }}">
                                        {{ $ticket->priority->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 hidden md:table-cell">{{ $ticket->requester?->name }}</td>
                                <td class="px-6 py-4 text-gray-400 dark:text-gray-500 text-xs hidden lg:table-cell">{{ $ticket->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
