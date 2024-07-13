<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exp_detail;
use App\Models\Expense;
use App\Models\ExpSetup;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// expense setup route start here 
    public function Exp_setup()
    {
        $exp_cat = Category::get();
        $expenses = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->orderBy('id', 'DESC')->get();
        return view('admin.expenses.expense.exp_setup', compact('exp_cat', 'expenses'));
    }

    public function Exp_setupStore(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $data['cat_id'] = $request->cat_id;
        $data['client_id'] = Auth::guard('admin')->user()->id;
        $data['exp_name'] = $request->exp_name;
        $data['date'] = date('Y-m');
        $data['created_by'] = Auth::guard('admin')->user()->id;
        // dd($data);
        $exp = ExpSetup::create($data);

        if (!$exp) {
            return redirect()->back()->with('message', 'Something went wrong');
        } else {
            return redirect()->back()->with('message', 'Expense creted successfully');
        }
    }

    public function Exp_setupEdit($id)
    {
        $data = ExpSetup::findOrFail($id);
        $exp_cat = Category::get();
        // dd($data);
        return view('admin.expenses.expense.edit_exp_setup', compact('data', 'exp_cat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Exp_setupUpdate(Request $request)
    {
        $id = $request->id;
        $data = ExpSetup::findOrFail($id);
        $data['cat_id'] = $request->cat_id;
        $data['exp_name'] = $request->exp_name;
        $data->save();
        return redirect()->back()->with('message', 'Expense Updated Uuccessfully.');
    }

    // expense setup route start here 

    // expense route start here 
    // public function Index()
    // {
    //     $month = Carbon::now()->month;
    //     $year = Carbon::now()->year;
    //     $ExpSetups = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->orderBy('id', 'DESC')->get();
    //     $expSummary = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('exp_setup_id', $ExpSetups->id)->where('month', $month)->where('year', $year)->groupBy('cat_id')->orderBy('id', 'DESC')->get();
    //     return view('admin.expenses.expense.expense_summary', compact('expSummary'));
    // }

    public function Index()
{
    $clientId = Auth::guard('admin')->user()->id;
    $month = Carbon::now()->month;
    $year = Carbon::now()->year;

    // Fetch ExpSetup records for the current client
    $ExpSetups = ExpSetup::where('client_id', $clientId)->orderBy('id', 'DESC')->get();
    
    // Pluck the IDs from the ExpSetups collection
    $expSetupIds = $ExpSetups->pluck('id')->toArray();

    // Fetch expense summary for the current month and year, grouped by category
    $expSummary = Expense::where('client_id', $clientId)
        ->whereIn('exp_setup_id', $expSetupIds)
        ->where('month', $month)
        ->where('year', $year)
        ->groupBy('exp_setup_id')
        ->orderBy('id', 'DESC')
        ->get();

    // Return the view with the expense summary
    return view('admin.expenses.expense.expense_summary', compact('expSummary'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $ExpSetups = ExpSetup::where('client_id', Auth::guard('admin')->user()->id)->orderBy('id', 'DESC')->get();
        $expense = Expense::where('client_id', Auth::guard('admin')->user()->id)->where('month', $month)->where('year', $year)->orderBy('id', 'DESC')->get();

        return view('admin.expenses.expense.create', compact('expense', 'ExpSetups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $data['client_id'] = Auth::guard('admin')->user()->id;
        $data['year'] = $year;
        $data['month'] = $month;
        $data['exp_setup_id'] = $request->exp_setup_id;
        $data['amount'] = abs($request->amount);
        $data['date'] = date('Y-m');
        $data['auth_id'] = Auth::guard('admin')->user()->id;
        // dd($data);
        $exp = Expense::create($data);

        if (!$exp) {
            return redirect()->back()->with('message', 'Something went wrong');
        } else {
            return redirect()->back()->with('message', 'Expense creted successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Exp_detail $exp_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Edit($id)
    {
        $data = Expense::findOrFail($id);
        $exp_setup = ExpSetup::get();
        return view('admin.expenses.expense.edit', compact('data', 'exp_setup'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(Request $request)
    {
        $id = $request->id;
        $data = Expense::findOrFail($id);
        $data['exp_setup_id'] = $request->exp_setup_id;
        $data['amount'] = abs($request->amount);
        $data->save();
        return redirect()->back()->with('message', 'Expense Updated Uuccessfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function Delate($id)
    {
        $data = Expense::findOrFail($id);
        $data->delete();
        return redirect()->back()->with('message', 'Expense deleted successfully.');
    }
}
