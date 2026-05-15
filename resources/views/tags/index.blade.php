<x-app-layout>
    <x-slot name="title">Gerenciar Tags</x-slot>

    @if(!auth()->user()->isAdmin())
        <div class="text-center py-20">
            <p class="text-gray-500 dark:text-gray-400">Acesso restrito a administradores.</p>
        </div>
    @else
    <div class="max-w-3xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tags</h1>
        </div>

        {{-- Create form --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-5 shadow-sm mb-6">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Nova tag</h2>
            <form method="POST" action="{{ route('tags.store') }}" class="flex items-end gap-3 flex-wrap">
                @csrf
                <div>
                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                    <input type="text" name="name" value="{{ old('name') }}" required maxlength="50"
                           class="px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 w-44"
                           placeholder="Ex: Bug">
                    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Cor</label>
                    <select name="color" class="px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300">
                        @foreach(['indigo','blue','green','yellow','red','orange','purple','pink'] as $c)
                            <option value="{{ $c }}" @selected(old('color') === $c)>{{ ucfirst($c) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Criar
                </button>
            </form>
        </div>

        {{-- Tags list --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl shadow-sm overflow-hidden">
            @if($tags->isEmpty())
                <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-10">Nenhuma tag criada ainda.</p>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 text-left">
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Tag</th>
                            <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Chamados</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach($tags as $tag)
                            <tr x-data="{ editing: false }">
                                <td class="px-4 py-3">
                                    <span x-show="!editing" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tag->badgeClass() }}">
                                        {{ $tag->name }}
                                    </span>
                                    <form x-show="editing" method="POST" action="{{ route('tags.update', $tag) }}" class="flex items-center gap-2 flex-wrap">
                                        @csrf @method('PATCH')
                                        <input type="text" name="name" value="{{ $tag->name }}" required maxlength="50"
                                               class="px-2 py-1 text-xs border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-md w-32 focus:outline-none focus:ring-1 focus:ring-indigo-300">
                                        <select name="color" class="px-2 py-1 text-xs border border-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-indigo-300">
                                            @foreach(['indigo','blue','green','yellow','red','orange','purple','pink'] as $c)
                                                <option value="{{ $c }}" @selected($tag->color === $c)>{{ ucfirst($c) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="text-xs text-indigo-600 dark:text-indigo-400 font-medium hover:underline">Salvar</button>
                                        <button type="button" @click="editing = false" class="text-xs text-gray-400 hover:underline">Cancelar</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ $tag->tickets_count }}</td>
                                <td class="px-4 py-3 text-right">
                                    <button x-show="!editing" @click="editing = true" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline mr-3">Editar</button>
                                    <form method="POST" action="{{ route('tags.destroy', $tag) }}" class="inline"
                                          onsubmit="return confirm('Excluir tag {{ $tag->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 dark:text-red-400 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @endif
</x-app-layout>
