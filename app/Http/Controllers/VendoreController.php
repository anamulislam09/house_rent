<?php

namespace App\Http\Controllers;

use App\Models\Addressbook;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Auth;

class VendoreController extends Controller
{
    public function VendorIndex()
    {
        $vendors = Vendor::where('client_id', Auth()->guard('admin')->user()->id)->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function VendorCreate()
    {
        return view('admin.vendors.create');
    }

    public function VendorStore(Request $request)
    {

        $data['date'] = date('m/d/y');
        $data['client_id'] = Auth()->guard('admin')->user()->id;
        $data['auth_id'] = Auth()->guard('admin')->user()->id;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        Vendor::create($data);
        return redirect()->route('vendor.all')->with('message', 'Vendor Created Successfully!');
    }

    public function VendorEdit($id)
    {
        $data = Vendor::where('client_id', Auth()->guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.vendors.edit', compact('data'));
    }

    public function VendorUpdate(Request $request)
    {
        $id = $request->id;
        $data = Vendor::where('client_id', Auth()->guard('admin')->user()->id)->where('id', $id)->first();
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data->save();
        return redirect()->back()->with('message', 'Vendor Update Successfully');
    }
}
