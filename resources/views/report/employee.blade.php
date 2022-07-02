@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Employee Report') }}</h5>
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
                        <h4 class="card-title float-left">{{ __('Employee View') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="employee_div" width="300" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        //Employee's Salaries
        var employeeDiv = document.getElementById("employee_div").getContext("2d");
        const employeeSalaries = @json($emplyee_data ?? '');
        var employeeData = {
            datasets: [{
                    label: ['Last Year'],
                    backgroundColor: "#6590aa",
                    skipNull: true,
                    maxBarThickness: 50,
                    barPercentage: 0.9,
                    categoryPercentage: 0.3,
                    // barPercentage: 0.9,
                    data: employeeSalaries,
                    parsing: {
                        yAxisKey: 'last_year'
                    },
                },
                {
                    label: ['Current Year'],
                    backgroundColor: "#1b435f",
                    skipNull: true,
                    maxBarThickness: 50,
                    barPercentage: 0.9,
                    categoryPercentage: 0.3,
                    // barThickness: 6,
                    data: employeeSalaries,
                    parsing: {
                        yAxisKey: 'current_year'
                    },
                }
            ]
        };

        new Chart(employeeDiv, {
            type: 'bar',
            data: employeeData,
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
