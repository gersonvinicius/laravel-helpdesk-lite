<x-app-layout>
    <x-slot name="title">Meu Perfil</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">

        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Meu Perfil</h1>

        {{-- Avatar + Informações --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-5">Foto e informações</h2>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5"
                  x-data="{
                      preview: '{{ $user->avatarUrl() }}',
                      onFile(e) {
                          const file = e.target.files[0];
                          if (!file) return;
                          const reader = new FileReader();
                          reader.onload = ev => this.preview = ev.target.result;
                          reader.readAsDataURL(file);
                      }
                  }">
                @csrf
                @method('PATCH')

                {{-- Avatar preview + upload --}}
                <div class="flex items-center gap-5">
                    <div class="relative shrink-0">
                        <template x-if="preview">
                            <img :src="preview" class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200 dark:border-indigo-700">
                        </template>
                        <template x-if="!preview">
                            <span class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 font-bold text-2xl">
                                {{ mb_substr($user->name, 0, 1) }}
                            </span>
                        </template>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="avatar" class="cursor-pointer inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Alterar foto
                        </label>
                        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp" class="hidden" @change="onFile($event)">
                        @if($user->avatar)
                            <form method="POST" action="{{ route('profile.avatar.remove') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 dark:text-red-400 hover:underline">Remover foto</button>
                            </form>
                        @endif
                        <p class="text-xs text-gray-400 dark:text-gray-500">JPG, PNG ou WebP &mdash; máx. 2 MB</p>
                        <x-input-error :messages="$errors->get('avatar')" class="mt-1"/>
                    </div>
                </div>

                {{-- Name --}}
                <div>
                    <x-input-label for="name" value="Nome"/>
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name', $user->name)" required autofocus/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" value="E-mail"/>
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                  :value="old('email', $user->email)" required/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>

        {{-- Alterar senha --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-5">Alterar senha</h2>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="current_password" value="Senha atual"/>
                    <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password"/>
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="password" value="Nova senha"/>
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2"/>
                </div>

                <div>
                    <x-input-label for="password_confirmation" value="Confirmar nova senha"/>
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2"/>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Atualizar senha
                    </button>
                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                           class="text-sm text-green-600 dark:text-green-400">Senha atualizada.</p>
                    @endif
                </div>
            </form>
        </div>

        {{-- Excluir conta --}}
        <div class="bg-white dark:bg-gray-900 border border-red-100 dark:border-red-900/40 rounded-xl p-6 shadow-sm"
             x-data="{ confirm: false }">
            <h2 class="text-base font-semibold text-red-600 dark:text-red-400 mb-1">Zona de perigo</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-5">Excluir sua conta é permanente e não pode ser desfeito.</p>

            <button @click="confirm = true" x-show="!confirm"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                Excluir minha conta
            </button>

            <div x-show="confirm" class="space-y-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Confirme sua senha para excluir a conta:</p>
                <form method="POST" action="{{ route('profile.destroy') }}" class="flex items-center gap-3 flex-wrap">
                    @csrf
                    @method('DELETE')
                    <x-text-input name="password" type="password" placeholder="Sua senha" class="w-56"/>
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        Confirmar exclusão
                    </button>
                    <button type="button" @click="confirm = false"
                            class="px-4 py-2 text-sm text-gray-600 dark:text-gray-400 hover:underline">
                        Cancelar
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
