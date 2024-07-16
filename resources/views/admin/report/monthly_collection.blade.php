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
                                        <h3 class="card-title text" style="width:100%; text-align:center">Monthly Collection
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
                                {{-- <a href="" class="btn btn-info btn-sm" id="generateBtn" target="_blank"
                                    style="display: none;">Money
                                    Receipt</a> --}}

                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th> SL</th>
                                                <th>Tenant Name</th>
                                                {{-- <th>Flat Name</th>
                                                <th>Building Name</th> --}}
                                                <th>Date</th>
                                                {{-- <th>Collection month</th> --}}
                                                {{-- <th class="text-right">Current Month Rent</th> --}}
                                                {{-- <th class="text-right">Previous Due</th> --}}
                                                <th class="text-right">Collection</th>
                                                {{-- <th class="text-right">Collection</th>
                                                <th class="text-right">Current Due</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="billsTable">
                                            @foreach ($bills as $key => $item)
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
                                                    $total_collection_amount = App\Models\Collection::where(
                                                        'client_id',
                                                        Auth::guard('admin')->user()->id,
                                                    )
                                                        ->where('tenant_id', $item->tenant_id)
                                                        ->sum('total_collection_amount');
                                                    $collections = App\Models\Collection::where(
                                                        'client_id',
                                                        Auth::guard('admin')->user()->id,
                                                    )
                                                        ->where('tenant_id', $item->tenant_id)
                                                        ->sum('total_collection');
                                                    $current_due = App\Models\Collection::where(
                                                        'client_id',
                                                        Auth::guard('admin')->user()->id,
                                                    )
                                                        ->where('tenant_id', $item->tenant_id)
                                                        ->sum('current_due');
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $tenant }}</td>
                                                    {{-- <td>{{ $flat->flat_name }}</td>
                                                    <td>{{ $building }}</td> --}}
                                                    {{-- <td class="text-right">{{ $item->collection_date }}</td> --}}
                                                    <td class="text-right">
                                                        {{ date('F Y', strtotime($item->bill_setup_date)) }}</td>

                                                    <td class="text-right">{{ $collections }}</td>
                                                    {{-- <td class="text-right">{{ $collections }}</td>
                                                    <td class="text-right">{{ $current_due }}</td> --}}
                                                    <td class="text-center">
                                                        <a href="" class="btn btn-sm btn-info edit"
                                                            data-tenant_id="{{ $item->tenant_id }}"
                                                            data-bill_setup_date="{{ $item->bill_setup_date }}"
                                                            data-toggle="modal" data-target="#editUser"><i
                                                                class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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

    {{-- Edit Modal --}}
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="model-main">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Collections Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body"></div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let tenant_id = $(this).data('tenant_id');
            let bill_setup_date = $(this).data('bill_setup_date');

            $.get("/admin/collection/report-details/" + tenant_id + "/" + bill_setup_date, function(data) {
                $('#modal_body').html(data);
            });
        });
    </script>


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

            // $('#generateBtn').hide();

            $('#filterButton').on('click', function() {
                const tenantId = $('#tenant').val();
                const date = $('#date').val();

                $.ajax({
                    url: `/admin/collection/report-filter/${tenantId}/${date}`,
                    method: 'GET',
                    success: function(response) {
                        $('tbody').empty();

                        if (response.length > 0) {
                            // $('#generateBtn').show();

                            response.forEach((bill, index) => {
                                const bill_setup_date = new Date(bill.bill_setup_date);
                                const formattedDate = bill_setup_date
                                    .toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'long'
                                    });

                                $('tbody').append(`
                                    <tr>
                                        <td class="text-center">${index + 1}</td>
                                        <td>${bill.tenant_name}</td>
                                        <td class="text-right">${formattedDate}</td>
                                        <td class="text-right">${bill.total_collection}</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-info edit"
                                            data-tenant_id="${bill.tenant_id}"
                                            data-bill_setup_date="${bill.bill_setup_date}"
                                            data-toggle="modal" data-target="#editUser">
                                            <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                              `);
                            });
                        } else {
                            // $('#generateBtn').hide();
                            $('tbody').append(`
                                <tr>
                                    <td colspan="9" class="text-center">No Bills Available for this Month</td>
                                </tr>
                            `);
                        }
                    },
                });
            });
        });
    </script>
@endsection
