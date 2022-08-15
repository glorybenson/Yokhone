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
        <style>
            <!--/* Extra small devices (phones, 600px and down) */
            @media only screen and (max-width: 600px) {
              .client {display: none;}
              .client_mobile {width: 100%;}
            }
            
            /* Small devices (portrait tablets and large phones, 600px and up) */
            @media only screen and (min-width: 600px) {
              .client {width: 100%;}
              .client_mobile {display: none;}
            }
            
            /* Medium devices (landscape tablets, 768px and up) */
            @media only screen and (min-width: 768px) {
              .client {width: 100%;}
              .client_mobile {display: none;}
            } 
            
            /* Large devices (laptops/desktops, 992px and up) */
            @media only screen and (min-width: 992px) {
              .client {width: 100%;}
              .client_mobile {display: none;}
            } 
            
            /* Extra large devices (large laptops and desktops, 1200px and up) */
            @media only screen and (min-width: 1200px) {
              .client {width: 100%;}
              .client_mobile {display: none;}
            }
            </style>

        <div class="row">
            <div class="client">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Number of Clients') }}</h4>
                    </div>
                    <div class="card-body" id="client_div">
                    </div>
                </div>
            </div>
        </div>

            <div class="client_mobile">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Number of Clients') }}</h4>
                    </div>
                    <div class="card-body" id="client_div">
                        <canvas width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Salary') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="salary_div" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Employee View') }}</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="employee_div" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Gross Income Per Farm') }}</h4>
                    </div>
                    <div class="card-body" id="">
                        <canvas id="gross_income" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title float-left">{{ __('Net Income Per Farm') }}</h4>
                    </div>
                    <div class="card-body" id="">
                        <canvas id="net_income" width="300" height="300"></canvas>
                    </div>
                </div>
            </div>
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
            <div class="col-xl-6">
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
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        //Plantation
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
                plugins: {
                    legend: {
                        labels: {
                            boxWidth: 10
                        }
                    }
                }
            }
        });

        //Death 
        var deathDiv = document.getElementById("death_report_div").getContext("2d");
        const treeDataDeath = @json($tree_data_death ?? '');
        const newDeathData = @json($death_data ?? '');
        console.log(newDeathData)

        const arr2 = farms.map((el, index) => {
            return {
                label: el.farm_name,
                backgroundColor: colors[index],
                data: newDeathData,
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
                plugins: {
                    legend: {
                        labels: {
                            boxWidth: 10
                        }
                    }
                }
            }
        });



        //Expenses
        var expensesDiv = document.getElementById("expenses_div").getContext("2d");
        const expenses = @json($expenses ?? '');
        const expensesData = {
            labels: ["Expense"],
            datasets: [{
                    label: ['Last Year'],
                    backgroundColor: "#6590aa",
                    data: [expenses.last_year],
                    categoryPercentage: 0.2,
                    barThickness: 'flex'
                },
                {
                    label: ['Current Year'],
                    backgroundColor: "#1b435f",
                    data: [expenses.current_year],
                    categoryPercentage: 0.2,
                    barThickness: 'flex'
                }
            ]
        };

        new Chart(expensesDiv, {
            type: 'bar',
            data: expensesData,
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


        //Gross Income Per Farm
        var grossIncomeDiv = document.getElementById("gross_income").getContext("2d");
        const incomeData = @json($income_data ?? '');
        var grossIncomeData = {
            labels: incomeData.farm_names,
            datasets: [{
                    label: "Last Year",
                    backgroundColor: "#6590aa",
                    data: incomeData.last_year_gross_income,
                },
                {
                    label: "Current Year",
                    backgroundColor: "#1b435d",
                    data: incomeData.current_year_gross_income,
                }
            ]
        };

        new Chart(grossIncomeDiv, {
            type: 'bar',
            data: grossIncomeData,
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

        //Net Income Per Farm
        var netIncomeDiv = document.getElementById("net_income").getContext("2d");
        var netIncomeData = {
            labels: incomeData.farm_names,
            datasets: [{
                    label: "Last Year",
                    backgroundColor: "#6590aa",
                    data: incomeData.last_year_net_income,
                },
                {
                    label: "Current Year",
                    backgroundColor: "#1b435d",
                    data: incomeData.current_year_net_income,
                }
            ]
        };

        new Chart(netIncomeDiv, {
            type: 'bar',
            data: netIncomeData,
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


        //Employee's Salaries
        var employeeDiv = document.getElementById("employee_div").getContext("2d");
        const employeeSalaries = @json($employee_salaries ?? '');
        const employeeLastYearSalary = @json($employee_last_year_salary ?? '');
        const employeeCurrentYearSalary = @json($employee_current_year_salary ?? '');
        const employeeNames = @json($employee_names ?? '');
        var employeeData = {
            labels: employeeNames,
            datasets: [{
                    label: "Last Year",
                    backgroundColor: "#6590aa",
                    data: employeeLastYearSalary,
                },
                {
                    label: "Current Year",
                    backgroundColor: "#1b435d",
                    data: employeeCurrentYearSalary
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

        //Salary
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


        google.charts.load('current', {
            'packages': ['bar', 'corechart']
        });

        google.charts.setOnLoadCallback(clientPie);

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
    </script>
@endsection
