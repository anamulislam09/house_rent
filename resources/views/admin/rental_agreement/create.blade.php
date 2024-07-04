@extends('layouts.admin')

@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <style>
        .table td,
        .table th {
            padding: 0.6rem;
            font-size: 14PX
        }

        /*======================    404 page    =======================*/
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
    </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center">
                                <h3 class="card-title text" style="width:100%; text-align:center">Rental Agreement</h3>
                            </div> <!-- /.card-header -->
                            <form action="{{ route('rental-agreement.store') }}" method="POST">
                                @csrf
                                <div class="card mt-3">
                                    <div class="card-header row">
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <label for="" class="text">Choose Tenant</label>
                                            <select name="tenant_id" id="" class="form-control text" required>
                                                <option value="" selected disabled>Select Tenant</option>
                                                @foreach ($tenants as $tenant)
                                                    <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <label for="" class="text">Choose Building</label>
                                            <select name="building_id" id="building_id" class="form-control text" required>
                                                <option value="" selected disabled>Select Building</option>
                                                @foreach ($buildings as $building)
                                                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Building</th>
                                                <th>Flat</th>
                                                <th>Rent</th>
                                                <th>Service Charge</th>
                                                <th>Utility Bill</th>
                                                <th>Add</th>
                                            </tr>
                                        </thead>
                                        <tbody id="rent-table-body">
                                            <tr class="rent-row">
                                                <td class="building"></td>
                                                <td id="flat">
                                                    <select name="flat_id[]" class="flat form-control text" required>
                                                        <option value="" selected disabled>Select Flat</option>
                                                    </select>
                                                </td>
                                                <td class="rent"></td>
                                                <td class="service_charge"></td>
                                                <td class="utility_bill"></td>
                                                <td id="Addbtn">
                                                    <button type="button" class="btn btn-success btn-add text">Add</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                            <label class="text">From Date</label>
                                            <input type="month" class="form-control text" name="from_date" id="from_date" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                            <label class="text">To Date</label>
                                            <input type="month" class="form-control text" name="to_date" id="to_date" required>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                                            <label class="text">Duration <span class="text-warning text" style="font-size: 12px">(month)</span></label>
                                            <input type="text" class="form-control text" name="duration" id="" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <label class="text">Advanced Deposit</label>
                                            <input type="text" class="form-control text" name="advanced" required>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12 form-check" style="margin-top: 35px">
                                            <input type="checkbox" class="form-check-input text" id="deduct" name="deduct" value="something">
                                            <label class="text">Deducted by month?</label>
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12" id="deduct_amount" style="display:none;">
                                            <label class="text">Deducted Amount</label>
                                            <input type="text" class="form-control text" name="deduct_amount">
                                        </div>
                                        <div class="form-group col-lg-3 col-md-3 col-sm-12">
                                            <label class="text">Notice Period <span class="text-warning text" style="font-size: 12px">(month)</span></label>
                                            <input type="text" class="form-control" name="notice_period" id="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#deduct").click(function() {
                $("#deduct_amount").toggle();
            });
        });
    </script>
    {{-- show current month and date --}}
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#flat').hide();
            $('#Addbtn').hide();

            // When building selection changes
            $("#building_id").change(function() {
                let building_id = $(this).val();
                $('#flat').show();
                $('#Addbtn').show();

                $.ajax({
                    url: '/admin/get-flat',
                    type: 'post',
                    data: 'building_id=' + building_id + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        $('.building').text(result.building.name);
                        // Append the default option
                        $('.flat').empty();
                        $('.flat').append('<option value="" selected disable>Select Flat</option>');
                        // Iterate over the flats and append options to the select
                        $.each(result.flat, function(index, flat) {
                            $('.flat').append('<option value="' + flat.id + '">' + flat.flat_name + '</option>');
                        });
                    }
                });
            });

            // When a flat selection changes
            $(document).on('change', '.flat', function() {
                let flat_id = $(this).val();
                let row = $(this).closest('.rent-row');

                $.ajax({
                    url: '/admin/get-flat-info',
                    type: 'post',
                    data: 'flat_id=' + flat_id + '&_token={{ csrf_token() }}',
                    success: function(result) {
                        row.find('.rent').text(result.flat_info.flat_rent);
                        row.find('.service_charge').text(result.flat_info.service_charge);
                        row.find('.utility_bill').text(result.flat_info.utility_bill);
                    }
                });
            });

            // When adding a new row
            $(document).on('click', '.btn-add', function() {
                let newRow = $('.rent-row').first().clone();
                newRow.find('select').val('');
                newRow.find('.rent, .service_charge, .utility_bill').text(''); // Clear text values
                newRow.find('td:last').html('<button type="button" class="btn btn-danger btn-remove text">Remove</button>');
                $('#rent-table-body').append(newRow);
            });

            // When removing a row
            $(document).on('click', '.btn-remove', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
