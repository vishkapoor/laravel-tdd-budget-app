<?php

namespace Tests\Feature\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTransactionsTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    protected function setUp() : void 
    {
        parent::setUp();
        $this->category = $this->create(Category::class);
    }
    
     /** @test */
    public function it_can_create_transactions()
    {
        $transaction = $this->make(Transaction::class, [
            'category_id' => $this->category->id
        ]);

        $this->post('/transactions', $transaction->toArray())
            ->assertRedirect(route('transactions.index'));

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description);

    }

    /** @test */
    public function it_cannot_create_transactions_without_a_description()
    {
        $this->postTransaction([
            'description' => null, 
            'category_id' => $this->category->id
        ])
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
        $this->postTransaction([
            'amount' => null, 
            'category_id' => $this->category->id
        ])
        ->assertSessionHasErrors('amount');
    }
    
    /** @test */
    public function it_cannot_create_transactions_without_a_valid_amount()
    {
        $this->postTransaction([
            'amount' => 'c', 
            'category_id' => $this->category->id
        ])
        ->assertSessionHasErrors('amount');
    }

    public function postTransaction($attributes = []) {

        $transaction = $this->make(Transaction::class, $attributes);

        return $this->withExceptionHandling()->post(
            '/transactions', 
            $transaction->toArray()
        );

    }

}
