<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {

        $data = Category::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.expenses.exp_category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        return view('admin.expenses.exp_category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        $data['client_id'] = Auth::guard('admin')->user()->id;
        $data['name'] = $request->name;
        Category::create($data);

        return redirect()->route('category.index')->with('message', 'Category creted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Destroy($id)
    {
        $data = Category::findOrFail($id);
        $data->delete();
        return redirect()->route('category.index')->with('message', 'Category deleted successfully.');
    }
}
