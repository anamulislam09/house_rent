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
                {{-- <div class="row">
                    <div class="col-lg-8 col-md-10 col-sm-12"> --}}
                        <div class="card">

                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title" style="width:100%; text-align:center; font-size:14px !important">All Building </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                    <table id="dataTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Rent</th>
                                                <th class="text-center">Service Charge</th>
                                                <th class="text-center">Utility Bill</th>
                                                <th class="text-center">Created By</th>
                                                <th class="text-center">Created date</th>
                                                {{-- <th class="text-center">Status</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($data as $key => $item)
                                            @php
                                                $auth_id = App\Models\Client::where('id', $item->auth_id)->first();
                                            @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->building_rent }}</td>
                                                    <td>{{ $item->service_charge }}</td>
                                                    <td>{{ $item->utility_bill}}</td>
                                                    <td>{{ $auth_id->name }}</td>
                                                    <td>{{$item->date}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    {{-- </div>
                </div> --}}
            </div>
        </section>
    </div>
@endsection
