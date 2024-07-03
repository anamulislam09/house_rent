<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.tenant.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tenant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $name = $request->name;
    $phone = $request->phone;
    $nid_no = $request->nid_no;
    $address = $request->address;
    $email = $request->email;

  Tenant::insert([
      'client_id' => Auth::guard('admin')->user()->id,
      'auth_id' => Auth::guard('admin')->user()->id,
      'name' => $name,
      'phone' => $phone,
      'nid_no' => $nid_no,
      'address' => $address,
      'email' => $email,
      'created_date' => date('d-M-Y'),
    ]);
    return redirect()->route('tenant.index')->with('message', 'Tenant Created Successfully');
  
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.tenant.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $client_id = $request->client_id;
        $data = Tenant::where('client_id', $client_id)->where('id', $id)->first();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['nid_no'] = $request->nid_no;
        $data['address'] = $request->address;
        $data['status'] = $request->status ? 1 : 0;
        // dd($data);
        $data->save();
        return redirect()->back()->with('message', 'Tenant Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
