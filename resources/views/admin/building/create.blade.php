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
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header bg-primary text-center text">
                                <h3 class="card-title" style="width:100%; text-align:center; font-size:14px ">Building Manage
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- /.card-header -->
                                <div class="row py-4">
                                    <div class="col-lg-10 col-md-10 col-sm-12 m-auto border p-3"
                                        style="background: #f6f5f5">
                                        <form action="{{ route('building.store') }}" method="POST">
                                            @csrf
                                            <div class=" form-group">
                                                <label for="floor" class="label text">Building Name :</label>
                                                <input type="text" class="form-control text" value=""
                                                    name="name" id="name" placeholder="Enter Building Name"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="Building" class="label text">Amount of Building Rent
                                                </label>
                                                <input type="text" class="form-control text" value=""
                                                    name="building_rent" placeholder="Enter Building Rent" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="unit" class="label text">Amount of Service Charge
                                                </label>
                                                <input type="text" class="form-control text" value=""
                                                    name="service_charge" placeholder="Enter Service Charge" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="unit" class="label text">Amount of Utility Bill
                                                </label>
                                                <input type="text" class="form-control text" value=""
                                                    name="utility_bill" placeholder="Enter Utility Bill" required>
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
