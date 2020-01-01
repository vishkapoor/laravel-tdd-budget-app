<?php

namespace Tests\Feature\Budgets;

use App\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateBudgetsTest extends TestCase
{
    use RefreshDatabase;

    protected $category;

    protected function setUp() : void
    {
        parent::setUp();

        $this->category = $this->create(Category::class);
    }

    /** @test */
    public function it_can_update_budgets()
    {
        $budget = $this->create(Budget::class, [
            'category_id' => $this->category->id
        ]);

        $newBudget = $this->make(Budget::class, [
            'category_id' => $this->category->id
        ]);

        $this->put(route('budgets.update', $budget->id), $newBudget->toArray());

        $this->get(route('budgets.index'))
            ->assertSee($newBudget->amount);
    }

    /** @test */
    public function it_cannot_update_budgets_without_a_amount()
    {
        $this->updateBudget([
            'amount' => null,
            'category_id' => $this->category->id
        ])
        ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function it_cannot_update_budgets_without_a_category()
    {
        $this->updateBudget([
            'category_id' => null,
        ])
        ->assertSessionHasErrors('category_id');
    }
    
    /** @test */
    public function it_cannot_update_budgets_without_a_valid_amount()
    {
        $this->updateBudget([
            'amount' => 'c',
            'category_id' => $this->category->id
        ])
            ->assertSessionHasErrors('amount');
    }

    public function updateBudget($attributes = []) {

        $budget = $this->create(Budget::class);
        $newBudget = $this->make(Budget::class, $attributes);

        return $this->withExceptionHandling()
            ->put(route('budgets.update', $budget->id), $newBudget->toArray());

    }
}
