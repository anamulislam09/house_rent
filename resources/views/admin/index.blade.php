@extends('layouts.admin')
@section('admin_content')

    <style>
        h3 {
            font-size: 22px !important;
        }

        p {
            font-size: 16px !important
        }

        .text {
            font-size: 16px !important
        }

        .link {
            font-size: 14px !important;
        }

        .ul-scrollable {
            width: 100%;
            overflow: hidden;
            overflow-y: scroll;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h2 class="m-0 " style="font-size: 28px">Dashboard</h2>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item" style="font-size: 14px"><a
                                    href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" style="font-size: 14px">Dashboard </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        @php
            $currentDate = Carbon\Carbon::now()->format('Y-m');
            $user = App\Models\User::where('client_id', Auth::guard('admin')->user()->id)->count();

            // <----------------------building wise flat start here---------------------->
            $flat = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
            $flat_booked = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)
                ->where('booking_status', 1)
                ->count();
            $available_flat = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)
                ->where('booking_status', 0)
                ->count();
            // <----------------------building wise flat ends here---------------------->

            // <----------------------total transaction start here---------------------->
            $buildings = App\Models\Building::where('client_id', Auth::guard('admin')->user()->id)->get();
            $total_building = App\Models\Building::where('client_id', Auth::guard('admin')->user()->id)->count();
            $total_exp = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)->sum('amount');
            $total_collection_amount = App\Models\BillSetup::where('client_id', Auth::guard('admin')->user()->id)->sum(
                'total_collection_amount',
            );

            $total_collection = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)->sum(
                'total_collection',
            );

            $total_balance = $total_collection_amount - $total_exp;
            $total_due = $total_collection_amount - $total_collection;

            $current_due = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)->sum(
                'current_due',
            );

            // $total_income = App\Models\Income::where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
            // $manualOpeningBlance = DB::table('opening_balances')
            //     ->where('client_id', Auth::guard('admin')->user()->id)
            //     ->first();
            // $others_income = DB::table('others_incomes')
            //     ->where('client_id', Auth::guard('admin')->user()->id)
            //     ->sum('amount');

            $total_advanced_amount = App\Models\Tenant::where('client_id', Auth::guard('admin')->user()->id)->sum('balance');

            // <----------------------total transaction ends here---------------------->

            // <----------------------this month transactions start here---------------------->
            $monthly_collection_amount = App\Models\BillSetup::where('client_id', Auth::guard('admin')->user()->id)
                ->where('bill_setup_date', $currentDate)
                ->sum('total_collection_amount');

            $monthly_collection = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)
                ->where('bill_setup_date', $currentDate)
                ->sum('total_collection');

            $monthly_due = $monthly_collection_amount - $monthly_collection; // monthly transaction

            $monthly_current_due = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)
                ->where('bill_setup_date', $currentDate)
                ->sum('current_due');
            $monthly_current_expense = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', $currentDate)
                ->sum('amount');

            $current_month_balance = $monthly_collection_amount - $monthly_current_expense;

            // <----------------------this month transactions ends here---------------------->

            //  <----------------------Month wise transactions start here---------------------->
            $flats = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
            $tenant = App\Models\Tenant::where('client_id', Auth::guard('admin')->user()->id)->count();
            $expense = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            // $income = App\Models\Income::where('client_id', Auth::guard('admin')->user()->id)
            //     ->where('date', date('Y-m'))
            //     ->sum('paid');
            $others_income = DB::table('others_incomes')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            $balance = App\Models\Balance::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            $monthly_balance =
                // <----------------------Month wise transactions ends here---------------------->

                // <---------------------- SuperAdmin data stare here here ---------------------->
                $clients = App\Models\Client::where('role', 1)->count();
            $category = App\Models\Category::count();
            $packages = App\Models\Package::count();
            $superAdmin = Auth::guard('admin')->user()->id;
            $total_superAdmin_collection = App\Models\Payment::sum('paid');
            // <----------------------SuperAdmin data stare here here---------------------->
        @endphp
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                @if ($superAdmin == 1001)
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total Clients</p>
                                    <h3>{{ $clients }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('client.all') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Total Packages</p>
                                    <h3>{{ $packages }}</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('package.all') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3>{{ number_format($total_superAdmin_collection, 2) }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('collections.all') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Total Due</p>
                                    <h3>{{ $total_due }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('category.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> --}}
                        <!-- /.col -->
                    </div>
                @else
                    <div class="card " style="margin-top: -20px !important">
                        <div class="card-header row ">
                            <h4><input value="{{ date('Y-m') }}" type="month" name="date" class="form-control text"
                                    id="date"></h4>
                        </div>
                    </div>
                    {{-- filter month data start here --}}
                    <div class="row" id="datewiseData">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3 id="flats">{{ $flat }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background: #8805b0">
                                <div class="inner text-white">
                                    <p>Total tenant</p>
                                    <h3 id="tenant"><sup style="font-size: 14px"></sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('tenant.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Total Bill Amount</p>
                                    <h3 id="total_collection_amount"> TK</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('income.statement') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3 id="total_collection"> TK</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Due</p>
                                    <h3 id="current_due"> TK</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box" style="background: #aadb09; color:white">
                                <div class="inner">
                                    <p>Expense</p>
                                    <h3 id="monthly_expense">TK</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box" style="background: #064713; color:white">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3 id="monthly_balance">TK</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    {{-- filter month data ends here --}}

                    {{-- current month data start here --}}
                    <div class="row" id="todaydata">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- /.col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background: #8805b0">
                                <div class="inner text-white">
                                    <p>Total tenant</p>
                                    <h3>{{ $tenant }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('tenant.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Total Bill Amount</p>
                                    <h3>{{ number_format($monthly_collection_amount, 2) }} TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3>{{ number_format($monthly_collection, 2) }} TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Due</p>
                                    <h3>{{ number_format($monthly_due, 2) }}
                                        TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <div class="small-box" style="background: #aadb09; color:white">
                                <div class="inner">
                                    <p>Expense</p>
                                    <h3 id="">{{ number_format($monthly_current_expense, 2) }}TK</h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background: #064713; color:white">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ $current_month_balance < 0 ? '(' . number_format(abs($current_month_balance), 2) . ')' : number_format($current_month_balance, 2) }}
                                        TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                    {{-- current month data ends here --}}

                    {{-- building wise flat start here  --}}
                    <div class="card" style="margin-top: 0px !important;">
                        <div class="card-header row">
                            @if (isset($buildings) && $buildings->count() > 0)
                                <h4>Total Flats</h4>
                            @else
                                <h4>No Flat Available</h4>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        @foreach ($buildings as $building)
                            @php
                                $flats = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)
                                    ->where('building_id', $building->id)
                                    ->get();
                            @endphp
                            <!-- fix for small devices only -->
                            <div class="clearfix hidden-md-up"></div>
                            <div class="col-lg-4 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner" style="padding: 0px !important;">
                                        <p class="text-center" style="font-size: 20px; margin-bottom:0px">
                                            {{ $building->name }}</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-10">
                                            <div class="icon" style="background: #e1dede">
                                                <ul class="mt-1 @if (count($flats) > 3) ul-scrollable @endif"
                                                    style="list-style-type: none; height: 95px;font-size: 14px;">
                                                    @foreach ($flats as $key => $item)
                                                        <li class="mt-1 pb-1"
                                                            style="color: #222; border-bottom:1px solid #c5c3c3 !important">
                                                            {{ $item->flat_name }}
                                                            @if ($item->booking_status == 0)
                                                                <span class="badge badge-success ml-5">Available</span>
                                                            @else
                                                                <span class="badge badge-danger ml-5">Booked</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- building wise flat ends here  --}}

                    {{-- total transaction start here  --}}
                    {{-- total transaction start here  --}}

                    <div class="card">
                        <div class="card-header">
                            <h4 class="title " style="font-size: 20px">Total Transactions</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #d31bdd">
                                <div class="inner">
                                    <p class="text-white">Total Building</p>
                                    <h3 class="text-white">{{ $total_building }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('building.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <p>Total Tenant</p>
                                    <h3>{{ $tenant }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('tenant.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>No of Flat</p>
                                    <h3>{{ $flat }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background: #73d8f1">
                                <div class="inner text-white">
                                    <p>Available Flat</p>
                                    <h3>{{ $available_flat }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-dark">
                                <div class="inner text-white">
                                    <p>Flat Booked</p>
                                    <h3>{{ $flat_booked }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background:#04986e;">
                                <div class="inner">
                                    <p>Advance Amount</p>
                                    <h3>{{ number_format($total_advanced_amount, 2) }} TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Total Bill Amount</p>
                                    <h3>{{ number_format($total_collection_amount, 2) }} TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3>{{ number_format($total_collection, 2) }} TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Due</p>
                                    <h3>{{ number_format($total_due, 2) }}
                                        TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <!-- /.col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background: #aadb09;">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ number_format($total_exp, 2) }} TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('expense-summary.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box" style="background: #064713; color:white">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ $total_balance < 0 ? '(' . number_format(abs($total_balance), 2) . ')' : number_format($total_balance, 2) }}
                                        TK</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                @endif
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var searchRequest = null;

        $(document).ready(function() {
            $("#datewiseData").hide();
            $("#date").on('change', function() {
                $("#datewiseData").show();
                $("#todaydata").hide();
                var date = $(this).val();
                // alert(date);
                $.ajax({
                    type: "GET",
                    url: "{{ url('admin/get-transaction') }}/" + date,
                    dataType: "json",
                    success: function(res) {
                        let monthly_balance = (res.total_collection_amount - res.expense)
                        console.log(res);
                        $('#flats').text(res.flats);
                        $('#tenant').text(res.tenant);
                        $('#total_collection_amount').text(parseFloat(res
                            .total_collection_amount).toFixed(2));
                        $('#total_collection').text(parseFloat(res.total_collection).toFixed(
                            2));
                        $('#current_due').text(parseFloat(res.current_due).toFixed(2));
                        $('#monthly_expense').text(parseFloat(res.expense).toFixed(2));
                        $('#monthly_balance').text(monthly_balance < 0 ? '(' + parseFloat(Math
                            .abs(monthly_balance)).toFixed(2) + ')' : parseFloat(
                            monthly_balance).toFixed(2));

                    }
                });
            });
        });
    </script>

@endsection
