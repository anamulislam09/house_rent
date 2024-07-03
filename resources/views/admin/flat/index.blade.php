@extends('layouts.admin')

@section('admin_content')
    <style>
        @media screen and (max-width: 767px) {

            div.dataTables_wrapper div.dataTables_length,
            div.dataTables_wrapper div.dataTables_filter,
            div.dataTables_wrapper div.dataTables_info,
            div.dataTables_wrapper div.dataTables_paginate {
                text-align: right !important;
            }

            .card-title a {
                font-size: 10px !important;
            }

            table,
            thead,
            tbody,
            tr,
            th,
            td {
                font-size: 13px !important;
                padding: 5px !important;
            }
        }

        .table td,
        .table th {
            padding: .30rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }
    </style>

    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">

                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title" style="width:100%; text-align:center; font-size:14px !important">All
                                    Flats </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th class="text-center">Building Name</th>
                                            <th class="text-center">Flat Name</th>
                                            <th class="text-center">Flat Location</th>
                                            <th class="text-center">Flat Rent</th>
                                            <th class="text-center">Service Charge</th>
                                            <th class="text-center">Utility Bill</th>
                                            {{-- <th class="text-center">Status</th> --}}
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            @php
                                                $building = App\Models\Building::where(
                                                    'client_id',
                                                    Auth::guard('admin')->user()->id,
                                                )
                                                    ->where('id', $item->building_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $building->name }}</td>
                                                <td>{{ $item->flat_name }}</td>
                                                <td>Floor {{ $item->flat_location }}</td>
                                                <td>{{ $item->flat_rent }}</td>
                                                <td>{{ $item->service_charge }}</td>
                                                <td>{{ $item->utility_bill }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
