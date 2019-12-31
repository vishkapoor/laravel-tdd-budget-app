<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_update_category()
    {
        $category = $this->create(Category::class);

        $newCategory = $this->make(Category::class);

        $this->put(route('categories.update', $category->slug), $newCategory->toArray())
            ->assertRedirect(route('categories.index'));

        $this->get(route('categories.index'))
            ->assertSee($newCategory->name);
    }


    /** @test */
    public function it_cannot_update_categories_without_a_name()
    {
        $category = $this->create(Category::class);
        $newCategory = $this->make(Category::class, [
            'name' => null,
        ]);

        $this->withExceptionHandling()
            ->put(route('categories.update', $category->slug), $newCategory->toArray())
            ->assertSessionHasErrors('name');
    }
}
