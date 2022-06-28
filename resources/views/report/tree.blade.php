@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Tree Report') }}</h5>
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
                        <h4 class="card-title float-left">{{ __('Plantation Report') }}</h4>
                    </div>
                    <div class="card-body" id="plantation_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Death Report') }}</h4>
                    </div>
                    <div class="card-body" id="death_report_div">
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
        
        google.charts.setOnLoadCallback(plantationBar);
        google.charts.setOnLoadCallback(deathReportBar);

        function plantationBar() {
            var data = google.visualization.arrayToDataTable([
                @php
                    echo "['',";
                    foreach ($farms_dums as $index => $data) {
                        echo "'";
    
                        echo isset($farms[$index]->farm_name) && $farms[$index]->farm_name !== null ? $farms[$index]->farm_name : $data;
                        echo "',";
                    }
                    echo ']';
                
                    @endphp,
                
                    @php
                    foreach ($plantations as $data) {
                        // echo "['" . $data->name . "', " . (isset($data->farm_1) ? $data->farm_1 : 0) . ', ' . (isset($data->farm_2) ? $data->farm_2 : 0) . ', ' . (isset($data->farm_3) ? $data->farm_3 : 0) . ', ' . (isset($data->farm_4) ? $data->farm_4 : 0) . ', ' . (isset($data->farm_5) ? $data->farm_5 : 0) . ', ' . (isset($data->farm_6) ? $data->farm_6 : 0) . '],';
                        echo "['" . $data->name . "', " . (isset($data->farm_1) ? $data->farm_1 : 0) . ', ' . (isset($data->farm_2) ? $data->farm_2 : 0) . ', ' . (isset($data->farm_5) ? $data->farm_5 : 0) . '],';
                    }
                @endphp
            ]);
            var options = {
                chart: {
                    title: "{{ __('Plantantion') }}",
                },
                bars: 'vertical',
                bar: {
                    groupWidth: '50%'
                },
                colors: ['#6590aa', '#1b435d', '#2596be', '#1b435d', '#6590aa', '#1b435d'],
                height: 600,
                chartArea: {
                    height: 300,
                    top: 100,
                },
                hAxis: {
                    slantedText: true,
                    slantedTextAngle: 45,

                },
            };

            var chart = new google.charts.Bar(document.getElementById('plantation_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }


        function deathReportBar() {
            var data = google.visualization.arrayToDataTable([
                @php
                    echo "['',";
                    foreach ($farms_dums as $index => $data) {
                        echo "'";
    
                        echo isset($farms[$index]->farm_name) && $farms[$index]->farm_name !== null ? $farms[$index]->farm_name : $data;
    
                        echo "',";
                    }
                    echo ']';
                @endphp,
                @php
                    foreach ($death_reports as $data) {
                        echo "['" . $data->name . "', " . (isset($data->farm_1) ? $data->farm_1 : 0) . ', ' . (isset($data->farm_2) ? $data->farm_2 : 0) . ', ' . (isset($data->farm_5) ? $data->farm_5 : 0) . '],';
                    }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Décès',
                },
                bars: 'vertical',
                bar: {
                    groupWidth: '50%'
                },
                colors: ['#6590aa', '#1b435d', '#2596be', '#1b435d', '#6590aa', '#1b435d'],
                height: 600,
                chartArea: {
                    height: 300,
                    top: 100,
                },
                hAxis: {
                    slantedText: true,
                    slantedTextAngle: 45,

                },
            };

            var chart = new google.charts.Bar(document.getElementById('death_report_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

    </script>

@endsection
