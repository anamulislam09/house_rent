<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Http\Request;
use sirajcse\UniqueIdGenerator\UniqueIdGenerator;
use Auth;
use Carbon\Carbon;

class FlatController extends Controller
{
    // Index method start here 
    public function Index()
    {

        $data = Flat::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.flat.index', compact('data'));
    }
    // Index method ends here 

    // create method start here 
    public function Create()
    {
        $building = Building::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.flat.create', compact('building'));
    }
    // create method ends here 

    // storer method start here 
    public function Store(Request $request)
    {
        $isExist = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('building_id', $request->building_id)->where('flat_name', $request->flat_name)->exists();
        if ($isExist) {
            return redirect()->back()->with('message', 'The flat`s name will be unique.');
        } else {

            $data['client_id'] = Auth::guard('admin')->user()->id;
            $data['auth_id'] = Auth::guard('admin')->user()->id;
            $data['building_id'] = $request->building_id;
            $data['flat_name'] = $request->flat_name;
            $data['flat_location'] = $request->flat_location;
            $data['flat_rent'] = $request->flat_rent;
            $data['service_charge'] = $request->service_charge;
            $data['utility_bill'] = $request->utility_bill;
            $data['date'] = date('d-m-Y');
            Flat::create($data);

            return redirect()->route('flat.index')->with('message', 'Flat creted successfully');
        }
    }

    // unique id serial function
    public function formatSrl($srl)
    {
        switch (strlen($srl)) {
            case 1:
                $zeros = '00';
                break;
            case 2:
                $zeros = '0';
                break;
            default:
                $zeros = '0';
                break;
        }
        return $zeros . $srl;
    }

    // store method ends here 

    // flat single create start here
    // public function SingleCreate()
    // {
    //     return view('admin.flat.single_create');
    // }
    // flat single create start here

    // flat SingleStore start here
    // public function SingleStore(Request $request)
    // {
    //     $unique_name = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('flat_name', $request->flat_name)->exists();
    //     if ($unique_name) {
    //         return redirect()->back()->with('message', 'Flat name already taken.');
    //     } else {
    //         $unique_id = Flat::where('client_id', Auth::guard('admin')->user()->id)->max('flat_id');
    //         $flat = Flat::where('client_id', Auth::guard('admin')->user()->id)->first();

    //         $zeroo = '0';
    //         $data['flat_id'] = ($zeroo) . ++$unique_id;
    //         $data['client_id'] = Auth::guard('admin')->user()->id;
    //         $data['flat_name'] = $request->flat_name;
    //         $data['floor_no'] = $request->floor_no;
    //         $data['charge'] = "Service Charge";
    //         $data['amount'] = $flat->amount;
    //         $data['create_date'] = date('d');
    //         $data['create_month'] = date('F');
    //         $data['create_year'] = date('Y');

    //         $flat = Flat::create($data);
    //         if ($flat) {
    //             $latest_flat = Flat::where('client_id', Auth::guard('admin')->user()->id)->latest()->first();
    //             $user = User::insert([
    //                 'user_id' => $latest_flat->client_id . $latest_flat->flat_id,
    //                 'client_id' => $latest_flat->client_id,
    //                 'flat_id' => $latest_flat->flat_id,
    //                 'charge' => $latest_flat->charge,
    //                 'amount' => $latest_flat->amount,
    //             ]);
    //             if ($user) {
    //                 return redirect()->route('flat.index')->with('message', 'Flat creted successfully');
    //             } else {
    //                 return redirect()->back()->with('message', 'Something Went Wrong');
    //             }
    //         }
    //     }
    // }
    // flat SingleStore ends here
}
