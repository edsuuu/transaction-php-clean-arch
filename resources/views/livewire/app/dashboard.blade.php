<div class="flex flex-col gap-6">

    {{-- Saldo --}}
    <div class="nu-card" style="background: linear-gradient(135deg, #820ad1 0%, #6b08ac 100%); border-color: rgba(255,255,255,0.1);">
        <p class="text-sm font-semibold text-purple-200 mb-1 uppercase tracking-widest">Saldo disponível</p>
        <p class="text-4xl font-black text-white">
            R$ {{ $balance }}
        </p>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('deposit') }}"
               class="flex-1 flex items-center justify-center gap-2 py-2 px-4 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Depositar
            </a>
            <a href="{{ route('transfer') }}"
               class="flex-1 flex items-center justify-center gap-2 py-2 px-4 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Transferir
            </a>
        </div>
    </div>

    {{-- Últimas transações --}}
    <div class="nu-card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-white font-bold text-lg">Últimas transações</h2>
            <a href="{{ route('history') }}" class="text-xs text-purple-400 hover:text-purple-300 font-semibold transition-colors">
                Ver todas →
            </a>
        </div>

        @if(empty($recentTransactions))
            <div class="text-center py-8">
                <p class="text-4xl mb-3">📭</p>
                <p class="text-purple-400 text-sm">Nenhuma transação ainda.</p>
                <a href="{{ route('deposit') }}" class="text-purple-300 hover:text-white text-sm font-semibold mt-2 inline-block transition-colors">
                    Fazer um depósito
                </a>
            </div>
        @else
            <div class="flex flex-col gap-3">
                @foreach($recentTransactions as $tx)
                    @php
                        $isCredit = ($tx['entry_type'] ?? $tx->entry_type ?? 'credit') === 'credit';
                        $typeLabel = match($tx['type'] ?? $tx->type ?? 'deposit') {
                            'deposit'  => 'Depósito',
                            'transfer' => 'Transferência',
                            default    => 'Transação',
                        };
                        $amount = $tx['amount'] ?? ($tx->amount ?? '0.00');
                        $date = $tx['created_at'] ?? ($tx->created_at ?? '');
                    @endphp
                    <div class="flex items-center justify-between py-3 border-b border-purple-900/30 last:border-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $isCredit ? 'bg-green-900/30' : 'bg-red-900/30' }}">
                                <span class="text-lg">{{ $isCredit ? '↓' : '↑' }}</span>
                            </div>
                            <div>
                                <p class="text-white text-sm font-semibold">{{ $typeLabel }}</p>
                                <p class="text-purple-400 text-xs">{{ $date }}</p>
                            </div>
                        </div>
                        <span class="{{ $isCredit ? 'text-green-400' : 'text-red-400' }} font-bold text-sm">
                            {{ $isCredit ? '+' : '-' }} R$ {{ $amount }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
