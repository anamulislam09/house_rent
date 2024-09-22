
<style>
    .modal-dialog {
        max-width: 800px;
        margin: 1.75rem auto;
    }
    </style>
    
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Tenant Name</th>
                        <th>Flat Name</th>
                        <th>Building Name</th>
                        <th>Date</th>
                        <th class="text-right">Current Month Rent</th>
                        <th class="text-right">Previous Due</th>
                        <th class="text-right">Bill Amount</th>
                    </tr>
                </thead>
                <tbody id="billsTable">
                    @foreach ($bills_details as $key => $item)
                        @php
                            $flat = App\Models\Flat::where('client_id', $item->client_id)
                                ->where('id', $item->flat_id)
                                ->first();
                            $tenant = App\Models\Tenant::where('client_id', Auth::guard('admin')->user()->id)
                                ->where('id', $item->tenant_id)
                                ->value('name');
                            $building = App\Models\Building::where('client_id', Auth::guard('admin')->user()->id)
                                ->where('id', $flat->building_id)
                                ->value('name');
                        @endphp
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $tenant }}</td>
                            <td>{{ $flat->flat_name }}</td>
                            <td>{{ $building }}</td>
                            <td class="text-right">{{ date('F Y', strtotime($item->bill_setup_date)) }}</td>
                            <td class="text-right">{{ number_format($item->total_current_month_rent , 2) }}</td>
                            <td class="text-right">{{ number_format($item->previous_due , 2) }}</td>
                            <td class="text-right">{{ number_format($item->total_collection_amount , 2) }}</td>
                         
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    