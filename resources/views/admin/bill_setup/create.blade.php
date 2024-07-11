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
        .text{
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
                            <div class="card-header bg-primary">
                                <div class="row ">
                                    <div class="col-lg-10 col-sm-12">
                                        <h3 class="card-title text" style="width:100%; text-align:center">Bill Generate</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-12" style="border: 1px solid #ddd">
                                        <form action="{{ route('bill-setup.store') }}" method="post" id="generate">
                                            @csrf
                                            <div class="row my-4">
                                                <div class="form-group col-lg-3 col-md-4 col-sm-6 date">
                                                    <label for="">Tenant</label>
                                                    <select name="tenant_id" class="form-control text" id=""
                                                        required>
                                                        <option value="" selected disabled>Select Tenant</option>
                                                        @foreach ($tenants as $tenant)
                                                            <option value="{{ $tenant->id }}">{{ $tenant->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-3 col-md-4 col-sm-6 date">
                                                    <label class="text">Month</label>
                                                    <input type="month" class="form-control text" name="date"
                                                        id="date" required>
                                                </div>

                                                @if (Route::current()->getName() == 'bill-setup.create')
                                                    <div class="form-group col-lg-2 mt-2">
                                                        <label for="" class="col-form-label"></label>
                                                        <input type="submit"
                                                            class="btn btn-sm btn-primary text form-control"
                                                            value="Generate Bill">
                                                    </div>
                                                @else
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @php
                                $bills = Session::get('bills');
                            @endphp
                            <!-- /.card-header -->
                            @if (isset($bills) && !empty($bills))
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 text">
                                                    Bill Setup for the Month of <strong>
                                                        @php
                                                            $currentMonth = date('F');
                                                            echo "$currentMonth";
                                                        @endphp
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="table-responsive">
                                                <table id="" class="table table-bordered table-striped mt-3">
                                                    <thead>
                                                        <tr>
                                                            <th> SL</th>
                                                            <th>Month</th>
                                                            <th>Flat Name</th>
                                                            <th>Tenant Name</th>
                                                            <th class="text-right">Total Current Month Rent</th>
                                                            <th class="text-right">Previous Due</th>
                                                            <th class="text-right">Bill Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($bills as $key => $item)
                                                            @php
                                                                $flat_name = App\Models\Flat::where(
                                                                    'client_id', Auth::guard('admin')->user()->id)->where('id',
                                                                    $item->flat_id,
                                                                )->value('flat_name');
                                                                $tenant_name = App\Models\Tenant::where(
                                                                    'client_id', Auth::guard('admin')->user()->id)->where('id',
                                                                    $item->tenant_id,
                                                                )->value('name');
                                                            @endphp
                                                            <tr>
                                                                <td class="text-center">{{ $key + 1 }}</td>
                                                                <td>{{ $currentMonth }}</td>
                                                                <td>{{ $flat_name }}</td>
                                                                <td>{{ $tenant_name }}</td>
                                                                <td class="text-right">{{ $item->total_current_month_rent }}</td>
                                                                <td class="text-right">{{ $item->previous_due }}</td>
                                                                <td class="text-right">{{ $item->total_collection_amount }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
        });
    </script>


@endsection
