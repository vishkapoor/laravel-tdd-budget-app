<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCatgoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_delete_category()
    {
        $category = $this->create(Category::class);

        $this->delete(route('categories.destroy', $category->slug))
            ->assertRedirect(route('categories.index'));

        $this->get(route('categories.index'))
            ->assertDontSee($category->name);

    }

}
