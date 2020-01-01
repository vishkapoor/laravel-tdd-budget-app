<?php

namespace Tests\Feature\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTransactionsTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    protected function setUp() : void
    {
        parent::setUp();

        $this->category = $this->create(Category::class);
    }

    /** @test */
    public function it_can_update_transactions()
    {
        $transaction = $this->create(Transaction::class, [
            'category_id' => $this->category->id
        ]);

        $newTransaction = $this->make(Transaction::class, [
            'category_id' => $this->category->id
        ]);

        $this->put(route('transactions.update', $transaction->id), $newTransaction->toArray());

        $this->get(route('transactions.index'))
            ->assertSee($newTransaction->description);
    }

       /** @test */
    public function it_cannot_update_transactions_without_a_description()
    {
        $this->updateTransaction([
            'description' => null,
            'category_id' => $this->category->id
        ])
        ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_update_transactions_without_a_category()
    {
        $this->updateTransaction([
            'category_id' => null,
        ])
        ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cannot_update_transactions_without_an_amount()
    {
        $this->updateTransaction([
            'amount' => null,
            'category_id' => $this->category->id
        ])
            ->assertSessionHasErrors('amount');
    }
    
    /** @test */
    public function it_cannot_update_transactions_without_a_valid_amount()
    {
        $this->updateTransaction([
            'amount' => 'c',
            'category_id' => $this->category->id
        ])
            ->assertSessionHasErrors('amount');
    }

    public function updateTransaction($attributes = []) {

        $transaction = $this->create(Transaction::class);
        $newTransaction = $this->make(Transaction::class, $attributes);

        return $this->withExceptionHandling()
            ->put(route('transactions.update', $transaction->id), $newTransaction->toArray());

    }
}
