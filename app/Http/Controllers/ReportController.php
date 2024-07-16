<?php

namespace App\Http\Controllers;

use App\Models\BillSetup;
use App\Models\Expense;
use App\Models\Income;
use App\Models\MonthlyBlance;
use App\Models\OpeningBalance;
use App\Models\OthersIncome;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //--------------- BIlls report function start here-------------------------> 
    public function BillReport()
    {
        $currentDate = Carbon::now()->format('Y-m');
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('status', 1)->get();
        $bills = BillSetup::where('client_id', Auth::guard('admin')->user()->id)->where('bill_setups.bill_setup_date', 'like', $currentDate . '%')->groupBy('tenant_id')->orderBy('id', 'DESC')->get();
        return view('admin.report.monthly_bill', compact('bills', 'tenants'));
    }

    public function BillReportFilter($tenantId = null, $date = null)   // get all collection  by filter
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = BillSetup::query()
            ->where('bill_setups.client_id', $clientId)
            ->join('tenants', 'bill_setups.tenant_id', '=', 'tenants.id')
            ->select(
                'tenants.name as tenant_name',
                'tenants.id as tenant_id',
                // 'buildings.name as building_name',
                'bill_setups.bill_setup_date as bill_setup_date',
                // 'bill_setups.collection_master_id as collection_master_id',
                DB::raw('SUM(bill_setups.total_collection_amount) as total_collection_amount')
            )
            ->groupBy('tenant_id');

        if ($tenantId) {
            $query->where('bill_setups.tenant_id', $tenantId);
        }

        if ($date) {
            $query->where('bill_setups.bill_setup_date', 'like', $date . '%');
        }
        $bills = $query->get();
        return response()->json($bills);
    }

    public function BillReportDetails($tenant_id = null, $bill_setup_date = null)
    {
        // dd($bill_setup_date);
        $bills_details = BillSetup::where('client_id', Auth::guard('admin')->user()->id)
            ->where('tenant_id', $tenant_id)
            ->where('bill_setups.bill_setup_date', 'like', $bill_setup_date . '%')
            ->orderBy('id', 'DESC')
            ->get();
        // dd($bills_details);

        return view('admin.report.monthly_bill_details', compact('bills_details'));
    }

    //--------------- BIlls report function ends here------------------------->

    //--------------- Collection report function start here------------------------->
    // Collection report function start here 
    public function CollectionReport()
    {
        $currentDate = Carbon::now()->format('Y-m');
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('status', 1)->get();
        $bills = BillSetup::where('client_id', Auth::guard('admin')->user()->id)->where('bill_setups.bill_setup_date', 'like', $currentDate . '%')->groupBy('tenant_id')->orderBy('id', 'DESC')->get();
        return view('admin.report.monthly_collection', compact('bills', 'tenants'));
    }


    public function collectionReportFilter($tenantId = null, $date = null)   // get all collection  by filter
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = BillSetup::query()
            ->where('bill_setups.client_id', $clientId)
            ->join('tenants', 'bill_setups.tenant_id', '=', 'tenants.id')
            ->select(
                'tenants.name as tenant_name',
                'tenants.id as tenant_id',
                'bill_setups.bill_setup_date as bill_setup_date',
                DB::raw('SUM(bill_setups.total_collection_amount) as total_collection_amount'),
                DB::raw('SUM(bill_setups.total_collection) as total_collection'),
            )
            ->groupBy('tenant_id');

        if ($tenantId) {
            $query->where('bill_setups.tenant_id', $tenantId);
        }

        if ($date) {
            $query->where('bill_setups.bill_setup_date', 'like', $date . '%');
        }
        $collections = $query->get();
        return response()->json($collections);
    }

    public function collectionReportDetails($tenant_id = null, $bill_setup_date = null)
    {
        // dd($bill_setup_date);
        $collection_details = BillSetup::where('client_id', Auth::guard('admin')->user()->id)
            ->where('tenant_id', $tenant_id)
            ->where('bill_setups.bill_setup_date', 'like', $bill_setup_date . '%')
            ->orderBy('id', 'DESC')
            ->get();
        // dd($bills_details);

        return view('admin.report.monthly_collection_details', compact('collection_details'));
    }

    //--------------- Collection report function ends here------------------------->

    //--------------- due report function start here------------------------->
    // Collection report function start here 
    public function DueReport()
    {
        $currentDate = Carbon::now()->format('Y-m');
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('status', 1)->get();
        $bills = BillSetup::where('client_id', Auth::guard('admin')->user()->id)->where('bill_setups.bill_setup_date', 'like', $currentDate . '%')->groupBy('tenant_id')->orderBy('id', 'DESC')->get();
        return view('admin.report.monthly_due', compact('bills', 'tenants'));
    }


    public function dueReportFilter($tenantId = null, $date = null)   // get all collection  by filter
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = BillSetup::query()
            ->where('bill_setups.client_id', $clientId)
            ->join('tenants', 'bill_setups.tenant_id', '=', 'tenants.id')
            ->select(
                'tenants.name as tenant_name',
                'tenants.id as tenant_id',
                'bill_setups.bill_setup_date as bill_setup_date',
                // DB::raw('SUM(bill_setups.total_collection_amount) as total_collection_amount'),
                DB::raw('SUM(bill_setups.current_due) as current_due'),
            )
            ->groupBy('tenant_id');

        if ($tenantId) {
            $query->where('bill_setups.tenant_id', $tenantId);
        }

        if ($date) {
            $query->where('bill_setups.bill_setup_date', 'like', $date . '%');
        }
        $collections = $query->get();
        return response()->json($collections);
    }

    public function dueReportDetails($tenant_id = null, $bill_setup_date = null)
    {
        // dd($bill_setup_date);
        $due_details = BillSetup::where('client_id', Auth::guard('admin')->user()->id)
            ->where('tenant_id', $tenant_id)
            ->where('bill_setups.bill_setup_date', 'like', $bill_setup_date . '%')
            ->orderBy('id', 'DESC')
            ->get();
        // dd($due_details);

        return view('admin.report.monthly_due_details', compact('due_details'));
    }

    //--------------- due report function ends here------------------------->

    // Display the form and current month data
    public function MonthlyExpense(Request $request)
    {
        $months = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $clientId = Auth::guard('admin')->user()->id;

        $monthly_exp = Expense::where('client_id', $clientId)
            ->where('month', $months)
            ->where('year', $year)
            ->groupBy('cat_id')
            ->get();
        $month = Expense::where('client_id', $clientId)
            ->where('month', $months)
            ->where('year', $year)
            ->first();

        return view('admin.report.monthly_expenses', compact('monthly_exp', 'month', 'months', 'year'));
    }

    // Handle form submission for filtering
    public function MonthlyAllExpense(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');
        return redirect()->route('expenses.month', ['month' => $months, 'year' => $year]);
    }


    // Display current year data by default
    public function YearlyExpense()
    {
        $currentYear = Carbon::now()->year;
        $yearly_expense = Expense::where('client_id', Auth::guard('admin')->user()->id)
            ->where('year', $currentYear)
            ->groupBy('cat_id')
            ->get();
        $years = Expense::where('client_id', Auth::guard('admin')->user()->id)
            ->where('year', $currentYear)
            ->first();

        return view('admin.report.yearly_expenses', compact('yearly_expense', 'years', 'currentYear'));
    }

    // Handle filtering by year
    public function YearlyAllExpense(Request $request)
    {
        $yearly_expense = Expense::where('client_id', Auth::guard('admin')->user()->id)
            ->where('year', $request->year)
            ->groupBy('cat_id')
            ->get();

        $year = Expense::where('year', $request->year)
            ->where('client_id', Auth::guard('admin')->user()->id)
            ->first();

        return redirect()->route('expenses.year')->with(['yearly_expense' => $yearly_expense, 'years' => $year, 'currentYear' => $request->year]);
    }

    public function ShowMonthlyIncome(Request $request)
    {
        $months = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
        $clientId = Auth::guard('admin')->user()->id;

        $m_income = Income::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->sum('paid');
        $month = Income::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->first();
        $m_opening_balance = OpeningBalance::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->first();
        $m_other_income = OthersIncome::where('month', $months)
            ->where('year', $year)
            ->where('client_id', $clientId)
            ->get();

        return view('admin.report.monthly_incomes', compact('m_income', 'month', 'm_opening_balance', 'm_other_income', 'months', 'year'));
    }

    public function HandleMonthlyIncome(Request $request)
    {
        $months = $request->input('month');
        $year = $request->input('year');

        return redirect()->route('incomes.month', ['month' => $months, 'year' => $year]);
    }

    // Display current year data by default
    public function YearlyIncome()
    {
        $currentYear = Carbon::now()->year;
        $y_income = Income::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
        $years = Income::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $y_opening_balance = OpeningBalance::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $y_other_income = OthersIncome::where('year', $currentYear)->where('client_id', Auth::guard('admin')->user()->id)->get();

        return view('admin.report.yearly_incomes', compact('y_income', 'years', 'y_opening_balance', 'y_other_income', 'currentYear'));
    }

    // Handle filtering by year
    public function YearlyAllIncome(Request $request)
    {
        $yearly_income = Income::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
        $year = Income::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $opening_balance = OpeningBalance::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->first();
        $others_income = OthersIncome::where('year', $request->year)->where('client_id', Auth::guard('admin')->user()->id)->get();

        return redirect()->route('incomes.year')->with(['yearly_income' => $yearly_income, 'opening_balance' => $opening_balance, 'year' => $year, 'others_income' => $others_income, 'currentYear' => $request->year]);
    }

    // Report for yearly income
}
