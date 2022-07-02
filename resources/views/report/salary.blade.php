@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Salary Report') }}</h5>
                        {{-- <ul class="breadcrumb ml-2"> --}}
                        {{-- <li class="breadcrumb-item active">{{__('Farms')}}</li> --}}
                        {{-- </ul> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Salaries') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salary_div" width="300" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var salaryDiv = document.getElementById("salary_div").getContext("2d");
        const salary = @json($salary ?? '');
        const salaryData = {
            labels: ["Salary"],
            datasets: [{
                    label: ['Last Year'],
                    backgroundColor: "#6590aa",
                    data: [salary.last_year],
                    categoryPercentage: 0.2,
                    barThickness: 'flex'
                },
                {
                    label: ['Current Year'],
                    backgroundColor: "#1b435f",
                    data: [salary.current_year],
                    categoryPercentage: 0.2,
                    barThickness: 'flex'
                }
            ]
        };

        new Chart(salaryDiv, {
            type: 'bar',
            data: salaryData,
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
