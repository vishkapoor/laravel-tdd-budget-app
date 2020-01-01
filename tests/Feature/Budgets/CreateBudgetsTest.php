<?php

namespace Tests\Feature\Budgets;

use App\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateBudgetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_budget()
    {
        $category = $this->create(Category::class);

        $budget = $this->make(Budget::class, [
            'category_id' => $category->id
        ]);

        $this->post(route('budgets.store'), $budget->toArray())
            ->assertRedirect(route('budgets.index'));

        $this->get(route('budgets.index'))
            ->assertSee($budget->amount);
    }

    /** @test */
    public function it_cannot_create_a_budget_without_amount()
    {
        $this->postBudget([
            'category_id' => $this->create(Category::class)->id,
            'amount' => null
        ])
        ->assertSessionHasErrors('amount');
    }

    /** @test */
    public function it_cannot_create_a_budget_without_a_valid_amount()
    {
        $this->postBudget([
            'category_id' => $this->create(Category::class)->id,
            'amount' => 'test'
        ])
        ->assertSessionHasErrors('amount');
    }    

     /** @test */
    public function it_cannot_create_a_budget_without_a_category()
    {
        $this->postBudget([
            'category_id' => null,
        ])
        ->assertSessionHasErrors('category_id');
    }  

     /** @test */
    public function it_cannot_create_a_budget_without_a_month()
    {
        $this->postBudget([
            'category_id' => $this->create(Category::class)->id,
            'month' => null
        ])
        ->assertSessionHasErrors('month');
    }  

    /** @test */
    public function it_cannot_create_a_budget_without_a_valid_month()
    {
        $category = $this->create(Category::class);

        $this->postBudget([
            'category_id' => $category->id,
            'month' => "test"
        ])
        ->assertSessionHasErrors('month');

    }  

    public function postBudget($attributes = [])
    {
        $budget = $this->make(Budget::class, $attributes);

        return $this
            ->withExceptionHandling()
            ->post(route('budgets.store'), $budget->toArray());
    }
}
