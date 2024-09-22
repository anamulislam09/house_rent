<?php

namespace App\Http\Controllers;

use App\Models\BillSetup;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpSetup;
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


    //--------------- expense report function start here------------------------->
    public function ExpenseReports()
    {
        $date = date('Y-m');
        $data['cats'] = Category::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.report.expense_report', compact('data'));
    }

    public function ExpenseReportShow(Request $request)
    {
        $date = $request->date; // e.g., '2024-09'
        $category_id = $request->category_id;
        $clientId = Auth::guard('admin')->user()->id;

        $query = Expense::query()
            ->join('exp_setups', 'expenses.exp_setup_id', '=', 'exp_setups.id')
            ->join('categories', 'exp_setups.cat_id', '=', 'categories.id')
            ->where('expenses.client_id', $clientId);

        // Apply category filter if a specific category is selected
        if ($category_id != 0) {
            $query->where('categories.id', $category_id);
        }

        // Apply date filter if a date is selected
        if ($date) {
            $query->where('expenses.date', 'like', "$date%");
        }

        $data = [
            'ledger' => $query->select('expenses.date', 'exp_setups.exp_name as name', 'expenses.amount')->get(),
            'total_amount' => $query->sum('expenses.amount')
        ];

        return response()->json($data, 200);
    }
    //--------------- expense report function ends here------------------------->
}
