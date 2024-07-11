@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <style>
        .table td,
        .table th {
            padding: 0.6rem;
        }

        .page_404 {
            padding: 40px 0;
            background: #fff;
            font-family: 'Arvo', serif;
        }

        .page_404 img {
            width: 100%;
        }

        .four_zero_four_bg {
            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 400px;
            background-position: center;
        }

        .four_zero_four_bg h1 {
            font-size: 80px;
        }

        .four_zero_four_bg h3 {
            font-size: 80px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
        }

        .contant_box_404 {
            margin-top: -50px;
        }

        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 15px;
            }

            .card-header {
                padding: .25rem 1.25rem;
            }

            .text {
                font-size: 14px !important;
            }

            .form {
                margin-bottom: 7px !important;
                width: 250px;
                float: left;
            }

            .form2 {
                float: right;
                width: 100px;
            }
        }

        .text {
            font-size: 14px !important;
        }

        .dropify-wrapper .dropify-message p {
            font-size: 14px;
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
                                <h3 class="card-title">
                                    <a href="{{ route('tenant-document.index') }}"class="btn btn-light shadow rounded">
                                    <span>See All Document</span></a>
                                </h3>
                            </div> <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 p-5 m-auto" style="border: 1px solid #ddd; background: #eeecec">
                                        <form action="{{ route('tenant-document.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group text">
                                                <label for="tenant_id" class="text">Select Tenant</label>
                                                <select name="tenant_id" class="form-control" id="tenant_id">
                                                    <option value="" selected disabled>Select Once</option>
                                                    @foreach ($tenants as $tenant)
                                                        <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('tenant_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="form-group text">
                                                <label for="nid" class="text">NID/NRC</label>
                                                <input type="file" name="nid" class="form-control dropify"
                                                    data-height="100">
                                                @error('nid')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text">
                                                <label for="tin" class="text">TIN</label>
                                                <input type="file" name="tin" class="form-control dropify"
                                                    data-height="100">
                                                @error('tin')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text">
                                                <label for="photo" class="text">Tenant Photo</label>
                                                <input type="file" name="photo" class="form-control dropify"
                                                    data-height="100">
                                                @error('photo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text">
                                                <label for="deed" class="text">Deed</label>
                                                <input type="file" name="deed" class="form-control dropify"
                                                    data-height="100">
                                                @error('deed')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text">
                                                <label for="police_form" class="text">Police Form</label>
                                                <input type="file" name="police_form" class="form-control dropify"
                                                    data-height="100">
                                                @error('police_form')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.dropify').dropify();
        });
    </script>
@endsection
