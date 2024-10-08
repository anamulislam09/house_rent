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
        $data = Tenant::where('client_id', Auth::guard('admin')->user()->id)->orderBy('id', 'DESC')->get();
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
            $nidFile = $request->file('nid');
            $nidFileName = time() . '_nid.' . $nidFile->getClientOriginalExtension();
            $nidFile->move(public_path('tenant_documents/nid'), $nidFileName);
            $tenantDocument->nid = 'tenant_documents/nid/' . $nidFileName;
        }
    
        if ($request->hasFile('tin')) {
            $tinFile = $request->file('tin');
            $tinFileName = time() . '_tin.' . $tinFile->getClientOriginalExtension();
            $tinFile->move(public_path('tenant_documents/tin'), $tinFileName);
            $tenantDocument->tin = 'tenant_documents/tin/' . $tinFileName;
        }
    
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoFileName = time() . '_photo.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('tenant_documents/photo'), $photoFileName);
            $tenantDocument->photo = 'tenant_documents/photo/' . $photoFileName;
        }
    
        if ($request->hasFile('deed')) {
            $deedFile = $request->file('deed');
            $deedFileName = time() . '_deed.' . $deedFile->getClientOriginalExtension();
            $deedFile->move(public_path('tenant_documents/deed'), $deedFileName);
            $tenantDocument->deed = 'tenant_documents/deed/' . $deedFileName;
        }
    
        if ($request->hasFile('police_form')) {
            $policeFormFile = $request->file('police_form');
            $policeFormFileName = time() . '_police_form.' . $policeFormFile->getClientOriginalExtension();
            $policeFormFile->move(public_path('tenant_documents/police_form'), $policeFormFileName);
            $tenantDocument->police_form = 'tenant_documents/police_form/' . $policeFormFileName;
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

    public function UpdateDocument(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'nid' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'tin' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'photo' => 'nullable|file|mimes:jpeg,png,jpg|max:1024',
            'deed' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
            'police_form' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:1024',
        ]);
    
        $document = Document::findOrFail($id);
    
        $document->tenant_id = $request->tenant_id;
        $document->client_id = Auth::guard('admin')->user()->id;
        $document->auth_id = Auth::guard('admin')->user()->id;
    
        if ($request->hasFile('nid')) {
            if ($document->nid && file_exists(public_path($document->nid))) {
                unlink(public_path($document->nid));
            }
            $nidFile = $request->file('nid');
            $nidFileName = time() . '_nid.' . $nidFile->getClientOriginalExtension();
            $nidFile->move(public_path('tenant_documents/nid'), $nidFileName);
            $document->nid = 'tenant_documents/nid/' . $nidFileName;
        }
    
        if ($request->hasFile('tin')) {
            if ($document->tin && file_exists(public_path($document->tin))) {
                unlink(public_path($document->tin));
            }
            $tinFile = $request->file('tin');
            $tinFileName = time() . '_tin.' . $tinFile->getClientOriginalExtension();
            $tinFile->move(public_path('tenant_documents/tin'), $tinFileName);
            $document->tin = 'tenant_documents/tin/' . $tinFileName;
        }
    
        if ($request->hasFile('photo')) {
            if ($document->photo && file_exists(public_path($document->photo))) {
                unlink(public_path($document->photo));
            }
            $photoFile = $request->file('photo');
            $photoFileName = time() . '_photo.' . $photoFile->getClientOriginalExtension();
            $photoFile->move(public_path('tenant_documents/photo'), $photoFileName);
            $document->photo = 'tenant_documents/photo/' . $photoFileName;
        }
    
        if ($request->hasFile('deed')) {
            if ($document->deed && file_exists(public_path($document->deed))) {
                unlink(public_path($document->deed));
            }
            $deedFile = $request->file('deed');
            $deedFileName = time() . '_deed.' . $deedFile->getClientOriginalExtension();
            $deedFile->move(public_path('tenant_documents/deed'), $deedFileName);
            $document->deed = 'tenant_documents/deed/' . $deedFileName;
        }
    
        if ($request->hasFile('police_form')) {
            if ($document->police_form && file_exists(public_path($document->police_form))) {
                unlink(public_path($document->police_form));
            }
            $policeFormFile = $request->file('police_form');
            $policeFormFileName = time() . '_police_form.' . $policeFormFile->getClientOriginalExtension();
            $policeFormFile->move(public_path('tenant_documents/police_form'), $policeFormFileName);
            $document->police_form = 'tenant_documents/police_form/' . $policeFormFileName;
        }
    
        $document->save();
    
        return redirect()->route('tenant-document.index')->with('success', 'Document updated successfully');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function ShowDocument($id)
    {
        $tenant_document = Document::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        $tenant = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('id', $tenant_document->tenant_id)->first();
        return view('admin.tenant.show_document', compact('tenant_document', 'tenant'));
    }

}
