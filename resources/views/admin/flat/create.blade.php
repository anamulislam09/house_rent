@extends('layouts.admin')

@section('admin_content')
    <style>
        ul li {
            list-style: none;
            font-size: 14px;
        }

        @media screen and (max-width: 767px) {
            .label {
                font-size: 14px;
            }

            .text {
                font-size: 14px !important;
            }
        }

        .text {
            font-size: 14px;
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

                            <div class="card-header bg-primary text-center text">
                                <h3 class="card-title" style="width:100%; text-align:center; font-size:14px ">Flat Manage
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row ">
                                    <div class="col-lg-10 col-md-10 col-sm-12 m-auto border p-4"
                                        style="background: #f3f2f2">
                                        <form action="{{ route('flat.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class=" form-group">
                                                        <label for="floor" class="label text">Choose Building </label>
                                                        <select name="building_id" id="" class="form-control">
                                                            <option value="" selected disabled>Select Building
                                                            </option>
                                                            @foreach ($building as $data)
                                                              <option value="{{$data->id}}">{{$data->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="label text">Flat Name </label>
                                                        <input type="text" class="form-control text" value=""
                                                            name="flat_name" id="flat_name" placeholder="Enter flat Name"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="label text">Flat Location </label>
                                                        <input type="text" class="form-control text" value=""
                                                            name="flat_location" id="flat_location"
                                                            placeholder="Enter flat Location">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="label text">Amount of Flat Rent
                                                        </label>
                                                        <input type="text" class="form-control text" value=""
                                                            name="flat_rent" placeholder="Enter Flat Rent" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="label text">Amount of Service Charge
                                                        </label>
                                                        <input type="text" class="form-control text" value=""
                                                            name="service_charge" placeholder="Enter Service Charge"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="unit" class="label text">Amount of Utility Bill
                                                        </label>
                                                        <input type="text" class="form-control text" value=""
                                                            name="utility_bill" placeholder="Enter Utility Bill" required>
                                                    </div>
                                                </div>
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
            </div>
        </section>
    </div>
@endsection
