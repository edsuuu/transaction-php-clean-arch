<div class="w-full max-w-lg">
    {{-- Header --}}
    <div class="text-center mb-8">
        <h1 class="text-3xl font-black text-white tracking-tight mb-1">
            nu<span style="color:#820ad1;">bank</span>
        </h1>
        <p class="text-purple-300 text-sm">Crie sua conta gratuitamente</p>
    </div>

    {{-- Card --}}
    <div class="nu-card">
        <form wire:submit.prevent="register" class="flex flex-col gap-4">

            {{-- Tipo de conta --}}
            <div>
                <label class="nu-label">Tipo de conta</label>
                <div class="flex gap-3">
                    <label class="flex-1 flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-all {{ $customer_type === 'common' ? 'border-purple-500 bg-purple-900/30 text-white' : 'border-purple-900/30 text-purple-400' }}">
                        <input wire:model="customer_type" type="radio" value="common" class="sr-only">
                        <span class="text-sm font-semibold">👤 Pessoa Física</span>
                    </label>
                    <label class="flex-1 flex items-center gap-3 p-3 rounded-lg border cursor-pointer transition-all {{ $customer_type === 'merchant' ? 'border-purple-500 bg-purple-900/30 text-white' : 'border-purple-900/30 text-purple-400' }}">
                        <input wire:model="customer_type" type="radio" value="merchant" class="sr-only">
                        <span class="text-sm font-semibold">🏪 Lojista</span>
                    </label>
                </div>
                @error('customer_type')
                    <span class="nu-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Nome e Sobrenome --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="first_name" class="nu-label">Nome</label>
                    <input wire:model="first_name" id="first_name" type="text" placeholder="João" class="nu-input @error('first_name') error @enderror" />
                    @error('first_name')
                        <span class="nu-error">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="last_name" class="nu-label">Sobrenome</label>
                    <input wire:model="last_name" id="last_name" type="text" placeholder="Silva" class="nu-input @error('last_name') error @enderror" />
                    @error('last_name')
                        <span class="nu-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- E-mail --}}
            <div>
                <label for="email" class="nu-label">E-mail</label>
                <input wire:model="email" id="email" type="email" placeholder="seu@email.com" autocomplete="email" class="nu-input @error('email') error @enderror" />
                @error('email')
                    <span class="nu-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- CPF/CNPJ --}}
            <div>
                <label for="document" class="nu-label">CPF / CNPJ</label>
                <input wire:model="document" id="document" type="text" placeholder="000.000.000-00" class="nu-input @error('document') error @enderror" />
                @error('document')
                    <span class="nu-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Telefone e Data de Nascimento --}}
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="phone" class="nu-label">Telefone</label>
                    <input wire:model="phone" id="phone" type="tel" placeholder="(11) 99999-9999" class="nu-input @error('phone') error @enderror" />
                    @error('phone')
                        <span class="nu-error">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="birth_date" class="nu-label">Nascimento</label>
                    <input wire:model="birth_date" id="birth_date" type="date" class="nu-input @error('birth_date') error @enderror" />
                    @error('birth_date')
                        <span class="nu-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Senha --}}
            <div>
                <label for="password" class="nu-label">Senha</label>
                <input wire:model="password" id="password" type="password" placeholder="mínimo 8 caracteres" autocomplete="new-password" class="nu-input @error('password') error @enderror" />
                @error('password')
                    <span class="nu-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" class="nu-btn mt-2">
                <span wire:loading.remove>Criar Conta</span>
                <span wire:loading class="inline-block animate-spin">↻</span>
            </button>
        </form>

        <p class="text-center text-sm text-purple-400 mt-6">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-bold text-purple-300 hover:text-white transition-colors">
                Fazer login
            </a>
        </p>
    </div>
</div>
