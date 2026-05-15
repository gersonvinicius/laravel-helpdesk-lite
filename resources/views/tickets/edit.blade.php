<x-app-layout>
    <x-slot name="title">Editar {{ $ticket->number }}</x-slot>

    <div class="mb-6">
        <nav class="text-sm text-gray-500 dark:text-gray-400 mb-2">
            <a href="{{ route('tickets.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Chamados</a>
            <span class="mx-2">›</span>
            <a href="{{ route('tickets.show', $ticket) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 font-mono">{{ $ticket->number }}</a>
            <span class="mx-2">›</span>
            <span>Editar</span>
        </nav>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Editar Chamado</h1>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800 p-6">
            <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Título <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $ticket->title) }}" required
                           class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 @error('title') border-red-400 @enderror">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descrição <span class="text-red-500">*</span></label>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-300 @error('description') border-red-400 @enderror">
                        <input id="description" type="hidden" name="description" value="{{ old('description', $ticket->description) }}">
                        <trix-editor input="description"></trix-editor>
                    </div>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 @error('status') border-red-400 @enderror">
                            @foreach(\App\Enums\TicketStatus::cases() as $s)
                                <option value="{{ $s->value }}" @selected(old('status', $ticket->status->value) === $s->value)>{{ $s->label() }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Prioridade <span class="text-red-500">*</span></label>
                        <select id="priority" name="priority" required
                                class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 @error('priority') border-red-400 @enderror">
                            @foreach(\App\Enums\TicketPriority::cases() as $p)
                                <option value="{{ $p->value }}" @selected(old('priority', $ticket->priority->value) === $p->value)>{{ $p->label() }}</option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Categoria</label>
                        <select id="category_id" name="category_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            <option value="">Selecionar categoria</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $ticket->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Prazo</label>
                        <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $ticket->due_date?->format('Y-m-d')) }}"
                               class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 @error('due_date') border-red-400 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if(auth()->user()->isAdmin() || auth()->user()->isAtendente())
                    <div>
                        <label for="assignee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Responsável</label>
                        <select id="assignee_id" name="assignee_id"
                                class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            <option value="">Sem responsável</option>
                            @foreach($atendentes as $user)
                                <option value="{{ $user->id }}" @selected(old('assignee_id', $ticket->assignee_id) == $user->id)>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                @if($tags->isNotEmpty())
                    @php $selectedTags = old('tags', $ticket->tags->pluck('id')->toArray()); @endphp
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="sr-only peer"
                                           @checked(in_array($tag->id, (array) $selectedTags))>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border-2 border-transparent
                                                 peer-checked:border-indigo-500 peer-checked:ring-1 peer-checked:ring-indigo-400
                                                 transition-all {{ $tag->badgeClass() }}">
                                        {{ $tag->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Salvar Alterações
                    </button>
                    <a href="{{ route('tickets.show', $ticket) }}" class="px-5 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
