<?php

namespace Tests\Feature\Budgets;

use App\Budget;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteBudgetsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_delete_budget()
    {
        $category = $this->create(Category::class);

        $budget = $this->create(Budget::class, [
            'category_id' => $category->id
        ]);

        $this->delete(route('budgets.destroy', $budget->id))
            ->assertRedirect(route('budgets.index'));
    }
}
