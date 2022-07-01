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
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Plantation Report') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="plantation_div" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Death Report') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="death_report_div" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        //Plantation
        //Gross Income Per Farm
        var plantationDiv = document.getElementById("plantation_div").getContext("2d");
        const treeData = @json($tree_data_plan ?? '');
        const newPlantationData = @json($plantation_data ?? '');
        const colors = ["#6590aa", "#1b435f", "#6590aa", "#1b435f", "#6590aa", "#1b435f", "#6590aa", "#1b435f"];
        const farms = @json($farms ?? '');

        const arr = farms.map((el, index) => {
            return {
                label: el.farm_name,
                backgroundColor: colors[index],
                data: newPlantationData,
                // maxBarThickness: 100,
                // borderRadius: 5,
                // skipNull: true,
                parsing: {
                    yAxisKey: `farm${el.id}`
                }
            }
        })

        var plantationData = {
            labels: treeData,
            datasets: arr,
        };

        new Chart(plantationDiv, {
            type: 'bar',
            data: plantationData,
            options: {
                barValueSpacing: 20,
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });

        var deathDiv = document.getElementById("death_report_div").getContext("2d");
        const treeDataDeath = @json($tree_data_death ?? '');
        const newDeathData = @json($death_data ?? '');
        console.log(newDeathData)

        const arr2 = farms.map((el, index) => {
            return {
                label: el.farm_name,
                backgroundColor: colors[index],
                data: newDeathData,
                // skipNull: true,
                // maxBarThickness: 100,
                // borderRadius: 5,
                parsing: {
                    yAxisKey: `farm${el.id}`
                }
            }
        })

        var deathData = {
            labels: treeDataDeath,
            datasets: arr2,
        };

        new Chart(deathDiv, {
            type: 'bar',
            data: deathData,
            options: {
                barValueSpacing: 20,
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });
    </script>
@endsection
