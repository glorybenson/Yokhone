@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Income Report') }}</h5>
                        {{-- <ul class="breadcrumb ml-2"> --}}
                        {{-- <li class="breadcrumb-item active">{{__('Farms')}}</li> --}}
                        {{-- </ul> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Gross Income Per Farm') }}</h4>
                    </div>
                    <div class="card-body" id="income_gross_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Net Income Per Farm') }}</h4>
                    </div>
                    <div class="card-body" id="income_net_div">
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
        
        google.charts.setOnLoadCallback(incomeNet);
        google.charts.setOnLoadCallback(incomeGross);
        function incomeGross() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Current Year Gross', 'Last Year Gross'],
                @php
                    foreach ($incomes_gross as $data) {
                        echo "['" . $data->name . "', " . $data->current_year_gross . ', ' . $data->last_year_gross . '],';
                    }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Revenu brut',
                    subtitle: '',
                },
                bar: {
                    groupWidth: '50%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('income_gross_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function incomeNet() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Current Year Net', 'Last Year Net'],
                @php
                    foreach ($incomes_net as $data) {
                        echo "['" . $data->name . "', " . $data->current_year_net . ', ' . $data->last_year_net . '],';
                    }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Revenu net',
                    subtitle: '',
                },
                bar: {
                    groupWidth: '50%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('income_net_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

    </script>
@endsection

