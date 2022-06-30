<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Farm;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Salary;
use App\Models\Tree;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = "Dasboard";
        $employers = Employee::all();
        $death_trees = Tree::where("reason", "Death")->with("farm")->get();

        $death_reports = [];
        $death_result = $death_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        foreach ($death_result as $key => $value) {
            # code...
            $new_data = $value[$key];
            $obj = (object)[
                "name" => $key,
            ];
            foreach ($new_data as $data) {
                $obj->{"farm_" . $data->farm->id} = $data->quantity;
            }
            array_push($death_reports, $obj);
        }
        $data['death_reports'] = $death_reports;

        $plantation_trees = Tree::where("reason", "Plantation")->with("farm")->get();

        $plantations = [];
        $plantation_result = $plantation_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        foreach ($plantation_result as $plantation_key => $plantation_value) {
            # code...
            $plantation_data = $plantation_value[$plantation_key];
            $plantation_obj = (object)[
                "name" => $plantation_key,
            ];
            foreach ($plantation_data as $data_plantation) {
                $plantation_obj->{"farm_" . $data_plantation->farm->id} = $data_plantation->quantity;
            }
            array_push($plantations, $plantation_obj);
        }

        $data['plantations'] = $plantations;
        // $farms = Farm::all();
        // $plantation_data = [];
        // $death_data = [];
        // $tree_grouped = $plantation_trees->groupBy(['desc', function ($item) {
        //     return $item['desc'];
        // }], preserveKeys: true);
        // foreach ($farms as $farm) {
        //     $plantations = Tree::where(["reason" => "Plantation", "farm_id" => $farm->id])->with("farm")->get();
        //     $deaths = Tree::where(["reason" => "Death", "farm_id" => $farm->id])->with("farm")->get();
        //     $farm_data_plantation = [];
        //     $farm_data_death = [];
        //     foreach ($plantations as $plantation) {
        //         $obj = (object) [
        //             "id" => $plantation->id,
        //             "data" => $plantation->quantity
        //         ];
        //         array_push($farm_data_plantation, $obj);
        //     }
        //     foreach ($deaths as $death) {
        //         array_push($farm_data_death, $death->quantity);
        //     }

        //     $farm_obj = (object) [
        //         "name" => $farm->farm_name,
        //         "data" => $farm_data_plantation
        //     ];
        //     $farm_obj2 = (object) [
        //         "name" => $farm->farm_name,
        //         "data" => $farm_data_death
        //     ];

        //     array_push($plantation_data, $farm_obj);
        //     array_push($death_data, $farm_obj2);
        // }

        //dd($plantation_data, $death_data, $tree_grouped);
        dd($plantation_result, $death_reports);




        //Client
        $last_year_client = Client::whereYear('date_become_client', now()->subYear()->year)->count();
        $current_year_client = Client::whereYear('date_become_client', now()->year)->count();
        $data['client'] = $c = (object) [
            "name" => "Client",
            "last_year" => $last_year_client,
            "current_year" => $current_year_client
        ];




        $data['farms_dums'] = $farms_dums = array('', '', '');


        //Salary
        $last_year_salary = Payment::whereYear('date', now()->subYear()->year)->get()->sum('amount');
        $current_year_salary = Payment::whereYear('date', now()->year)->get()->sum('amount');
        $data['salary'] =
            (object)[
                "last_year" => $last_year_salary,
                "current_year" => $current_year_salary
            ];


        //Employee Salary
        $employee_last_year_salary = [];
        $employee_current_year_salary = [];
        $employee_names = [];
        foreach ($employers as $employee) {
            # code...
            $current_year_salary = Payment::where("employee_id", $employee->id)
                ->whereYear('date', now()->year)
                ->get()->sum('amount');
            $last_year_salary = Payment::where("employee_id", $employee->id)
                ->whereYear('date', now()->subYear()->year)
                ->get()->sum('amount');
            if ($last_year_salary > 0 || $current_year_salary > 0) {
                $name_obj = $employee->first_name . " " . $employee->last_name;
                array_push($employee_last_year_salary, $last_year_salary);
                array_push($employee_current_year_salary, $current_year_salary);
                array_push($employee_names, $name_obj);
            }
        }
        $data['employee_last_year_salary'] = $employee_last_year_salary;
        $data['employee_current_year_salary'] = $employee_current_year_salary;
        $data['employee_names'] = $employee_names;


        //Gross Income Per Farm && Net Income Per Farm
        $data['farms'] = $farms = Farm::all();
        $farm_names = [];
        $last_year_net_income = [];
        $current_year_net_income = [];
        $last_year_gross_income = [];
        $current_year_gross_income = [];
        foreach ($farms as $farm) {
            # code...
            $last_year_net = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->subYear()->year)->get()->sum('total_price_after_discount');
            $current_year_net = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->year)->get()->sum('total_price_after_discount');
            $last_year_gross = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->subYear()->year)->get()->sum('total_price_before_discount');
            $current_year_gross = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->year)->get()->sum('total_price_before_discount');

            if (($last_year_net + $current_year_net) > 0) {
                array_push($farm_names, $farm->farm_name);
                array_push($last_year_net_income, $last_year_net);
                array_push($current_year_net_income, $current_year_net);
            }
            if (($last_year_gross + $current_year_gross) > 0) {
                array_push($last_year_gross_income, $last_year_gross);
                array_push($current_year_gross_income, $current_year_gross);
            }
        }
        $data['income_data'] = (object) [
            "farm_names" => $farm_names,
            "last_year_net_income" => $last_year_net_income,
            "current_year_net_income" => $current_year_net_income,
            "last_year_gross_income" => $last_year_gross_income,
            "current_year_gross_income" => $current_year_gross_income
        ];

        //Expenses
        $last_year_expense = Expense::whereYear('date', now()->subYear()->year)->get()->sum('amount');
        $current_year_expense = Expense::whereYear('date', now()->year)->get()->sum('amount');
        $data['expenses'] =
            (object)[
                "last_year" => $last_year_expense,
                "current_year" => $current_year_expense
            ];

        return view('dashboard.index', $data);
    }

    public function income()
    {
        $data['title'] = "Income Report";
        $data['farms'] = $farms = Farm::all();
        $incomes_net = [];
        $incomes_gross = [];
        foreach ($farms as $farm) {
            # code...
            $last_year_net = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->subYear()->year)->get()->sum('total_price_after_discount');
            $current_year_net = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->year)->get()->sum('total_price_after_discount');
            $last_year_gross = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->subYear()->year)->get()->sum('total_price_before_discount');
            $current_year_gross = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->year)->get()->sum('total_price_before_discount');

            $income_net = (object) [
                "name" => $farm->farm_name,
                "last_year_net" => $last_year_net,
                "current_year_net" => $current_year_net,
            ];
            $income_gross = (object) [
                "name" => $farm->farm_name,
                "last_year_gross" => $last_year_gross,
                "current_year_gross" => $current_year_gross
            ];
            array_push($incomes_net, $income_net);
            array_push($incomes_gross, $income_gross);
        }
        $data["incomes_gross"] = $incomes_gross;
        $data["incomes_net"] = $incomes_net;
        return view('report.income', $data);
    }

    public function salary()
    {
        $data['title'] = "Salaries Report";
        $last_year_salary = Payment::whereYear('date', now()->subYear()->year)->get()->sum('amount');
        $current_year_salary = Payment::whereYear('date', now()->year)->get()->sum('amount');
        $data['salaries'] = array(
            (object)[
                "name" => "Salary",
                "last_year" => $last_year_salary,
                "current_year" => $current_year_salary
            ],
        );
        return view('report.salary', $data);
    }

    public function client()
    {
        $data['title'] = "Client Report";
        $last_year_client = Client::whereYear('date_become_client', now()->subYear()->year)->count();
        $current_year_client = Client::whereYear('date_become_client', now()->year)->count();
        $data['client'] = $c = (object) [
            "name" => "Client",
            "last_year" => $last_year_client,
            "current_year" => $current_year_client
        ];
        return view('report.client', $data);
    }

    public function expenses()
    {
        $data['title'] = "Expense Report";
        $last_year_expense = Expense::whereYear('date', now()->subYear()->year)->get()->sum('amount');
        $current_year_expense = Expense::whereYear('date', now()->year)->get()->sum('amount');
        $data['expenses'] =  array(
            (object)[
                "name" => "Expense",
                "last_year" => $last_year_expense,
                "current_year" => $current_year_expense
            ],
        );
        $data['farms_dums'] = $farms_dums = array('', '', '');

        return view('report.expense', $data);
    }

    public function employee()
    {
        $data['title'] = "Salaries Report";
        $employers = Employee::all();

        $employee_salaries = [];
        foreach ($employers as $employee) {
            # code...
            $current_year_salary = Payment::where("employee_id", $employee->id)
                ->whereYear('date', now()->year)
                ->get()->sum('amount');
            $last_year_salary = Payment::where("employee_id", $employee->id)
                ->whereYear('date', now()->subYear()->year)
                ->get()->sum('amount');
            $params =
                (object)[
                    "name" => $employee->first_name . " " . $employee->last_name,
                    "last_year" => $last_year_salary,
                    "current_year" => $current_year_salary
                ];
            if ($last_year_salary > 0 || $current_year_salary > 0) {
                array_push($employee_salaries, $params);
            }
        }
        $data['employee_salaries'] = $employee_salaries;

        return view('report.employee', $data);
    }

    public function trees()
    {
        $data['title'] = "Tree Report";
        $employers = Employee::all();
        $death_trees = Tree::where("reason", "Death")->with("farm")->get();

        $death_reports = [];
        $death_result = $death_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        foreach ($death_result as $key => $value) {
            # code...
            $new_data = $value[$key];
            $obj = (object)[
                "name" => $key,
            ];
            foreach ($new_data as $data) {
                $obj->{"farm_" . $data->farm->id} = $data->quantity;
            }
            array_push($death_reports, $obj);
        }
        $data['death_reports'] = $death_reports;

        $plantation_trees = Tree::where("reason", "Plantation")->with("farm")->get();

        $plantations = [];
        $plantation_result = $plantation_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        foreach ($plantation_result as $plantation_key => $plantation_value) {
            # code...
            $plantation_data = $plantation_value[$plantation_key];
            $plantation_obj = (object)[
                "name" => $plantation_key,
            ];
            foreach ($plantation_data as $data_plantation) {
                $plantation_obj->{"farm_" . $data_plantation->farm->id} = $data_plantation->quantity;
            }
            array_push($plantations, $plantation_obj);
        }

        $data['plantations'] = $plantations;

        $data['farms'] = $farms = Farm::all();
        return view('report.tree', $data);
    }
}