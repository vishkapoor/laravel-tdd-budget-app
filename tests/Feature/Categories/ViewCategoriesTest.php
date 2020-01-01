<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewCategoriesTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function it_can_display_all_categories()
    {
    	$category = $this->create(Category::class);

    	$this->get('/categories')
    		->assertSee($category->name);
    }

    /** @test */
    public function it_allows_only_authenticated_users_to_categories_list()
    {
    	$this->signOut()
    		->withExceptionHandling()
    		->get(route('categories.index'))
    		->assertRedirect('/login');
    }

    /** @test */
    public function it_only_displays_categories_belongs_to_currently_logged_in_user()
    {
    	$category = $this->create(Category::class);
    	$otherCategory = create(Category::class, [ 'user_id' => create(User::class)->id ]);

    	$this->get(route('categories.index'))
    		->assertSee($category->name)
    		->assertDontSee($otherCategory->name);

    }

}
