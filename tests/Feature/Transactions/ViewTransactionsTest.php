<?php

namespace Tests\Feature\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTransactionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_allows_only_authenticated_users()
    {
        $this->signOut()
            ->withExceptionHandling()
            ->get('/transactions')
            ->assertRedirect('/login');
    }

    /** @test */
    public function it_only_displays_transactions_belongs_to_currently_logged_in_user()
    {
        $otherUser = create('App\User');
        $transaction = $this->create(Transaction::class);
        $otherTransaction = create(Transaction::class, [ 'user_id' => $otherUser->id ]);

        $this->get('/transactions')
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->description);

    }

    /** @test */
    public function it_can_display_all_transactions()
    {
        $transaction = $this->create(Transaction::class);

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description)
            ->assertSee($transaction->category->name);
    }

    /** @test */
    public function it_can_filter_transactions_by_category()
    {
        $category = create(Category::class);

        $transaction = $this->create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $newTransaction = $this->create(Transaction::class);

        $this->get(route('transactions.index', $category->slug))
            ->assertSee($transaction->description)
            ->assertDontSee($newTransaction->description);
    }
    
    /** @test */
    public function it_can_filter_transactions_by_month()
    {
        $currentTransaction = $this->create(Transaction::class);
        $pastTransaction = $this->create(Transaction::class, [
            'created_at' => Carbon::now()->subMonths(2)
        ]);

        $this->get(route('transactions.index') 
            . "?month=" . Carbon::now()->subMonths(2)->month)
        ->assertSee($pastTransaction->description)
        ->assertDontSee($currentTransaction->description);

    }

    /** @test */
    public function if_can_filter_transactions_by_current_month_by_default()
    {
        $currentTransaction = $this->create(Transaction::class);
        $pastTransaction = $this->create(Transaction::class, [
            'created_at' => Carbon::now()->subMonths(2)
        ]);

        $this->get(route('transactions.index'))
            ->assertSee($currentTransaction->description)
            ->assertDontSee($pastTransaction->description);
    }
}
