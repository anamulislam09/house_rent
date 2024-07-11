<?php

namespace App\Http\Controllers;

use App\Models\AdvancedAmount;
use App\Models\Building;
use App\Models\Client;
use App\Models\Flat;
use App\Models\FlatLedger;
use App\Models\RentalAgreement;
use App\Models\RentalAgreementDetails;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class RentalAgreementController extends Controller
{
    public function Index()
    {
        $data = RentalAgreement::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.rental_agreement.index', compact('data'));
    }

    public function Create()
    {
        $tenants = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('status',1)->get();
        $buildings = Building::where('client_id', Auth::guard('admin')->user()->id)->get();
        return view('admin.rental_agreement.create', compact('tenants', 'buildings'));
    }

    // get building and flat using jquery
    public function GetFlat(Request $request)
    {
        $data['building'] = Building::where('client_id', Auth::guard('admin')->user()->id)->where('id', $request->building_id)->first();
        $data['flat'] = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('building_id', $data['building']->id)->where('status',1)->where('booking_status',0)->get();
        return response()->json($data);
    }

    // get and flat info using jquery
    public function GetFlatInfo(Request $request)
    {
        $data['flat_info'] = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('id', $request->flat_id)->first();
        return response()->json($data);
    }

    // store all data 
    public function Store(Request $request)
    {
        $tenant_id = $request->tenant_id;
        $building_id = $request->building_id;
        $advanced = abs($request->advanced);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $duration = $request->duration;
        $notice_period = $request->notice_period;

        // Insert into RentalAgreement table
        $rentalAgreement = RentalAgreement::create([
            'client_id' => Auth::guard('admin')->user()->id,
            'auth_id' => Auth::guard('admin')->user()->id,
            'tenant_id' => $tenant_id,
            'building_id' => $building_id,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'duration' => $duration,
            'notice_period' => $notice_period,
            'advanced' => $advanced,
            'status' => 1,
            'created_date' => date('d-M-Y'),
        ]);

        // Check if RentalAgreement was successfully created
        if ($rentalAgreement) {
            $rental_agreement_id = $rentalAgreement->id;
            $flat_ids = $request->flat_id;

            $isExist = AdvancedAmount::where('client_id', Auth::guard('admin')->user()->id)->exists();
            $inv_id = 1;
            if ($isExist) {
                $invoice_id = AdvancedAmount::where('client_id', Auth::guard('admin')->user()->id)->max('inv_id');
                $item['inv_id'] = $this->formatSrl(++$invoice_id);
            } else {
                $item['inv_id'] = $this->formatSrl($inv_id);
            }
            $item['client_id'] = Auth::guard('admin')->user()->id;
            $item['auth_id'] = Auth::guard('admin')->user()->id;
            $item['tenant_id'] = $tenant_id;
            $item['agreement_id'] = $rental_agreement_id;
            $item['deposit'] = $advanced;
            $item['balance'] = $advanced;
            $item['particular'] = 'Advanced';
            $item['date'] = date('d-M-Y');

            AdvancedAmount::create($item);

            // Insert into RentalAgreementDetails for each flat_id
            foreach ($flat_ids as $flat_id) {
                RentalAgreementDetails::create([
                    'rental_agreement_id' => $rental_agreement_id,
                    'tenant_id' => $tenant_id,
                    'flat_id' => $flat_id,
                ]);
            }
            // update flat booking status 
            foreach ($flat_ids as $flat_id) {
                $data = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('id', $flat_id)->first();
                $data['booking_status'] = 1;
                $data->save();
            }   
            // Insert into FlatLedger for each flat
            foreach ($flat_ids as $flat_id) {
                $flat_info = Flat::where('client_id', Auth::guard('admin')->user()->id)->where('id', $flat_id)->first();
                FlatLedger::create([
                    'client_id' => Auth::guard('admin')->user()->id,
                    'auth_id' => Auth::guard('admin')->user()->id,
                    'agreement_id' => $rental_agreement_id,
                    'tenant_id' => $tenant_id,
                    'flat_id' => $flat_id,
                    'rent' => $flat_info->flat_rent,
                    'service_charge' => $flat_info->service_charge,
                    'utility_bill' => $flat_info->utility_bill,
                    'date' => date('m-Y'),
                ]);
            }

            // Update Tenant balance
            $tenant = Tenant::where('client_id', Auth::guard('admin')->user()->id)
                ->where('id', $tenant_id)
                ->first();
            if ($tenant) {
                $tenant->balance = $advanced;
                $tenant->save();
            }

            return redirect()->route('rental-agreement.index')->with('message', 'Rental Agreement Successfully');
        } else {
            return redirect()->back()->with('message', 'Something went wrong!');
        }
    }


    // MOney Receipt
    public function MoneyReceipt($id)
    {
        $agreementInfo = RentalAgreement::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        $agreementDetails = RentalAgreementDetails::where('rental_agreement_id', $agreementInfo->id)->get();
        $inv = AdvancedAmount::where('client_id', Auth::guard('admin')->user()->id)->where('agreement_id', $agreementInfo->id)->first();
        $tenant = Tenant::where('client_id', Auth::guard('admin')->user()->id)->where('id', $agreementInfo->tenant_id)->first();
        $client = Client::where('id', Auth::guard('admin')->user()->id)->first();

        $data = [
            'agreementInfo' => $agreementInfo,
            'agreementDetails' => $agreementDetails,
            'inv' => $inv,
            'tenant' => $tenant,    
            'client' => $client,
        ];
        // dd($data);
        $pdf = PDF::loadView('admin.voucher.money_receipt', $data);
        return $pdf->stream('Money_Receipt.pdf');
    }


    public function Edit($id)
    {
        $data = RentalAgreement::where('client_id', Auth::guard('admin')->user()->id)->where('id', $id)->first();
        return view('admin.rental_agreement.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Update(Request $request)
    {
        $id = $request->id;
        $client_id = $request->client_id;
        $data = RentalAgreement::where('client_id', $client_id)->where('id', $id)->first();
        $data['status'] = $request->status ? 1 : 0;
        $data->save();
        return redirect()->back()->with('message', 'Agreement Status Update Successfully');
    }

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
