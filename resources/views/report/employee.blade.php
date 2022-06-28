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
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Employee View') }}</h4>
                    </div>
                    <div class="card-body" id="employeeSalary_div">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        google.charts.load('current', {
            'packages': ['bar', 'corechart']
        });
        
        google.charts.setOnLoadCallback(employeeSalaryBar);
        

        function employeeSalaryBar() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Last Year', 'Current Year'],
                @php
                    foreach ($employee_salaries as $employee_salary) {
                        echo "['" . $employee_salary->name . "', " . $employee_salary->last_year . ', ' . $employee_salary->current_year . '],';
                    }
                @endphp
            ]);
            var options = {
                chart: {
                    title: 'Salaire des employés',
                    subtitle: '',
                    is3D: false,

                },
                bar: {
                    groupWidth: '50%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('employeeSalary_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

    </script>

@endsection
