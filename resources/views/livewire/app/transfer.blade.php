<div class="max-w-md mx-auto flex flex-col gap-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-black text-white">Transferir</h1>
        <p class="text-purple-400 text-sm mt-1">Envie dinheiro para outra conta</p>
    </div>

    {{-- Sucesso --}}
    @if($success)
        <div class="nu-card" style="border-color: rgba(0,196,170,0.3); background: rgba(0,196,170,0.1);">
            <div class="flex items-center gap-3">
                <span class="text-2xl">✅</span>
                <div>
                    <p class="text-green-400 font-bold">Transferência realizada!</p>
                    <p class="text-purple-300 text-sm">O valor foi enviado com sucesso.</p>
                </div>
            </div>
            <button wire:click="$set('success', false)" class="nu-btn nu-btn-ghost mt-4 text-sm">
                Fazer outra transferência
            </button>
        </div>
    @else
        <div class="nu-card">

            {{-- Erro de domínio --}}
            @if($errorMessage)
                <div class="mb-4 p-3 rounded-lg border border-red-900/50 bg-red-900/20">
                    <p class="text-red-400 text-sm font-semibold">⚠ {{ $errorMessage }}</p>
                </div>
            @endif

            <form wire:submit.prevent="transfer" class="flex flex-col gap-5">

                <div>
                    <label for="payee_account_id" class="nu-label">ID da conta destino</label>
                    <input
                        wire:model="payee_account_id"
                        id="payee_account_id"
                        type="text"
                        placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                        class="nu-input @error('payee_account_id') error @enderror"
                    />
                    @error('payee_account_id')
                        <span class="nu-error">{{ $message }}</span>
                    @enderror
                    <p class="text-purple-500 text-xs mt-1">Peça o ID da conta ao destinatário</p>
                </div>

                <div>
                    <label for="amount" class="nu-label">Valor a transferir</label>
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

                <button type="submit" wire:loading.attr="disabled" class="nu-btn">
                    <span wire:loading.remove>Transferir</span>
                    <span wire:loading class="inline-block animate-spin">↻</span>
                </button>
            </form>
        </div>
    @endif
</div>
