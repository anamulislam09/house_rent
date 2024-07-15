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

            .text {
                font-size: 10px !important;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 13px !important;
                padding: 10px !important;
            }
        }

        a.disabled {
            pointer-events: none;
            cursor: default;
        }

        .modal-dialog {
            max-width: 650px;
        }

        .table td,
        .table th {
            padding: .20rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }

        .text {
            font-size: 14px
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text">
                                <h3 class="card-title">
                                    <a href="{{ route('tenant-document.create') }}" class="btn btn-light shadow rounded">
                                        <i class="fas fa-plus"></i> <span>Add New</span>
                                    </a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Tenant Name</th>
                                            <th>Nid</th>
                                            <th>TIN</th>
                                            <th>Photo</th>
                                            <th>Deed</th>
                                            <th>Police Form</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $item)
                                            @php
                                                $created_by = App\Models\Client::where('id', $item->auth_id)->value('name');
                                                $tenant = App\Models\Tenant::where('id', $item->tenant_id)->value('name');
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $tenant }}</td>
                                                <td>
                                                    @if ($item->nid)
                                                        <img src="{{ asset($item->nid) }}" style="width: 50px" alt="NID Image">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->tin)
                                                        <img src="{{ asset($item->tin) }}" style="width: 50px" alt="TIN Image">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->photo)
                                                        <img src="{{ asset($item->photo) }}" style="width: 50px" alt="Photo Image">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->deed)
                                                        <img src="{{ asset($item->deed) }}" style="width: 50px" alt="Deed Image">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->police_form)
                                                        <img src="{{ asset($item->police_form) }}" style="width: 50px" alt="Police Form Image">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-info edit" data-id="{{ $item->id }}" data-toggle="modal" data-target="#editUser">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('tenant-document.show', $item->id) }}" class="btn btn-sm btn-success">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
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

    {{-- Edit Modal --}}
    <div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="model-main">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tenant Document Edit Form</h5>
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
            let id = $(this).data('id');
            $.get("/admin/tenant-document/edit/" + id, function(data) {
                $('#modal_body').html(data);
            })
        })
    </script>
@endsection
