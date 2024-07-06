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
                                        <h3 class="card-title text" style="width:100%; text-align:center">All Bill</h3>
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
                                                    <option value="" selected disabled>Select Tenant</option>
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
                            <div class="card-body" id="table">
                                <form action="{{ route('collection.store') }}" method="post">
                                    @csrf
                                <div class="table-responsive">
                                    <table id="billsTable" class="table table-bordered table-striped mt-3">
                                        <thead>
                                            <tr>
                                                <th> SL</th>
                                                <th>Tenant Name</th>
                                                <th>Flat Name</th>
                                                <th>Building Name</th>
                                                <th>Month</th>
                                                <th class="text-right">Total Rent</th>
                                                <th class="text-center">Collection</th>
                                            </tr>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6"></td>
                                                <td class="text-right">
                                                    <input type="submit" value="Submit" class="btn btn-primary">
                                                </td>
                                            </tr>
                                        </tfoot>
                                        
                                    </table>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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

            $('#table').hide(); //hide table
            $('#filterButton').on('click', function() {
                const tenantId = $('#tenant').val();
                const date = $('#date').val();
                $('#table').show(); //show table

                $.ajax({
                    url: `/admin/collection/filter/${tenantId}/${date}`,
                    method: 'GET',
                    success: function(response) {
                        let tbody = '';
                        $('tbody').empty();
                        // Populate table with new data
                        response.forEach((bill, index) => {
                            const billDate = new Date(bill.bill_setup_date);
                            const options = {
                                month: 'long'
                            };
                            const formattedDate = billDate.toLocaleDateString('en-US',
                                options);
                            $('tbody').append(`
                            <tr>
                                <input type="hidden" name="bill_id[]" value="${bill.id}">
                                <input type="hidden" name="agreement_id[]" value="${bill.agreement_id}">
                                <input type="hidden" name="tenant_id[]" value="${bill.tenant_id}">
                                <input type="hidden" name="flat_id[]" value="${bill.flat_id}">
                                <input type="hidden" name="flat_rent[]" value="${bill.flat_rent}">
                                <input type="hidden" name="service_charge[]" value="${bill.service_charge}">
                                <input type="hidden" name="utility_bill[]" value="${bill.utility_bill}">
                                <input type="hidden" name="total_rent[]" value="${bill.total_rent}">
                                <input type="hidden" name="bill_setup_date[]" value="${bill.bill_setup_date}">
                            <td class="text-center">${index + 1}</td>
                            <td>${bill.tenant_name}</td>
                            <td>${bill.flat_name}</td>
                            <td>${bill.building_name}</td>
                            <td>${formattedDate}</td>
                            <td class="text-right">${bill.total_rent}</td>
                            <td class="text-right"></thead> <input type="text" class="form-control" name="total_collection[]" required></td>
                        </tr>
                    `);
                        });
                    }
                });
            });
        });
    </script>
@endsection