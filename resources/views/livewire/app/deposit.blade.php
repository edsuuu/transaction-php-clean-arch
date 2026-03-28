<div class="max-w-md mx-auto flex flex-col gap-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-black text-white">Depositar</h1>
        <p class="text-purple-400 text-sm mt-1">Adicione saldo à sua conta</p>
    </div>

    {{-- Sucesso --}}
    @if($success)
        <div class="nu-card" style="border-color: rgba(0,196,170,0.3); background: rgba(0,196,170,0.1);">
            <div class="flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <div>
                    <p class="text-green-400 font-bold">Depósito realizado!</p>
                    <p class="text-purple-300 text-sm">O valor foi creditado na sua conta.</p>
                </div>
            </div>
            <button wire:click="$set('success', false)" class="nu-btn nu-btn-ghost mt-4 text-sm">
                Fazer outro depósito
            </button>
        </div>
    @else
        <div class="nu-card">
            <form wire:submit.prevent="deposit" class="flex flex-col gap-5">

                <div>
                    <label for="amount" class="nu-label">Valor do depósito</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-purple-400 font-bold text-sm">R$</span>
                        <input
                            wire:model="amount"
                            id="amount"
                            type="number"
                            step="0.01"
                            min="0.01"
                            placeholder="0,00"
                            class="nu-input pl-10 @error('amount') error @enderror"
                        />
                    </div>
                    @error('amount')
                        <span class="nu-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Sugestões rápidas --}}
                <div class="flex gap-2">
                    @foreach([50, 100, 200, 500] as $val)
                        <button type="button" wire:click="$set('amount', '{{ $val }}')"
                            class="flex-1 py-2 text-xs font-bold text-purple-300 border border-purple-900/40 rounded-lg hover:border-purple-500 hover:text-white transition-colors">
                            R$ {{ $val }}
                        </button>
                    @endforeach
                </div>

                <button type="submit" wire:loading.attr="disabled" class="nu-btn">
                    <span wire:loading.remove>Depositar</span>
                    <span wire:loading class="inline-block animate-spin">↻</span>
                </button>
            </form>
        </div>
    @endif
</div>
