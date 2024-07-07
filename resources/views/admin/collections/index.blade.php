@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none
        }

        table,
        thead,
        tbody,
        tr,
        td {
            font-size: 14px;
            padding: 5px !important;
        }

        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 14px;
            }

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 14px;
                padding: 5px !important;
            }

            .text {
                font-size: 14px;
            }

            .button {
                margin-top: -0px !important;
            }

            .date {
                margin-bottom: 15px;
            }
        }

        .text {
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <div class="row ">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title text" style="width:100%; text-align:center">All Collection
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <div class="row my-4">
                                            <div class="form-group col-lg-3 col-md-4 col-sm-6 date">
                                                <label for="">Tenant</label>
                                                <select name="tenant_id" class="form-control text" id="tenant" required>
                                                    <option value="0" selected disabled>Select Tenant</option>
                                                    @foreach ($tenants as $tenant)
                                                        <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-3 col-md-4 col-sm-6 date">
                                                <label class="text">Month</label>
                                                <input type="month" class="form-control text" id="date"
                                                    name="date" id="date" required>
                                            </div>
                                            <div class="form-group col-lg-2 mt-2">
                                                <label for="" class="col-form-label"></label>
                                                <button id="filterButton"
                                                    class="btn btn-sm btn-primary text form-control">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <a href="" class="btn btn-info btn-sm" id="generateBtn" target="_blank"
                                    style="display: none;">Money
                                    Receipt</a>

                                <div class="table-responsive">
                                    <table id="billsTable" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th> SL</th>
                                                <th>Tenant Name</th>
                                                <th>Flat Name</th>
                                                <th>Building Name</th>
                                                <th>Collection date</th>
                                                <th class="text-right">Total Rent</th>
                                                <th class="text-right">Total Collection</th>
                                                <th class="text-right">Total Due</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billsTable">
                                            @foreach ($collections as $key => $item)
                                                @php
                                                    $flat = App\Models\Flat::where('client_id', $item->client_id)
                                                        ->where('id', $item->flat_id)
                                                        ->first();
                                                    $tenant = App\Models\Tenant::where(
                                                        'client_id',
                                                        Auth::guard('admin')->user()->id,
                                                    )
                                                        ->where('id', $item->tenant_id)
                                                        ->value('name');
                                                    $building = App\Models\Building::where(
                                                        'client_id',
                                                        Auth::guard('admin')->user()->id,
                                                    )
                                                        ->where('id', $flat->building_id)
                                                        ->value('name');

                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $tenant }}</td>
                                                    <td>{{ $flat->flat_name }}</td>
                                                    <td>{{ $building }}</td>
                                                    <td>{{ date('F', strtotime($item->bill_setup_date)) }}</td>
                                                    <td class="text-right">{{ $item->total_rent }}</td>
                                                    <td class="text-right">{{ $item->total_collection }}</td>
                                                    <td class="text-right">{{ $item->total_due }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        {{-- <tfoot>
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </tfoot> --}}
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInputs = document.querySelectorAll('input[type="month"]');
            const today = new Date();
            const month = today.getMonth() + 1; // January is 0!
            const year = today.getFullYear();
            const formattedMonth = month < 10 ? '0' + month : month;
            const currentMonth = `${year}-${formattedMonth}`;

            dateInputs.forEach(input => {
                input.value = currentMonth;
            });

            $('#generateBtn').hide();
            $('#filterButton').on('click', function() {
                const tenantId = $('#tenant').val();
                const date = $('#date').val();

                $.ajax({
                    url: `/admin/rent-collection-all/filter/${tenantId}/${date}`,
                    method: 'GET',
                    success: function(response) {
                        $('tbody').empty();

                        if (response.length > 0) {
                            $('#generateBtn').show();
                            // Populate table with new data
                            response.forEach((bill, index) => {
                                const collectDate = new Date(bill.collection_date);
                                console.log(bill.collection_master_id);
                                const options = {
                                    month: 'long'
                                };
                                const formattedCollectDate = collectDate
                                    .toLocaleDateString('en-US', options);

                                $('tbody').append(`
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${bill.tenant_name}</td>
                            <td>${bill.flat_name}</td>
                            <td>${bill.building_name}</td>
                            <td>${formattedCollectDate}</td>
                            <td class="text-right">${bill.total_rent}</td>
                            <td class="text-right">${bill.total_collection}</td>
                            <td class="text-right">${bill.total_due}</td>
                        </tr>
                    `);
                                // Update the href of the generate button with the collection_master_id
                                $('#generateBtn').attr('href',
                                    `/admin/collection/money-receipt/${bill.collection_master_id}`
                                    );
                            });
                        } else {
                            $('#generateBtn').hide();
                            $('tbody').append(`
                    <tr>
                        <td colspan="8" class="text-center">No Collection Available of this Month</td>
                    </tr>
                `);
                        }
                    },
                });
            });



        });
    </script>
@endsection
