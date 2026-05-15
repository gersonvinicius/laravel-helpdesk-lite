<x-app-layout>
    <x-slot name="title">Chamados</x-slot>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chamados</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $tickets->total() }} chamado(s) encontrado(s)</p>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('tickets.index') }}" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Buscar por título..."
                   class="col-span-1 sm:col-span-2 lg:col-span-1 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400">

            <select name="status" class="px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <option value="">Todos os status</option>
                @foreach(\App\Enums\TicketStatus::cases() as $s)
                    <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>

            <select name="priority" class="px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <option value="">Todas as prioridades</option>
                @foreach(\App\Enums\TicketPriority::cases() as $p)
                    <option value="{{ $p->value }}" @selected(request('priority') === $p->value)>{{ $p->label() }}</option>
                @endforeach
            </select>

            <select name="category_id" class="px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <option value="">Todas as categorias</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>

            @if($tags->isNotEmpty())
                <select name="tag_id" class="px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <option value="">Todas as tags</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(request('tag_id') == $tag->id)>{{ $tag->name }}</option>
                    @endforeach
                </select>
            @endif

            <div class="flex gap-2">
                <button type="submit" class="flex-1 px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Filtrar
                </button>
                @if(request()->hasAny(['search', 'status', 'priority', 'category_id', 'assignee_id', 'tag_id']))
                    <a href="{{ route('tickets.index') }}" class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors whitespace-nowrap">
                        Limpar
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Tabela -->
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
        @if ($tickets->isEmpty())
            <div class="py-16 text-center">
                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 dark:text-gray-500 font-medium">Nenhum chamado encontrado</p>
                @if(request()->hasAny(['search', 'status', 'priority', 'category_id']))
                    <a href="{{ route('tickets.index') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Limpar filtros</a>
                @else
                    <a href="{{ route('tickets.create') }}" class="mt-3 inline-block text-sm text-indigo-600 hover:underline">Criar primeiro chamado</a>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Número</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Título</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Prioridade</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide hidden md:table-cell">Responsável</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide hidden lg:table-cell">Tags</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide hidden lg:table-cell">Vencimento</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide hidden lg:table-cell">Criado</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs text-gray-500 dark:text-gray-400 font-medium">{{ $ticket->number }}</span>
                                </td>
                                <td class="px-6 py-4 max-w-xs">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium block truncate">
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
                                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 hidden md:table-cell">
                                    {{ $ticket->assignee?->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($ticket->tags->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($ticket->tags as $tag)
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium {{ $tag->badgeClass() }}">{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if ($ticket->due_date)
                                        <span class="{{ $ticket->due_date->isPast() && !$ticket->isClosed() ? 'text-red-600 dark:text-red-400 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $ticket->due_date->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-400 dark:text-gray-500 text-xs hidden lg:table-cell">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 justify-end">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" title="Ver">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @can('update', $ticket)
                                            <a href="{{ route('tickets.edit', $ticket) }}" class="text-gray-400 dark:text-gray-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" title="Editar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($tickets->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
