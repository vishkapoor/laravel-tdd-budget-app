<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_display_all_transactions()
    {
        $transaction = create(Transaction::class);

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description)
            ->assertSee($transaction->category->name);
    }

    /** @test */
    public function it_can_filter_transactions_by_category()
    {
        $category = create(Category::class);

        $transaction = create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $newTransaction = create(Transaction::class);

        $this->get(route('transactions.index', $category->slug))
            ->assertSee($transaction->description)
            ->assertDontSee($newTransaction->description);
    }

     /** @test */
    public function it_can_create_transactions()
    {
        $transaction = make(Transaction::class);

        $this->post('/transactions', $transaction->toArray())
            ->assertRedirect(route('transactions.index'));

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description);

    }

    /** @test */
    public function it_cannot_create_transactions_without_a_description()
    {
        $this->postTransaction(['description' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function it_cannot_create_transactions_without_a_category()
    {
        $this->postTransaction(['category_id' => null])
            ->assertSessionHasErrors('category_id');
    }

    /** @test */
    public function it_cannot_create_transactions_without_an_amount()
    {
        $this->postTransaction(['amount' => null])
            ->assertSessionHasErrors('amount');
    }

    public function postTransaction($attributes = []) {

        $transaction = make(Transaction::class, $attributes);

        return $this->withExceptionHandling()->post(
            '/transactions', 
            $transaction->toArray()
        );

    }

    /** @test */
    public function it_cannot_create_transactions_without_a_valid_amount()
    {
        $this->postTransaction(['amount' => 'c'])
            ->assertSessionHasErrors('amount');
    }

}