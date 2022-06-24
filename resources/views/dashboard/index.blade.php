@extends('layouts.app')

@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <h5 class="page-title">{{ __('Dashboard') }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Client') }}</h4>
                    </div>
                    <div class="card-body" id="client_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Salary') }}</h4>
                    </div>
                    <div class="card-body" id="salary_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Income Per Farm') }}</h4>
                    </div>
                    <div class="card-body" id="income_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Plantantion Report') }}</h4>
                    </div>
                    <div class="card-body" id="plantation_div">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Fixed Expenses') }}</h4>
                    </div>
                    <div class="card-body" id="expense_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Employee View') }}</h4>
                    </div>
                    <div class="card-body" id="employeeSalary_div">
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
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
        // google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(salaryBar);
        google.charts.setOnLoadCallback(expenseBar);
        google.charts.setOnLoadCallback(clientPie);
        google.charts.setOnLoadCallback(employeeSalaryBar);
        google.charts.setOnLoadCallback(plantationBar);
        google.charts.setOnLoadCallback(deathReportBar);
        google.charts.setOnLoadCallback(invoiceBar);


        function salaryBar() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Last Year', 'Current Year'],

                @php
                    foreach ($salaries as $salary) {
                        echo "['" . $salary->name . "', " . $salary->last_year . ', ' . $salary->current_year . '],';
                    }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Salary',
                    subtitle: '',
                },
                bar: {
                    groupWidth: '50%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
                axes: {
                    y: {
                        distance: {
                            label: 'parsecs'
                        }, // Left y-axis.
                        brightness: {
                            side: 'right',
                            label: 'apparent magnitude'
                        } // Right y-axis.
                    }
                }
            };

            var chart = new google.charts.Bar(document.getElementById('salary_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function clientPie() {
            var data = google.visualization.arrayToDataTable([
                ['Last Year', 'Current Year'],
                ["Last Year", @php echo $client->last_year @endphp],
                ["Current Year", @php echo $client->current_year @endphp],
            ]);
            var options = {
                chart: {
                    title: 'Client',
                    subtitle: '',
                    is3D: false,

                },
                bar: {
                    groupWidth: '50%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.visualization.PieChart(document.getElementById('client_div'));
            chart.draw(data, options);
        }

        function expenseBar() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Last Year', 'Current Year'],

                @php
                    foreach ($expenses as $expense) {
                        echo "['" . $expense->name . "', " . $expense->last_year . ', ' . $expense->current_year . '],';
                    }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Expenses',
                    subtitle: '',
                },
                bar: {
                    groupWidth: '100%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('expense_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function invoiceBar() {
            var data = google.visualization.arrayToDataTable([
                ['', 'Last Year', 'Current Year'],

                @php
                    foreach ($incomes as $income) {
                        echo "['" . $income->name . "', " . $income->last_year . ', ' . $income->current_year . '],';
                    }
                @endphp
            ]);

            var options = {
                chart: {
                    title: 'Income',
                    subtitle: '',
                },
                bar: {
                    groupWidth: '100%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('income_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

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
                    title: 'Employee Salary',
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

        function plantationBar() {
            var data = google.visualization.arrayToDataTable([
                ['Name', 'Quantity'],
                @php
                    foreach ($plantations as $plantation) {
                        echo "['" . $plantation->desc . "', " . $plantation->quantity . '],';
                    }
                @endphp
            ]);
            var options = {
                chart: {
                    title: 'Plantantion',
                    subtitle: '',
                    is3D: false,

                },
                bar: {
                    groupWidth: '100%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('plantation_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }

        function deathReportBar() {
            var data = google.visualization.arrayToDataTable([
                ['Name', 'Quantity'],
                @php
                    foreach ($death_reports as $death_report) {
                        echo "['" . $death_report->desc . "', " . $death_report->quantity . '],';
                    }
                @endphp
            ]);
            var options = {
                chart: {
                    title: 'Death',
                    subtitle: '',
                    is3D: false,

                },
                bar: {
                    groupWidth: '100%'
                },
                height: 500,
                colors: ['#6590aa', '#1b435d'],
            };

            var chart = new google.charts.Bar(document.getElementById('death_report_div'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>
@endsection
