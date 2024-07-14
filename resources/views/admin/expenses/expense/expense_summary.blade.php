@extends('layouts.admin')

@section('admin_content')
    <style>
        @media screen and (max-width: 767px) {

            table,
            thead,
            tbody,
            tr,
            td {
                font-size: 14px;
            }

            .text {
                font-size: 14px !important;
            }

            .button {
                font-size: 14px;
            }

            .voucher {
                margin-top: 7px;
                margin-bottom: 10px;
            }
        }

        .text {
            font-size: 14px !important;
        }

        table,
        thead,
        tbody,
        tr,
        td {
            font-size: 14px;
        }

        .col-lg-2.col-md-2.col-sm-4.voucher {
            margin-bottom: 10px;
        }
    </style>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title d-block text">Expense Summary </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                {{-- @if (count($expSummary) < 1)
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <section class="page_404">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12 col-md-12 col-sm-12">
                                                            <div class="col-sm-12 text-center">
                                                                <div class="contant_box_404 text">
                                                                    <h3 class="h2">
                                                                        Expense Not Found!
                                                                    </h3>
                                                                    <p>Pls! Expense Create First</p>
                                                                    <a href="{{ route('expense.create') }}"
                                                                        class="link_404 btn btn-primary">Create Expense
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div> --}}

                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-8">
                                        <h3 class="card-title d-block text">Expense Summary for the Month of <strong>
                                                @if ('1' == date('m'))
                                                    January
                                                @elseif ('2' == date('m'))
                                                    February
                                                @elseif ('3' == date('m'))
                                                    March
                                                @elseif ('4' == date('m'))
                                                    April
                                                @elseif ('5' == date('m'))
                                                    May
                                                @elseif ('6' == date('m'))
                                                    June
                                                @elseif ('7' == date('m'))
                                                    July
                                                @elseif ('8' == date('m'))
                                                    August
                                                @elseif ('9' == date('m'))
                                                    September
                                                @elseif ('10' == date('m'))
                                                    October
                                                @elseif ('11' == date('m'))
                                                    November
                                                @elseif ('12' == date('m'))
                                                    December
                                                @endif - {{ date('Y') }}</h3></strong>
                                    </div>

                                    @if (count($expSummary) < 1)
                                    @else
                                        <div class="col-lg-2 col-md-2 col-sm-4 voucher">
                                            <a href="{{ route('expense.voucher.generateall') }}" target="_blank"
                                                class="btn btn-sm btn-primary button">Voucher</a>
                                        </div>
                                    @endif

                                </div>

                                <div class="table-responsive">
                                    <table id="" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th class="text-center">Year</th>
                                                <th class="text-center">Month</th>
                                                <th class="text-center">Expense Name</th>
                                                <th class="text-center">Category</th>
                                                <th class="text-center">Amount</th>
                                        </thead>
                                        @if (count($expSummary) < 1)
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">Expense Not Found</td>
                                                </tr>
                                            </tbody>
                                        @else
                                            <tbody>
                                                @foreach ($expSummary as $key => $item)
                                                    @php
                                                        $amount = App\Models\Expense::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->where('exp_setup_id', $item->exp_setup_id)
                                                            ->sum('amount');
                                                        $total = App\Models\Expense::where(
                                                            'client_id',
                                                            Auth::guard('admin')->user()->id,
                                                        )
                                                            ->where('month', $item->month)
                                                            ->where('year', $item->year)
                                                            ->sum('amount');
                                                        $exp_setup = DB::table('exp_setups')
                                                            ->where('id', $item->exp_setup_id)
                                                            ->first();
                                                        $cat_name = DB::table('categories')
                                                            ->where('id', $exp_setup->cat_id)
                                                            ->value('name');
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td class="text-center">{{ $item->year }}</td>

                                                        <td class="text-center">
                                                            @if ($item->month == 1)
                                                                January
                                                            @elseif ($item->month == 2)
                                                                February
                                                            @elseif ($item->month == 3)
                                                                March
                                                            @elseif ($item->month == 4)
                                                                April
                                                            @elseif ($item->month == 5)
                                                                May
                                                            @elseif ($item->month == 6)
                                                                June
                                                            @elseif ($item->month == 7)
                                                                July
                                                            @elseif ($item->month == 8)
                                                                August
                                                            @elseif ($item->month == 9)
                                                                September
                                                            @elseif ($item->month == 10)
                                                                October
                                                            @elseif ($item->month == 11)
                                                                November
                                                            @elseif ($item->month == 12)
                                                                December
                                                            @endif
                                                        </td>
                                                        <td>{{ $cat_name }}</td>
                                                        <td>{{ $exp_setup->exp_name }}</td>
                                                        <td class="text-right">{{ $amount }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-right"> <strong>Total :</strong></td>
                                                    <td class="text-right"><strong>{{ $total }}</strong></td>
                                                </tr>
                                            </tfoot>

                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
