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
        $plantation_trees = Tree::where("reason", "Plantation")->with("farm")->get();

        $plantation_result = $plantation_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        $plantation_result2 = $death_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);


        $plan_name_plan = [];
        $plan_name_death = [];
        $plan_data = [];
        $plan_data2 = [];

        foreach ($plantation_result as $plantation_key => $plantation_value) {
            # code...
            array_push($plan_data, $plantation_value[$plantation_key]);
        }

        foreach ($plantation_result2 as $plantation_key => $plantation_value) {
            # code...
            array_push($plan_data2, $plantation_value[$plantation_key]);
        }

        $arr = [];
        foreach ($plan_data as $key => $data) {
            $plan_obj = (object)[];
            foreach ($data as $d) {
                $farm = Farm::find($d->farm_id);
                $farm_name = "farm$farm->id";
                $plan_obj->x = $d->desc;
                $plan_obj->$farm_name = $d->quantity;
            }
            array_push($arr, $plan_obj);
        }

        $arr2 = [];
        foreach ($plan_data2 as $key => $data) {
            $plan_obj = (object)[];
            foreach ($data as $d) {
                $farm = Farm::find($d->farm_id);
                $farm_name = "farm$farm->id";
                $plan_obj->x = $d->desc;
                $plan_obj->$farm_name = $d->quantity;
            }
            array_push($arr2, $plan_obj);
        }

        $data["tree_data_plan"] = $plan_name_plan;
        $data["tree_data_death"] = $plan_name_death;
        $data["plantation_data"] = $arr;
        $data["death_data"] = $arr2;
        $data["farms"] = Farm::all();


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

    public function farm()
    {
        return view('report.farm'); 
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
        $data['salary'] =
            (object)[
                "last_year" => $last_year_salary,
                "current_year" => $current_year_salary
            ];
        
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

    public function trees(Request $request)
    {
        $death_trees = Tree::where("reason", "Death")->with("farm")->get();
        $plantation_trees = Tree::where("reason", "Plantation")->with("farm")->get();
        if ($_POST) {
            $from = $request->from;
            $to = $request->to;
            $data['mode'] = "search";
            $data['from'] = $from;
            $data['to'] = $to;
            $death_trees = Tree::whereBetween('date_planted', [$from, $to])->where("reason", "Death")->with("farm")->get();
            $plantation_trees = Tree::whereBetween('date_planted', [$from, $to])->where("reason", "Plantation")->with("farm")->get();
        }


        // dd($death_trees);
        $data['title'] = "Tree Report";
        $employers = Employee::all();

        $plantation_result = $plantation_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        $plantation_result2 = $death_trees->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);


        $plan_name_plan = [];
        $plan_name_death = [];
        $plan_data = [];
        $plan_data2 = [];

        foreach ($plantation_result as $plantation_key => $plantation_value) {
            # code...
            array_push($plan_data, $plantation_value[$plantation_key]);
        }

        foreach ($plantation_result2 as $plantation_key => $plantation_value) {
            # code...
            array_push($plan_data2, $plantation_value[$plantation_key]);
        }

        $arr = [];
        foreach ($plan_data as $key => $data) {
            $plan_obj = (object)[];
            foreach ($data as $d) {
                $farm = Farm::find($d->farm_id);
                $farm_name = "farm$farm->id";
                $plan_obj->x = $d->desc;
                $plan_obj->$farm_name = $d->quantity;
            }
            array_push($arr, $plan_obj);
        }

        $arr2 = [];
        foreach ($plan_data2 as $key => $data) {
            $plan_obj = (object)[];
            foreach ($data as $d) {
                $farm = Farm::find($d->farm_id);
                $farm_name = "farm$farm->id";
                $plan_obj->x = $d->desc;
                $plan_obj->$farm_name = $d->quantity;
            }
            array_push($arr2, $plan_obj);
        }

        $data["tree_data_plan"] = $plan_name_plan;
        $data["tree_data_death"] = $plan_name_death;
        $data["plantation_data"] = $arr;
        $data["death_data"] = $arr2;
        $data["farms"] = Farm::all();
        return view('report.tree', $data);
    }
}