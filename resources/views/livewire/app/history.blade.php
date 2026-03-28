<div class="flex flex-col gap-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-white">Extrato</h1>
            <p class="text-purple-400 text-sm mt-1">Saldo atual: <span class="text-white font-bold">R$ {{ $balance }}</span></p>
        </div>
    </div>

    {{-- Lista de transações --}}
    <div class="nu-card">
        @if(empty($transactions))
            <div class="text-center py-12">
                <p class="text-4xl mb-3">📭</p>
                <p class="text-purple-400">Nenhuma transação encontrada.</p>
            </div>
        @else
            <div class="flex flex-col divide-y divide-purple-900/30">
                @foreach($transactions as $tx)
                    @php
                        $isCredit = ($tx['entry_type'] ?? $tx->entry_type ?? 'credit') === 'credit';
                        $typeLabel = match($tx['type'] ?? $tx->type ?? 'deposit') {
                            'deposit'  => 'Depósito',
                            'transfer' => 'Transferência',
                            default    => 'Transação',
                        };
                        $amount = $tx['amount'] ?? ($tx->amount ?? '0.00');
                        $date = $tx['created_at'] ?? ($tx->created_at ?? '');
                        $txId = $tx['transaction_id'] ?? ($tx->transaction_id ?? '');
                    @endphp
                    <div class="flex items-center justify-between py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
                                {{ $isCredit ? 'bg-green-900/30' : 'bg-red-900/30' }}">
                                <span class="text-base font-bold {{ $isCredit ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $isCredit ? '↓' : '↑' }}
                                </span>
                            </div>
                            <div>
                                <p class="text-white text-sm font-semibold">{{ $typeLabel }}</p>
                                <p class="text-purple-500 text-xs">{{ $date }}</p>
                                @if($txId)
                                    <p class="text-purple-600 text-xs font-mono mt-0.5">{{ substr($txId, 0, 13) }}...</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="font-black text-base {{ $isCredit ? 'text-green-400' : 'text-red-400' }}">
                                {{ $isCredit ? '+' : '-' }} R$ {{ $amount }}
                            </span>
                            <p class="text-xs mt-0.5">
                                <span class="{{ $isCredit ? 'nu-badge-credit' : 'nu-badge-debit' }}">
                                    {{ $isCredit ? 'Crédito' : 'Débito' }}
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
