<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Month;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $builder = (new Transaction)->newQuery();

        if(request()->has('category')) {
            $category = Category::bySlug(request('category'))->first();
            $builder = $builder->byCategoryId($category->id);
        }

        $month = null;
        if(request()->has('month') && !empty(request('month'))) {
            $builder = $builder->byMonth(request('month'));
            $month = request('year');
        }

        $year = null;
        if(request()->has('year') && !empty(request('year'))) {
            $builder = $builder->byYear(request('year'));
            $year = request('year');
        }

        $transactions = $builder->with('category')
            ->paginate(10);

        $categories = Category::orderBy('name', 'asc')->get();
        
        $months = Month::get();

        return view('transactions.index', compact(
            'transactions', 
            'categories', 
            'months',
            'month'
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
        $transaction = new Transaction;

        return view('transactions.create', compact('categories', 'transaction'));
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
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric'
        ]);

        $transaction = Transaction::create($request->all());

        return redirect()->route('transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
     
        $this->validate($request, [
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric'
        ]);

        $transaction->update($request->all());

        return redirect('/transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect(route('transactions.index'));
    }
}
