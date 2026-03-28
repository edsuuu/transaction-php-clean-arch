<div class="w-full max-w-md">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-white tracking-tight mb-1">
            app<span style="color:#820ad1;">bank</span>
        </h1>
        <p class="text-purple-300 text-sm">Bem-vindo de volta</p>
    </div>

    {{-- Card --}}
    <div class="nu-card">
        <form wire:submit.prevent="login" class="flex flex-col gap-5">

            <div>
                <label for="email" class="nu-label">E-mail</label>
                <input
                    wire:model="email"
                    id="email"
                    type="email"
                    autocomplete="email"
                    placeholder="seu@email.com"
                    class="nu-input @error('email') error @enderror"
                />
                @error('email')
                    <span class="nu-error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="nu-label">Senha</label>
                <input
                    wire:model="password"
                    id="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="nu-input @error('password') error @enderror"
                />
                @error('password')
                    <span class="nu-error">{{ $message }}</span>
                @enderror
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="nu-btn mt-2"
            >
                <span wire:loading.remove>Entrar</span>
                <span wire:loading class="inline-block animate-spin">↻</span>
            </button>
        </form>

        <p class="text-center text-sm text-purple-400 mt-6">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="font-bold text-purple-300 hover:text-white transition-colors">
                Cadastre-se
            </a>
        </p>
    </div>
</div>
