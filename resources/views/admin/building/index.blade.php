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
        .text{
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
                        <h3 class="card-title" style="width:100%; text-align:center; font-size:14px !important">All Building
                        </h3>
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
                                    <th class="text-center">Action</th>
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
                                        <td class="text-right">{{ number_format($item->building_rent, 2) }}</td>
                                        <td class="text-right">{{ number_format($item->service_charge, 2) }}</td>
                                        <td class="text-right">{{ number_format($item->utility_bill, 2) }}</td>
                                        <td>{{ $auth_id->name }}</td>
                                        <td>{{ $item->date }}</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-info edit"
                                            data-id="{{ $item->id }}" data-toggle="modal"
                                            data-target="#editUser">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        </td>
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
    <!-- Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="model-main">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Building Edit Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal_body">

                </div>

            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
    <script>
        $('body').on('click', '.edit', function() {
            let building_id = $(this).data('id');
            $.get("/admin/building-manage/edit/" + building_id, function(data) {
                $('#modal_body').html(data);

            })
        })
    </script>
@endsection
