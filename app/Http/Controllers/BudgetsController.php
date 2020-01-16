<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Models\Category;
use App\Models\Month;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BudgetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $builder = (new Budget)->newQuery();
        $category = new Category;
        $month = null;

        if(request()->has('category') && !empty(request('category'))) {
            $category = Category::bySlug(request('category'))->first();
            $builder = $builder->byCategoryId($category->id);
        }

        if(request()->has('month') && !empty(request('month'))) {
            $month = request('month');
            $builder =  $builder->byMonth($month);
        }

        $budgets = $builder->with('category.transactions')->get();

        $months = Month::get();
        $categories = Category::orderBy('name', 'asc')->get();


        return view('budgets.index', compact(
            'budgets', 
            'months', 
            'categories',
            'month',
            'category'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $budget = new Budget;

        $months = Month::get();

        return view('budgets.create', compact('categories', 'budget', 'months'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'month' => 'required|numeric|digits_between:1,12',
        ]);


        $budget = Budget::create($request->toArray());
            
        return redirect(route('budgets.index'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function edit(Budget $budget)
    {
        $categories = Category::all();
        $months = Month::get();

        return view('budgets.edit', compact('categories', 'months', 'budget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, Budget $budget)
    {
     
       $this->validate($request, [
            'amount' => 'required|numeric',
            'category_id' => 'required',
            'month' => 'required|numeric|digits_between:1,12',
        ]);

        $budget->update($request->all());

        return redirect(route('budgets.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Budget $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        $budget->delete();

        return redirect(route('budgets.index'));
    }
}
