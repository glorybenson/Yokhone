@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Income Report') }}</h5>
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
                        <h4 class="card-title float-left">{{ __('Farm Income') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="income_div" width="300" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var incomesDiv = document.getElementById("income_div").getContext("2d");
            const incomes = @json($incomes_data ?? '');
            console.log(incomes.farms)
            const incomesData = {
                labels: incomes.farms,
                datasets: [{
                    label: 'Farm Income',
                    backgroundColor: "#6590aa",
                    maxBarThickness: 60,
                    data: incomes.all_incomes_data,
                }]
            };

            new Chart(incomesDiv, {
                type: 'bar',
                data: incomesData,
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                boxWidth: 10
                            }
                        }
                    }
                }
            });
        </script>
    @endsection
