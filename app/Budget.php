<?php

namespace App;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $guarded = [];

    public function scopeByMonth($query, $month) 
    {
        return $query->where('month', $month);
    }

    public function scopeByCategoryId($query, $id) 
    {
        return $query->where('category_id', $id);
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function balance()
    {
    	return $this->amount - $this->category->transactions->sum('amount');
    }

    function getMonthNameAttribute($monthNumber)
	{
	    return date("F", mktime(0, 0, 0, $monthNumber, 1));
	}

	public static function boot()
    {
    	parent::boot();

    	static::addGlobalScope('user', function($query) {
    		$query->where('user_id', auth()->id());
    	});

    	static::saving(function($budget) {
    		$budget->user_id = $budget->user_id ?: auth()->id();
    	});

    }

}
