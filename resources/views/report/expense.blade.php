@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Expense Report') }}</h5>
                        {{-- <ul class="breadcrumb ml-2"> --}}
                        {{-- <li class="breadcrumb-item active">{{__('Farms')}}</li> --}}
                        {{-- </ul> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form class="form-inline" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="inputPassword6">From</label>
                            <input type="date" name="from" class="form-control mx-sm-3">
                            <div class="form-group">
                                <label for="inputPassword6">To</label>
                                <input type="date" name="to" class="form-control mx-sm-3">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                            </div>
                    </form>
                </div>
                @if ($mode ?? '' == 'search')
                    <h4 class="mt-3">Search Result From: {{ date('D, M j, Y', strtotime($from)) ?? '' }} To:
                        {{ date('D, M j, Y', strtotime($to)) ?? '' }}
                    </h4>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Fixed Expenses') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="expenses_div" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var expensesDiv = document.getElementById("expenses_div").getContext("2d");
        const expenses = @json($expenses_data ?? '');
        console.log(expenses)
        const expensesData = {
            labels: expenses.farms,
            datasets: [{
                    label: ['Last Year'],
                    backgroundColor: "#6590aa",
                    data: expenses.last_year_expense
                },
                {
                    label: ['Current Year'],
                    backgroundColor: "#1b435f",
                    data: expenses.current_year_expense
                }
            ]
        };

        new Chart(expensesDiv, {
            type: 'bar',
            data: expensesData,
            options: {}
        });
    </script>
@endsection
