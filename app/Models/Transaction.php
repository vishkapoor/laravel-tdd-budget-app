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

    public function scopeByMonth($query, $month) 
    {
        return $query->whereRaw(" concat(month(created_at), '-', year(created_at)) =  '" 
            . $month . "-". date('Y') . "'");
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public static function boot()
    {
    	parent::boot();

    	static::addGlobalScope('user', function($query) {
    		$query->where('user_id', auth()->id());
    	});

    	static::saving(function($transaction) {
    		$transaction->user_id = $transaction->user_id ?: auth()->id();
    	});

    }
}
