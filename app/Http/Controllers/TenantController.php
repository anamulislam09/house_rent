<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function Index()
    {
        $data = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.tenant.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function Create()
    {
        return view('admin.tenant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Store(Request $request)
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
    public function Edit($id)
    {
        $data = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.tenant.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(Request $request)
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
    public function AllDocuments()
    {
        $data = Document::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.tenant.documents', compact('data'));
    }

    public function CreateDocument()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.tenant.create_document', compact('tenants'));
    }

    public function StoreDocument(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'nid' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'tin' => 'file|mimes:jpeg,png,jpg,pdf|max:1024',
            'photo' => 'required|file|mimes:jpeg,png,jpg|max:1024',
            'deed' => 'file|mimes:jpeg,png,jpg,pdf|max:1024',
            'police_form' => 'file|mimes:jpeg,png,jpg,pdf|max:1024',
        ], [
            'tenant_id.required' => 'Please select a tenant.',
            'nid.required' => 'Please upload the NID/NRC document.',
            'nid.file' => 'The NID/NRC document must be a file.',
            'nid.mimes' => 'The NID/NRC document must be a file of type: jpeg, png, jpg, pdf.',
            'nid.max' => 'The NID/NRC document must not exceed 1 MB.',
            'tin.file' => 'The TIN document must be a file.',
            'tin.mimes' => 'The TIN document must be a file of type: jpeg, png, jpg, pdf.',
            'tin.max' => 'The TIN document must not exceed 1 MB.',
            'photo.required' => 'Please upload the tenant photo.',
            'photo.file' => 'The tenant photo must be a file.',
            'photo.mimes' => 'The tenant photo must be a file of type: jpeg, png, jpg.',
            'photo.max' => 'The tenant photo must not exceed 1 MB.',
            'deed.file' => 'The deed document must be a file.',
            'deed.mimes' => 'The deed document must be a file of type: jpeg, png, jpg, pdf.',
            'deed.max' => 'The deed document must not exceed 1 MB.',
            'police_form.file' => 'The police form must be a file.',
            'police_form.mimes' => 'The police form must be a file of type: jpeg, png, jpg, pdf.',
            'police_form.max' => 'The police form must not exceed 1 MB.',
        ]);

        $tenantDocument = new Document();

        $tenantDocument->tenant_id = $request->tenant_id;
        $tenantDocument->client_id = Auth::guard('admin')->user()->id;
        $tenantDocument->auth_id = Auth::guard('admin')->user()->id;

        if ($request->hasFile('nid')) {
            $nidPath = $request->file('nid')->store('tenant_documents/nid', 'public');
            $tenantDocument->nid = $nidPath;
        }

        if ($request->hasFile('tin')) {
            $tinPath = $request->file('tin')->store('tenant_documents/tin', 'public');
            $tenantDocument->tin = $tinPath;
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('tenant_documents/photo', 'public');
            $tenantDocument->photo = $photoPath;
        }

        if ($request->hasFile('deed')) {
            $deedPath = $request->file('deed')->store('tenant_documents/deed', 'public');
            $tenantDocument->deed = $deedPath;
        }

        if ($request->hasFile('police_form')) {
            $policeFormPath = $request->file('police_form')->store('tenant_documents/police_form', 'public');
            $tenantDocument->police_form = $policeFormPath;
        }

        $tenantDocument->save();

        return redirect()->route('tenant-document.index')->with('message', 'Documents uploaded successfully');
    }

    public function EditDocument($id)
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->get();
        $data = Document::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.tenant.edit_document', compact('tenants', 'data'));
    }

    public function UpdateDocument(Request $request,)
    {
        $id = $request->id;
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'nid' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'tin' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'deed' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'police_form' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        $document = Document::findOrFail($id);

        if ($request->hasFile('nid')) {
            // Delete the previous image
            if ($document->nid) {
                Storage::delete('public/' . $document->nid);
            }
            // Store the new image
            $document->nid = $request->file('nid')->store('tenant_documents/nid', 'public');
        }

        if ($request->hasFile('tin')) {
            // Delete the previous image
            if ($document->tin) {
                Storage::delete('public/' . $document->tin);
            }
            // Store the new image
            $document->tin = $request->file('tin')->store('tenant_documents/tin', 'public');
        }

        if ($request->hasFile('photo')) {
            // Delete the previous image
            if ($document->photo) {
                Storage::delete('public/' . $document->photo);
            }
            // Store the new image
            $document->photo = $request->file('photo')->store('tenant_documents/photo', 'public');
        }

        if ($request->hasFile('deed')) {
            // Delete the previous image
            if ($document->deed) {
                Storage::delete('public/' . $document->deed);
            }
            // Store the new image
            $document->deed = $request->file('deed')->store('tenant_documents/deed', 'public');
        }

        if ($request->hasFile('police_form')) {
            // Delete the previous image
            if ($document->police_form) {
                Storage::delete('public/' . $document->police_form);
            }
            // Store the new image
            $document->police_form = $request->file('police_form')->store('tenant_documents/police_form', 'public');
        }

        $document->tenant_id = $request->tenant_id;
        $document->save();

        return redirect()->route('tenant-document.index')->with('success', 'Document updated successfully');
    }

}
