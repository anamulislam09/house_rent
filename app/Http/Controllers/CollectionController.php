<?php

namespace App\Http\Controllers;

use App\Models\BillSetup;
use App\Models\Collection;
use App\Models\Collection as ModelsCollection;
use App\Models\Flat;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    // get all collection 
    public function Index()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        $bills = BillSetup::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.collections.index', compact('tenants', 'bills'));
    }

    public function AllCollectionfilter($tenantId = null, $date = null)   // get all collection  by filter
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = BillSetup::query()
            ->where('bill_setups.client_id', $clientId)
            ->join('flats', 'bill_setups.flat_id', '=', 'flats.id')
            ->join('tenants', 'bill_setups.tenant_id', '=', 'tenants.id')
            ->join('buildings', 'flats.building_id', '=', 'buildings.id')
            ->select('bill_setups.*', 'flats.flat_name', 'tenants.name as tenant_name', 'tenants.id as tenant_id', 'buildings.name as building_name');
        if ($tenantId) {
            $query->where('bill_setups.tenant_id', $tenantId);
        }

        if ($date) {
            $query->where('bill_setups.bill_setup_date', 'like', $date . '%');
        }

        $bills = $query->get();
        return response()->json($bills);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.collections.create', compact('tenants'));
    }

    public function Collectionfilter($tenantId = null, $date = null)  // get all collection  by filter
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = BillSetup::query()
            ->where('bill_setups.client_id', $clientId)
            ->join('flats', 'bill_setups.flat_id', '=', 'flats.id')
            ->join('tenants', 'bill_setups.tenant_id', '=', 'tenants.id')
            ->join('buildings', 'flats.building_id', '=', 'buildings.id')
            ->select('bill_setups.*', 'flats.flat_name', 'tenants.name as tenant_name', 'tenants.id as tenant_id', 'buildings.name as building_name');
        if ($tenantId) {
            $query->where('bill_setups.tenant_id', $tenantId);
        }

        if ($date) {
            $query->where('bill_setups.bill_setup_date', 'like', $date . '%');
        }

        $bills = $query->get();

        return response()->json($bills);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $clientId = Auth::guard('admin')->user()->id;
        $currentDate = Carbon::now()->format('Y-m');

        // $v_id = 1;
        foreach ($request->bill_id as $i => $bill_id) {

        //     $isExist =  BillSetup::where('client_id', $clientId)
        //     ->where('tenant_id', $request->tenant_id)
        //     ->where('bill_setup_date', $request->bill_setup_date)->exists();
        // if ($isExist) {
        //     $inv_id = BillSetup::where('client_id', $clientId)
        //         ->where('tenant_id', $request->tenant_id)
        //         ->where('bill_setup_date', $request->bill_setup_date)->max('inv_id');
        //     $bill_setup['inv_id'] = $this->formatSrl(++$inv_id);
        // } else {
        //     $bill_setup['inv_id'] = $this->formatSrl($v_id);
        // } 

            $bill_setup = BillSetup::where('client_id', $clientId)
                ->where('id', $bill_id)
                ->where('bill_setup_date', $request->bill_setup_date)
                ->firstOrFail();

            $totalDue = $request->total_rent[$i] - $request->total_collection[$i];

            $bill_setup->total_collection = $request->total_collection[$i];
            $bill_setup->total_due = $totalDue;
            $bill_setup->collection_date = $currentDate;
            $bill_setup->save();

            Collection::create([
                'client_id' => $clientId,
                'auth_id' => $clientId,
                'agreement_id' => $bill_setup->agreement_id,
                'tenant_id' => $bill_setup->tenant_id,
                'flat_id' => $bill_setup->flat_id,
                'flat_rent' => $bill_setup->flat_rent,
                'service_charge' => $bill_setup->service_charge,
                'utility_bill' => $bill_setup->utility_bill,
                'total_rent' => $bill_setup->total_rent,
                'total_collection' => $request->total_collection[$i],
                'total_due' => $totalDue,
                'bill_setup_date' => $bill_setup->bill_setup_date,
                'collection_date' => $currentDate,
            ]);
        }
        return redirect()->route('collection.index')->with('message', 'Rent collection successfully');
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch (strlen($srl)) {
            case 1:
                $zeros = '00000';
                break;
            case 2:
                $zeros = '0000';
                break;
            case 3:
                $zeros = '000';
                break;
            case 4:
                $zeros = '00';
                break;
            default:
                $zeros = '0';
                break;
        }
        return $zeros . $srl;
    }
}
