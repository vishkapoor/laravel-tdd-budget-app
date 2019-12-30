<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded  = [];

    public function scopeByCategory($query, Category $category) 
    {
    	if($category->exists) {
    		return $query->where('category_id', $category->id);
    	}
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
}