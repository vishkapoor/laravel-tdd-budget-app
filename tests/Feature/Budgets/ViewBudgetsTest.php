<?php

namespace Tests\Feature\Budgets;

use App\Budget;
use App\Models\Category;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewBudgetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_display_budgets_for_the_selected_month()
    {

        $category = $this->create(Category::class);

        $budgetForThisMonth = $this->create(Budget::class, [
            'category_id' => $category->id,
            'month' => Carbon::now()->month
        ]);

        $budgetForLastMonth = $this->create(Budget::class, [
            'month' => Carbon::now()->subMonth(3)->month,
            'category_id' => $category->id
        ]);

        $this->get(route('budgets.index') . "?month=" . $budgetForThisMonth->month)
            ->assertSee($budgetForThisMonth->amount)
            ->assertSee($budgetForThisMonth->balance())
            ->assertDontSee($budgetForLastMonth->amount)
            ->assertDontSee($budgetForLastMonth->balance());

    }

    /** @test */
    public function it_allows_only_authenticated_users_to_budget_list()
    {
        $this->signOut()
            ->withExceptionHandling()
            ->get(route('budgets.index'))
            ->assertRedirect(route('login'));
    }


    /** @test */
    public function it_only_displays_budgets_belongs_to_currently_logged_in_user()
    {
        $category = $this->create(Category::class);

        $budget = $this->create(Budget::class, [
            'category_id' => $category->id
        ]);

        $otherbudget = create(Budget::class, [ 
            'category_id' => $category->id,
            'user_id' => create(User::class)->id
        ]);

        $this->get(route('budgets.index'))
            ->assertSee($budget->amount)
            ->assertDontSee($otherbudget->amount);

    }
}
