<?php

namespace Tests\Unit;

use App\Budget;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BudgetTest extends TestCase
{

	use RefreshDatabase;

    /** @test */
    public function it_has_a_balance()
    {
    	$category = $this->create(Category::class);

    	$transactions = $this->create(Transaction::class, [
    		'category_id' => $category->id
    	]);

    	$budget = $this->create(Budget::class, [
    		'category_id' => $category->id
    	]);

    	$expectedBalance = $budget->amount - $transactions->sum('amount');

    	$this->assertEquals($expectedBalance, $budget->balance());

    }

}
