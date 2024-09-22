@extends('layouts.admin')

@section('admin_content')
    <style>
        input:focus {
            outline: none;
        }

        @media screen and (max-width: 767px) {
            .card-title a {
                font-size: 15px;
            }

            table,
            thead,
            tbody,
            tr,
            td,
            th {
                font-size: 13px !important;
                padding: 5px !important;
            }

            .card-header {
                padding: .25rem 1.25rem;
            }

            .text {
                font-size: 14px !important;
            }

            .form {
                margin-bottom: 9px !important;
                width: 250px;
                float: left;
            }

            .form2 {
                float: right;
                width: 100px;
            }
        }

        .table td,
        .table th {
            padding: .30rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
        }

        .text {
            font-size: 15px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css" />
    <div class="content-wrapper">
        <section class="content mt-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-primary text-center text">
                                <h3 class="card-title text" style="width:100%; text-align:center">Expenses Report </h3>
                            </div>
                            <div class="content-header" style="margin: -10px 5px !important">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-5 formlabel">
                                            <label for="">Category</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="0" selected>All Category</option>
                                                @foreach ($data['cats'] as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-5 formlabel">
                                            <label for="">Date</label>
                                            <input type="month" class="form-control text" name="date" id="date"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="dataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr style="border-top: 1px solid #ddd">
                                            <th width="10%">SL</th>
                                            <th width="15%">Date</th>
                                            <th width="20%">Expense Name</th>
                                            <th width="20%">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item-table">
                                    </tbody>

                                    <tfoot class="today_footer">
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total =</strong></td>
                                            <td id="amount" style="text-align: right"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>

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
        function reports() {
            $.ajax({
                type: "POST",
                url: "{{ route('expenses.report.show') }}",
                data: {
                    category_id: $('#category_id').val() || 0, // Default to 0 for all customers
                    date: $('#date').val() || null, // Null if not selected
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'JSON',
                success: function(res) {
                    var tbody = '';
                    if (res && res.ledger.length > 0) {
                        res.ledger.forEach((element, index) => {
                            var date = new Date(element.date);
                            var month = date.toLocaleString('default', {month: 'long' });

                            tbody += '<tr>'
                            tbody += '<td>' + (index + 1) + '</td>'
                            tbody += '<td>' + month + '</td>'
                            tbody += '<td>' + element.name + '</td>'
                            tbody += '<td style="text-align: right;">' + parseFloat(element.amount)
                                .toFixed(2) + '</td>'
                            tbody += '</tr>'
                        });
                        $('#item-table').html(tbody);
                        $('#amount').text(parseFloat(res.total_amount).toFixed(2));
                    } else {
                        tbody += '<tr><td colspan="4" class="text-center">No expense available for this month. </td></tr>';
                        $('#item-table').html(tbody);
                        $('.today_footer').hide();
                    }
                }
            });
        }

        $(document).ready(function() {
            reports(); // Load all data by default
            $('#date').on('change', function() {
                reports(); // Reload on date change
            });
            $('#category_id').on('change', function() {
                reports(); // Reload on user selection
            });
        });
    </script>
@endsection
