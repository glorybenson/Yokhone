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


        $plan_name_plan = [];
        $plan_name_death = [];
        $plantation_trees_array = $plantation_trees->groupBy('desc')->all();
        $death_trees_array = $death_trees->groupBy('desc')->all();
        // $plantation_result3 = $plantation_trees->groupBy(['desc', function ($item) {
        //     return $item['desc'];
        // }], preserveKeys: true);

        // $plantation_result2 = $death_trees->groupBy(['desc', function ($item) {
        //     return $item['desc'];
        // }], preserveKeys: true);

        // dd($plantation_result, $plantation_result3);
        // $plan_data = [];
        // $plan_data2 = [];

        // foreach ($plantation_result as $plantation_key => $plantation_value) {
        //     # code...
        //     array_push($plan_data, $plantation_value[$plantation_key]);
        // }

        // foreach ($plantation_result2 as $plantation_key => $plantation_value) {
        //     # code...
        //     // dd($plantation_value);
        //     array_push($plan_data2, $plantation_value[$plantation_key]);
        // }

        $arr = [];
        foreach ($plantation_trees_array as $key => $data) {
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
        foreach ($death_trees_array as $key => $data) {
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

    public function farm(Request $request)
    {
        $data['title'] = "Farm Report";
        $data['farms'] = $farms = Farm::all();
        $farm__array = [];
        $array = [];
        if ($_POST) {
            $from = $request->from;
            $to = $request->to;
            if (isset($from) && isset($to)) {
                $data['mode'] = "search";
                $data['from'] = $from;
                $data['to'] = $to;
                foreach ($farms as $farm) {
                    $expense = Expense::where("farm_id", $farm->id)->whereBetween('date', [$from, $to])->get()->sum('amount');
                    $income = Invoice::where("farm_id", $farm->id)->whereBetween('date', [$from, $to])->get()->sum('total_price_after_discount');
                    $plan_obj = (object)[];
                    if ($expense > 0 || $income > 0) {
                        $plan_obj->x = $farm->farm_name;
                    }
                    if ($expense > 0) {
                        $plan_obj->expense = $expense;
                    }
                    if ($income > 0) {
                        $plan_obj->income = $income;
                    }

                    array_push($array, $plan_obj);
                }
            }
        } else {
            foreach ($farms as $farm) {
                $expense = Expense::where("farm_id", $farm->id)->get()->sum('amount');
                $income = Invoice::where("farm_id", $farm->id)->get()->sum('total_price_after_discount');
                $plan_obj = (object)[];
                if ($expense > 0 || $income > 0) {
                    $plan_obj->x = $farm->farm_name;
                }
                if ($expense > 0) {
                    $plan_obj->expense = $expense;
                }
                if ($income > 0) {
                    $plan_obj->income = $income;
                }

                array_push($array, $plan_obj);
            }
        }
        $data['farm_data'] = (object) [
            "farms" => $farm__array,
            "all_farm_data" => $array
        ];

        return view('report.farm', $data);
    }

    public function income(Request $request)
    {
        $data['title'] = "Income Report";
        $data['farms'] = $farms = Farm::all();
        $farm__array = [];
        $income_array = [];

        if ($_POST) {
            $from = $request->from;
            $to = $request->to;
            if (isset($from) && isset($to)) {
                $data['mode'] = "search";
                $data['from'] = $from;
                $data['to'] = $to;
                foreach ($farms as $farm) {
                    $income = Invoice::where("farm_id", $farm->id)->whereBetween('date', [$from, $to])->get()->sum('total_price_after_discount');
                    if ($income > 0) {
                        array_push($farm__array, $farm->farm_name);
                        array_push($income_array, $income);
                    }
                }
            }
        } else {
            foreach ($farms as $farm) {
                $income = Invoice::where("farm_id", $farm->id)->get()->sum('total_price_after_discount');
                if ($income > 0) {
                    array_push($farm__array, $farm->farm_name);
                    array_push($income_array, $income);
                }
            }
        }

        $data['incomes_data'] = $d = (object) [
            "farms" => $farm__array,
            "all_incomes_data" => $income_array
        ];

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

    public function expenses(Request $request)
    {
        $data['title'] = "Expense Report";
        $data['farms'] = $farms = Farm::all();
        $farm__array = [];
        $expense_array = [];

        if ($_POST) {
            $from = $request->from;
            $to = $request->to;
            if (isset($from) && isset($to)) {
                $data['mode'] = "search";
                $data['from'] = $from;
                $data['to'] = $to;
                foreach ($farms as $farm) {
                    $expense = Expense::where("farm_id", $farm->id)->whereBetween('date', [$from, $to])->get()->sum('amount');
                    if ($expense > 0) {
                        array_push($farm__array, $farm->farm_name);
                        array_push($expense_array, $expense);
                    }
                }
            }
        } else {
            foreach ($farms as $farm) {
                $expense = Expense::where("farm_id", $farm->id)->get()->sum('amount');
                if ($expense > 0) {
                    array_push($farm__array, $farm->farm_name);
                    array_push($expense_array, $expense);
                }
            }
        }

        $data['expenses_data'] = $d = (object) [
            "farms" => $farm__array,
            "all_expenses_data" => $expense_array
        ];

        return view('report.expense', $data);
    }

    public function employee(Request $request)
    {
        $data['title'] = "Employees Report";
        $data["employers"] = $employers = Employee::all();
        $salaries_array = [];
        $emplyees_array = [];

        if ($_POST) {
            $from = $request->from;
            $to = $request->to;
            if (isset($from) && isset($to)) {
                foreach ($employers as $employee) {
                    $salary = Expense::where("employee_id", $employee->id)
                        ->whereBetween('date', [$from, $to])
                        ->get()->sum('amount');
                    if ($salary > 0) {
                        $name = $employee->first_name . " " . $employee->last_name;
                        array_push($salaries_array, $salary);
                        array_push($emplyees_array, $name);
                    }
                }
            }
        } else {
            foreach ($employers as $employee) {
                $salary = Expense::where("employee_id", $employee->id)
                    ->get()->sum('amount');
                if ($salary > 0) {
                    $name = $employee->first_name . " " . $employee->last_name;
                    array_push($salaries_array, $salary);
                    array_push($emplyees_array, $name);
                }
            }
        }


        $data['employees_data'] = $d = (object) [
            "employee" => $emplyees_array,
            "all_employees_salaries" => $salaries_array
        ];

        // dd($d);
        return view('report.employee', $data);
    }

    public function trees(Request $request)
    {
        $data['title'] = "Tree Report";
        $plan_name_plan = [];
        $plan_name_death = [];
        $death_trees = Tree::where("reason", "Death")->with("farm")->get();
        $plantation_trees = Tree::where("reason", "Plantation")->with("farm")->get();
        $plantation_trees_array = $plantation_trees->groupBy('desc')->all();
        $death_trees_array = $death_trees->groupBy('desc')->all();

        if ($_POST) {
            $from = $request->from;
            $to = $request->to;
            if (isset($from) && isset($to)) {
                $data['mode'] = "search";
                $data['from'] = $from;
                $data['to'] = $to;
                $death_trees = Tree::whereBetween('date_planted', [$from, $to])->where("reason", "Death")->with("farm")->get();
                $plantation_trees = Tree::whereBetween('date_planted', [$from, $to])->where("reason", "Plantation")->with("farm")->get();
            }
        }

        $arr = [];
        foreach ($plantation_trees_array as $key => $data) {
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
        foreach ($death_trees_array as $key => $data) {
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