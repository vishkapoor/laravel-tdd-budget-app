<?php

namespace Tests\Feature\Transactions;

use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTransactionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_delete_a_transaction()
    {
        $transaction = $this->create(Transaction::class);

        $this->delete(route('transactions.destroy', $transaction->id))
            ->assertRedirect(route('transactions.index'));

        $this->get(route('transactions.index'))
            ->assertDontSee($transaction->description);    
    }
}
