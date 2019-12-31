<?php

namespace Tests\Feature\Transactions;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoriesTest extends TestCase
{
    use RefreshDatabase;
    
     /** @test */
    public function it_can_create_categories()
    {
        $category = $this->make(Category::class);

        $this->post('/categories', $category->toArray())
            ->assertRedirect(route('categories.index'));

        $this->get(route('categories.index'))
            ->assertSee($category->name);

    }
    
     /** @test */
    public function it_cannot_create_categories_without_a_name()
    {
        $this->postCategory(['name' => null])
            ->assertSessionHasErrors('name');
    }

    public function postCategory($attributes = []) {

        $category = $this->make(Category::class, $attributes);

        return $this->withExceptionHandling()
            ->post('/categories', $category->toArray());

    }

}
