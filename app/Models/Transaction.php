<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded  = [];

    public function scopeByCategoryId($query, $id) 
    {
        return $query->where('category_id', $id);
    }

    public function scopeByMonth($query, $month) 
    {
        return $query->whereRaw( 'month(created_at) = ' . $month );
    }

    public function scopeByYear($query, $year) 
    {
        return $query->whereRaw( 'year(created_at) = ' . $year );
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
