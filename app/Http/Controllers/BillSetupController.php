<?php

namespace App\Http\Controllers;

use App\Models\BillSetup;
use App\Models\Flat;
use App\Models\FlatLedger;
use App\Models\RentalAgreement;
use App\Models\RentalAgreementDetails;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {

        $bills = BillSetup::where('client_id', Auth::guard('admin')->user()->id)->get();
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.bill_setup.index', compact('bills', 'tenants'));
    }

    public function filterBills($tenantId = null, $date = null)
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = BillSetup::query()->where('client_id', $clientId);
        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }
        if ($date) {
            $query->where('date', 'like', $date . '%');
        }
        $bills = $query->get();
        // Append flat_name to each bill
        foreach ($bills as $bill) {
            $flat = Flat::where('client_id', $clientId)->where('id', $bill->flat_id)->first();
            $bill->flat_name = $flat->flat_name; // Adjust this line if the field name is different
        }
        return response()->json($bills);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.bill_setup.create', compact('tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
    {
        $clientId = Auth::guard('admin')->user()->id;
        $tenantId = $request->tenant_id;
        $currentDate = Carbon::now()->format('Y-m');
        $inputDate = Carbon::parse($request->date)->format('Y-m');

        $isExists = RentalAgreement::where('client_id', $clientId)->where('tenant_id', $tenantId)->exists();
        if (!$isExists) {
            return redirect()->back()->with('message', 'No agreement has been made yet!');
        }

        if ($inputDate > $currentDate) {
            return redirect()->back()->with('message', 'OPS! It is not possible to add data for an advance month. Please select the current month.');
        } elseif ($inputDate < $currentDate) {
            return redirect()->back()->with('message', 'OPS! It is not possible to add data for a previous month. Please select the current month.');
        }

        $isBillExists = BillSetup::where('client_id', $clientId)->where('tenant_id', $tenantId)->where('date', $inputDate)->exists();
        if ($isBillExists) {
            $bills = BillSetup::where('client_id', $clientId)->where('tenant_id', $tenantId)->where('date', $inputDate)->get();
            return redirect()->back()->with('message', 'You have already generated the bill for this month!')->with('bills', $bills);
        }

        $flats = FlatLedger::where('client_id', $clientId)->where('tenant_id', $tenantId)->get();
        $agreement = RentalAgreement::where('client_id', $clientId)->where('tenant_id', $tenantId)->first();
        $previousMonthDate = Carbon::parse($currentDate)->subMonth()->format('Y-m');
        $previousDues = BillSetup::where('client_id', $clientId)->where('tenant_id', $tenantId)->where('date', $previousMonthDate)->get();

        foreach ($flats as $i => $flat) {
            $totalDue = isset($previousDues[$i]) ? $previousDues[$i]->total_due : 0;

            BillSetup::create([
                'client_id' => $clientId,
                'auth_id' => $clientId,
                'agreement_id' => $agreement->id,
                'tenant_id' => $tenantId,
                'flat_id' => $flat->flat_id,
                'flat_rent' => $flat->rent,
                'service_charge' => $flat->service_charge,
                'utility_bill' => $flat->utility_bill,
                'total_rent' => $flat->rent + $flat->service_charge + $flat->utility_bill + $totalDue,
                'date' => $currentDate,
            ]);
        }

        $bills = BillSetup::where('client_id', $clientId)->where('tenant_id', $tenantId)->where('date', $inputDate)->get();
        // dd($bills);
        return redirect()->back()->with('message', 'Bill generated successfully')->with('bills', $bills);
    }



    /**
     * Display the specified resource.
     */
    public function show(BillSetup $billSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillSetup $billSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillSetup $billSetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillSetup $billSetup)
    {
        //
    }
}
