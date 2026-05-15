<x-app-layout>
    <x-slot name="title">{{ $ticket->number }}</x-slot>

    <div class="mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
            <a href="{{ route('tickets.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Chamados</a>
            <span class="mx-2">›</span>
            <span class="font-mono">{{ $ticket->number }}</span>
        </nav>
        <div class="flex items-start justify-between gap-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">{{ $ticket->title }}</h1>
            @can('update', $ticket)
                <a href="{{ route('tickets.edit', $ticket) }}"
                   class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
            @endcan
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Conteúdo principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Descrição -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-6">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-4">Descrição</h2>
                <div class="trix-content prose prose-sm max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">{!! clean($ticket->description) !!}</div>
            </div>

            <!-- Comentários -->
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wide">
                        Comentários ({{ $ticket->comments->count() }})
                    </h2>
                </div>

                @if ($ticket->comments->isEmpty())
                    <div class="py-10 text-center text-gray-400 dark:text-gray-500">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-sm">Nenhum comentário ainda.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach ($ticket->comments as $comment)
                            <div class="px-6 py-4 {{ $comment->internal ? 'bg-amber-50/50 dark:bg-amber-900/10' : '' }}">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 text-xs font-semibold">
                                        {{ mb_substr($comment->user->name, 0, 1) }}
                                    </span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    @if($comment->internal)
                                        <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300">
                                            Nota interna
                                        </span>
                                    @endif
                                </div>
                                <div class="trix-content text-sm text-gray-700 dark:text-gray-300 leading-relaxed ml-9">{!! clean($comment->body) !!}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Formulário de comentário -->
                @can('comment', $ticket)
                    <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                        <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}" class="space-y-3">
                            @csrf
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-300 @error('body') border-red-400 @enderror">
                                <input id="comment-body" type="hidden" name="body" value="{{ old('body') }}">
                                <trix-editor input="comment-body" placeholder="Adicionar comentário..."></trix-editor>
                            </div>
                            @error('body')
                                <p class="text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="flex items-center justify-between">
                                @if(auth()->user()->isAdmin() || auth()->user()->isAtendente())
                                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                                        <input type="checkbox" name="internal" value="1" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-300" @checked(old('internal'))>
                                        Nota interna (visível apenas para a equipe)
                                    </label>
                                @else
                                    <span></span>
                                @endif
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                    Comentar
                                </button>
                            </div>
                        </form>
                    </div>
                @endcan
            </div>
        </div>

        <!-- Sidebar com detalhes -->
        <div class="space-y-4">
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-5 grid grid-cols-2 gap-4 lg:grid-cols-1 lg:gap-0 lg:space-y-4">
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">Status</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $ticket->status->badgeClass() }}">
                        {{ $ticket->status->label() }}
                    </span>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">Prioridade</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $ticket->priority->badgeClass() }}">
                        {{ $ticket->priority->label() }}
                    </span>
                </div>
                @if($ticket->category)
                    <div>
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">Categoria</label>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->category->name }}</p>
                    </div>
                @endif
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">Solicitante</label>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->requester?->name ?? '—' }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">Responsável</label>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $ticket->assignee?->name ?? 'Não atribuído' }}</p>
                </div>
                @if($ticket->due_date)
                    <div>
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-1.5">Prazo</label>
                        <p class="text-sm {{ $ticket->due_date->isPast() && !$ticket->isClosed() ? 'text-red-600 dark:text-red-400 font-medium' : 'text-gray-700 dark:text-gray-300' }}">
                            {{ $ticket->due_date->format('d/m/Y') }}
                            @if($ticket->due_date->isPast() && !$ticket->isClosed())
                                <span class="text-xs">(vencido)</span>
                            @endif
                        </p>
                    </div>
                @endif
                <div class="col-span-2 lg:col-span-1 pt-2 border-t border-gray-100 dark:border-gray-800 space-y-2 lg:pt-2">
                    <div>
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-0.5">Criado</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-0.5">Atualizado</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->updated_at->diffForHumans() }}</p>
                    </div>
                    @if($ticket->closed_at)
                        <div>
                            <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide block mb-0.5">Encerrado</label>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $ticket->closed_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @can('delete', $ticket)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-red-100 dark:border-red-900/50 p-5">
                    <h3 class="text-sm font-semibold text-red-700 dark:text-red-400 mb-3">Zona Perigosa</h3>
                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}"
                          onsubmit="return confirm('Tem certeza que deseja excluir este chamado? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                            Excluir Chamado
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
