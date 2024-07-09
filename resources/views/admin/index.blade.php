@extends('layouts.admin')
@section('admin_content')

    <style>
        h3 {
            font-size: 20px !important;
        }

        p {
            font-size: 14px !important
        }

        .text {
            font-size: 14px !important
        }

        .link {
            font-size: 12px !important;
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
            $flat = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
            $flat_booked = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->where('booking_status', 0)->count();
            $available_flat = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->where('booking_status', 1)->count();

            $buildings = App\Models\Building::where('client_id', Auth::guard('admin')->user()->id)->get();
            $total_exp = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)->sum('amount');
            $total_collection_amount = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)->sum('total_collection_amount');

            $total_collection = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)->sum('total_collection');

            $current_due = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)->sum('current_due');

            $total_income = App\Models\Income::where('client_id', Auth::guard('admin')->user()->id)->sum('paid');
            $manualOpeningBlance = DB::table('opening_balances')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->first();
            $others_income = DB::table('others_incomes')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->sum('amount');

            $balance = App\Models\Balance::where('client_id', Auth::guard('admin')->user()->id)->sum('amount');
            $clients = App\Models\Client::where('role', 1)->count();
            $category = App\Models\Category::count();
            $packages = App\Models\Package::count();
            $superAdmin = Auth::guard('admin')->user()->id;

            // this month transactions
            $monthly_collection_amount = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)
                ->where('bill_setup_date', $currentDate)
                ->sum('total_collection_amount');

            $monthly_collection = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)
                ->where('bill_setup_date', $currentDate)
                ->sum('total_collection');

            $monthly_current_due = App\Models\Collection::where('client_id', Auth::guard('admin')->user()->id)
                ->where('bill_setup_date', $currentDate)
                ->sum('current_due');

            $flats = App\Models\Flat::where('client_id', Auth::guard('admin')->user()->id)->count();
            $tenant = App\Models\Tenant::where('client_id', Auth::guard('admin')->user()->id)->count();
            $expense = App\Models\Expense::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            $income = App\Models\Income::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('paid');
            $others_income = DB::table('others_incomes')
                ->where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            $balance = App\Models\Balance::where('client_id', Auth::guard('admin')->user()->id)
                ->where('date', date('Y-m'))
                ->sum('amount');
            $total_colloection = App\Models\Payment::sum('paid');
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
                        <!-- /.col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <p>Total Category</p>
                                    <h3>{{ $category }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('category.index') }}" class="small-box-footer link">More info <i
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
                                <a href="{{ route('category.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3>{{ $total_colloection }}</h3>

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
                        {{-- <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>Available Flat</p>
                                    <h3 id="flats">{{ $flat }}</h3>

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
                            <div class="small-box " style="background: #df8e15">
                                <div class="inner text-white">
                                    <p>Flat Booked</p>
                                    <h3 id="flats">{{ $flat }}</h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{ route('flat.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> --}}
                        <!-- /.col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
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
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Total Collection Amount</p>
                                    <h3 id="total_collection_amount"><sup style="font-size: 14px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{ route('income.statement') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- fix for small devices only -->
                        {{-- <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Others Income</p>
                                    <h3 id="others_income"><sup style="font-size: 14px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> --}}
                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3 id="total_collection"><sup style="font-size: 14px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- fix for small devices only -->
                        {{-- <div class="clearfix hidden-md-up"></div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <p>Others Income</p>
                                    <h3 id="others_income"><sup style="font-size: 14px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div> --}}
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <p>Due</p>
                                    <h3 id="current_due"><sup style="font-size: 14px">TK</sup></h3>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

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
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total tenant</p>
                                    <h3>{{ $tenant }}<sup style="font-size: 14px"></sup></h3>

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
                                    <p>Total Collection Amount</p>
                                    <h3>{{ $monthly_collection_amount }}<sup style="font-size: 14px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{route('rent-collection.index')}}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <p>Total Collection</p>
                                    <h3>{{ $monthly_collection }} <sup style="font-size: 14px">TK</sup></h3>

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
                                    <h3>{{ $monthly_current_due }} <sup style="font-size: 14px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('rent-collection.index') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="card " style="margin-top: 0px !important">
                        <div class="card-header row ">
                            <h4>Total Flats</h4>
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
                                        {{-- <h3>{{ $income }}<sup style="font-size: 14px">TK</sup></h3> --}}
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
                                                                <span class="badge badge-info ml-5">Available</span>
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
                                    {{-- <a href="{{ route('income.statement') }}" class="small-box-footer link">More info <i
                                            class="fas fa-arrow-circle-right"></i></a> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>

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
                                    <h3 class="text-white">{{ $tenant }}</h3>

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
                                    <h3>{{ $available_flat}}</h3>

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
                             <div class="small-box bg-secondary">
                                 <div class="inner">
                                     <p>Total Collection Amount</p>
                                     <h3>{{ $total_collection_amount }}<sup style="font-size: 14px">TK</sup></h3>
 
                                 </div>
                                 <div class="icon">
                                     <i class="ion ion-stats-bars"></i>
                                 </div>
                                 <a href="{{route('rent-collection.index')}}" class="small-box-footer link">More info <i
                                         class="fas fa-arrow-circle-right"></i></a>
                             </div>
                         </div>
                         <div class="col-lg-4 col-6">
                             <!-- small box -->
                             <div class="small-box bg-primary">
                                 <div class="inner">
                                     <p>Total Collection</p>
                                     <h3>{{ $total_collection }} <sup style="font-size: 14px">TK</sup></h3>
 
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
                                     <h3>{{ $current_due }} <sup style="font-size: 14px">TK</sup></h3>
 
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
                            <div class="small-box bg-warning">
                                <div class="inner text-white">
                                    <p>Total Expenses</p>
                                    <h3>{{ $total_exp }}<sup style="font-size: 14px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('expenses.year') }}" class="small-box-footer link">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>Balance</p>
                                    <h3>{{ $balance }} <sup style="font-size: 14px">TK</sup></h3>

                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{ route('blance.index') }}" class="small-box-footer link">More info <i
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
                        console.log(res);
                        $('#flats').text(res.flats);
                        $('#tenant').text(res.tenant);
                        $('#total_collection_amount').text(res.total_collection_amount);
                        $('#total_collection').text(res.total_collection);
                        $('#current_due').text(res.current_due);
                        // $('#manualOpeningBalance').text(res.manualOpeningBalance);
                        $('#others_income').text(res.others_income);
                        $('#balance').text(res.balance);
                    }
                });
            });
        });
    </script>

@endsection
