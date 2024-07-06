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

    // create method start here 
    public function Edit($id)
    {
        $flat = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        $building = Building::where('client_id', Auth::guard('admin')->user()->id)->where('id', $flat->building_id)->first();
        return view('admin.flat.edit', compact('flat', 'building'));
    }
    // create method ends here 

    // storer method start here 
    public function Update(Request $request)
    {
        $data = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('id', $request->id)->first();
        $data['status'] = $request->status ? 1 : 0;
        $data->save();

        return redirect()->route('flat.index')->with('message', 'Flat creted successfully');
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
}
