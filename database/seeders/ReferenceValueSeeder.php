<?php

namespace Database\Seeders;

use App\Infrastructure\Models\ReferenceValueModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReferenceValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // transaction_type
            ['group' => 'transaction_type', 'code' => 'transfer', 'name' => 'Transfer'],
            ['group' => 'transaction_type', 'code' => 'deposit', 'name' => 'Deposit'],
            ['group' => 'transaction_type', 'code' => 'withdraw', 'name' => 'Withdraw'],
            ['group' => 'transaction_type', 'code' => 'refund', 'name' => 'Refund'],

            // transaction_status
            ['group' => 'transaction_status', 'code' => 'pending', 'name' => 'Pending'],
            ['group' => 'transaction_status', 'code' => 'completed', 'name' => 'Completed'],
            ['group' => 'transaction_status', 'code' => 'failed', 'name' => 'Failed'],

            // ledger_entry_type
            ['group' => 'ledger_entry_type', 'code' => 'debit', 'name' => 'Debit'],
            ['group' => 'ledger_entry_type', 'code' => 'credit', 'name' => 'Credit'],
        ];

        foreach ($data as $item) {
            ReferenceValueModel::query()->updateOrCreate(
                attributes: ['code' => $item['code']],
                values: $item
            );
        }
    }
}
