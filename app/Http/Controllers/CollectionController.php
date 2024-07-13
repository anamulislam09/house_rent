<?php

namespace App\Http\Controllers;

use App\Models\BillSetup;
use App\Models\Building;
use App\Models\Client;
use App\Models\Collection;
use App\Models\CollectionMaster;
use App\Models\Flat;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class CollectionController extends Controller
{
    // get all collection 
    public function Index()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('status', 1)->get();
        $collections = Collection::where('client_id', Auth::guard('admin')->user()->id)->orderBy('id', 'DESC')->get();

        return view('admin.collections.index', compact('tenants', 'collections'));
    }

    public function AllCollectionfilter($tenantId = null, $date = null)   // get all collection  by filter
    {
        $clientId = Auth::guard('admin')->user()->id;
        $query = Collection::query()
            ->where('collections.client_id', $clientId)
            ->join('flats', 'collections.flat_id', '=', 'flats.id')
            ->join('tenants', 'collections.tenant_id', '=', 'tenants.id')
            ->join('buildings', 'flats.building_id', '=', 'buildings.id')
            ->select('collections.*', 'flats.flat_name', 'tenants.name as tenant_name', 'tenants.id as tenant_id', 'buildings.name as building_name');
        if ($tenantId) {
            $query->where('collections.tenant_id', $tenantId);
        }

        if ($date) {
            $query->where('collections.bill_setup_date', 'like', $date . '%');
        }

        $bills = $query->get();
        return response()->json($bills);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('status', 1)->get();
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
    public function Store(Request $request)
    {

        $clientId = Auth::guard('admin')->user()->id;
        $currentDate = Carbon::now()->format('Y-m');

        $collectionExist = Collection::where('client_id', $clientId)->where('tenant_id', $request->tenant_id)->where('bill_setup_date', $request->bill_setup_date)->exists();

        if (!$collectionExist) {
            // Get the latest invoice ID and increment it
            $isExist = CollectionMaster::where('client_id', $clientId)->exists();
            $v_id = 1;
            if ($isExist) {
                $inv_id = CollectionMaster::where('client_id', $clientId)->max('inv_id');
                $data['inv_id'] = $this->formatSrl(++$inv_id);
            } else {
                $data['inv_id'] = $this->formatSrl($v_id);
            }

            $data['client_id'] = $clientId;
            $data['auth_id'] = $clientId;
            $data['agreement_id'] = $request->agreement_id[0];
            $data['bill_id'] = $request->bill_id[0];
            $data['tenant_id'] = $request->tenant_id[0];
            $data['collection_date'] = $request->bill_setup_date[0];

            $total_rent_collection = 0;
            foreach ($request->bill_id as $i => $bill_id) {
                $total_rent_collection += abs($request->total_collection[$i]);
            }
            $data['total_rent_collection'] = $total_rent_collection;

            // Create a new CollectionMaster
            $collectionMaster = CollectionMaster::create($data);

            foreach ($request->bill_id as $i => $bill_id) {
                $bill_setup = BillSetup::where('client_id', $clientId)
                    ->where('id', $bill_id)
                    ->where('bill_setup_date', $request->bill_setup_date)
                    ->firstOrFail();

                $totalCollection = abs($request->total_collection[$i]);
                $totalDue = $request->total_collection_amount[$i] - $totalCollection;

                $bill_setup->update([
                    'total_collection' => $totalCollection,
                    'current_due' => $totalDue,
                    'collection_date' => date('Y-m-d'),
                ]);

                // Create a new Collection entry
                Collection::create([
                    'client_id' => $clientId,
                    'auth_id' => $clientId,
                    'agreement_id' => $bill_setup->agreement_id,
                    'collection_master_id' => $collectionMaster->id,
                    'tenant_id' => $bill_setup->tenant_id,
                    'flat_id' => $bill_setup->flat_id,
                    'flat_rent' => $bill_setup->flat_rent,
                    'service_charge' => $bill_setup->service_charge,
                    'utility_bill' => $bill_setup->utility_bill,
                    'total_current_month_rent' => $bill_setup->total_current_month_rent,
                    'previous_due' => $bill_setup->previous_due,
                    'total_collection_amount' => $bill_setup->total_collection_amount,
                    'total_collection' => $totalCollection,
                    'current_due' => $totalDue,
                    'bill_setup_date' => $bill_setup->bill_setup_date,
                    'collection_date' => date('Y-m-d'),
                ]);
            }
            return redirect()->back()->with('message', 'Rent collection successfully')->with('collectionsMaster', $collectionMaster);
        } else {
            return redirect()->back()->with('message', 'You have already collected this month rent.');
        }
    }

    public function MoneyReceipt($id)
    {
        $clientId = Auth::guard('admin')->user()->id;
        $collection_master = CollectionMaster::where('client_id', $clientId)->where('id', $id)->firstOrFail();
        $collections = Collection::where('client_id', $clientId)->where('collection_master_id', $collection_master->id)->get();
        $bill_amount = Collection::where('client_id', $clientId)->where('collection_master_id', $collection_master->id)->sum('total_collection_amount');

        // Get unique tenant IDs from collections
        $tenantIds = $collections->pluck('tenant_id')->unique();
        // Fetch tenant names
        $tenants = Tenant::where('client_id', $clientId)->whereIn('id', $tenantIds)->pluck('name');
        $flats = [];

        foreach ($collections as $collection) {
            // Assuming $flats is an associative array where keys are collection IDs and values are flat names
            $flat = Flat::where('client_id', $clientId)->where('id', $collection->flat_id)->first();
            $flats[$collection->id] = $flat->flat_name;
        }

        $client = Client::where('id', $clientId)->first();
        $pdf = PDF::loadView('admin.voucher.money_receipt_rent', [
            'client' => $client,
            'inv' => $collection_master,
            'bill' => $bill_amount,
            'collections' => $collections,
            'tenants' => $tenants,
            'flats' => $flats,
        ]);
        return $pdf->stream('Money_Receipt_Rent.pdf');
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
