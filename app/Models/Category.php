<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $guarded = []; 

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public static function boot()
    {
    	parent::boot();

    	static::addGlobalScope('user', function($query) {
    		$query->where('user_id', auth()->id());
    	});

    	static::saving(function($category) {
    		$category->slug = $category->slug ?: str_slug($category->name);
    		$category->user_id = $category->user_id ?: auth()->id();
    	});
    }
}
