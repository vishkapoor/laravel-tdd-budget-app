<?php

namespace Tests\Feature\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTransactionsTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_allows_only_authenticated_users_to_transactions_list()
    {
        $this->signOut()
            ->withExceptionHandling()
            ->get('/transactions')
            ->assertRedirect('/login');
    }

    /** @test */
    public function it_only_displays_transactions_belongs_to_currently_logged_in_user()
    {
        $category = $this->create(Category::class);

        $transaction = $this->create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $otherTransaction = create(Transaction::class, [ 
            'category_id' => $category->id,
            'user_id' => create(User::class)->id
        ]);

        $this->get('/transactions')
            ->assertSee($transaction->description)
            ->assertDontSee($otherTransaction->description);

    }

    /** @test */
    public function it_can_display_all_transactions()
    {
        $category = $this->create(Category::class);

        $transaction = $this->create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $this->get(route('transactions.index'))
            ->assertSee($transaction->description)
            ->assertSee($transaction->category->name);
    }

    /** @test */
    public function it_can_filter_transactions_by_category()
    {
        $category = $this->create(Category::class);

        $transaction = $this->create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $newCategory = $this->create(Category::class);
        
        $newTransaction = $this->create(Transaction::class, [
            'category_id' => $newCategory->id
        ]);

        $this->get(route('transactions.index', $category->slug))
            ->assertSee($transaction->description)
            ->assertDontSee($newTransaction->description);
    }
    
    /** @test */
    public function it_can_filter_transactions_by_month()
    {
        $category = $this->create(Category::class);

        $currentTransaction = $this->create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $pastTransaction = $this->create(Transaction::class, [
            'category_id' => $category->id,
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
        $category = $this->create(Category::class);

        $currentTransaction = $this->create(Transaction::class, [
            'category_id' => $category->id
        ]);

        $pastTransaction = $this->create(Transaction::class, [
            'category_id' => $category->id,
            'created_at' => Carbon::now()->subMonths(2)
        ]);

        $this->get(route('transactions.index'))
            ->assertSee($currentTransaction->description)
            ->assertDontSee($pastTransaction->description);
    }
}
