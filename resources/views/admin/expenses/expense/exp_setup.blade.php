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
                font-size: 15px;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 13px !important;
                padding: 5px !important;
            }

            .card-header {
                padding: .25rem 1.25rem;
            }

            .text {
                font-size: 14px !important;
            }

            .button {
                margin-top: -0px !important;
            }
        }

        .table td,
        .table th {
            padding: .30rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }

        .text {
            font-size: 14px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">Expense Setup</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row py-4">
                                    <div class="col-lg-10 col-md-10 col-sm-12 m-auto border p-3"
                                        style="background: #f6f5f5">
                                        <form action="{{ route('exp_setup.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-0">
                                                <label for="unit" class="text">Expense Category </label>
                                                <select name="cat_id" class="form-control text" id="" required>
                                                    <option value="" selected disabled>Select Once</option>
                                                    @foreach ($exp_cat as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="unit" class="text">Expense Name</label>
                                                <input type="text" name="exp_name" class="form-control text "
                                                    placeholder="Enter Expense Name" required>
                                            </div>
                                            <div class="">
                                                <button type="submit" class="btn btn-sm btn-primary text">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @if (count($expenses) < 1)
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th class="text-center">Expense Name</th>
                                            <th class="text-center">Category</th>
                                            <th width="20%" class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $key => $item)
                                            @php
                                                $data = DB::table('categories')
                                                    ->where('id', $item->cat_id)
                                                    ->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->exp_name }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td class="text-center">
                                                    <a href="#" class=" text-success edit"
                                                        data-id="{{ $item->id }}" data-toggle="modal"
                                                        data-target="#editexp"><i class="fas fa-edit"></i></a>
                                                    {{-- <a href="{{ route('expense.delate', $item->id) }}"
                                                        class="text-danger"><i class="fas fa-trash"></i></a> --}}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
    </div>
    </section>
    </div>

    {{-- category edit model --}}
    <!-- Modal -->
    <div class="modal fade" id="editexp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Expense Setup </h5>
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
    <script>
        $('body').on('click', '.edit', function() {
            let exp_id = $(this).data('id');
            $.get("/admin/expense-setup/edit/" + exp_id, function(data) {
                $('#modal_body').html(data);
                // console.log(data);
            })
        })
    </script>

@endsection
