<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Farm;
use App\Models\Salary;
use App\Models\Tree;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $farms = Farm::all();

        //Employer
        $last_year_employee = Employee::whereYear('created_at', now()->subYear()->year)->count();
        $current_year_employee = Employee::whereYear('created_at', now()->year)->count();
        $data['employee'] = $c = (object) [
            "name" => "Employee",
            "last_year" => $last_year_employee,
            "current_year" => $current_year_employee
        ];

        //Salary
        $last_year_salary = Salary::whereYear('created_at', now()->subYear()->year)->get()->sum('amount');
        $current_year_salary = Salary::whereYear('created_at', now()->year)->get()->sum('amount');
        $data['salaries'] = array(
            (object)[
                "name" => "Salary",
                "last_year" => $last_year_salary,
                "current_year" => $current_year_salary
            ],
        );

        //Client
        $last_year_client = Client::whereYear('date_become_client', now()->subYear()->year)->count();
        $current_year_client = Client::whereYear('date_become_client', now()->year)->count();
        $data['client'] = $c = (object) [
            "name" => "Client",
            "last_year" => $last_year_client,
            "current_year" => $current_year_client
        ];

        //Plantation
        // $last_year_client = Tree::where('reason', "Plantation")->get()->sum('quantity');
        // $current_year_client = Tree::where('reason', "Death")->get()->sum('quantity');
        // $data['client'] = $c = (object) [
        //     "name" => "Client",
        //     "last_year" => $last_year_client,
        //     "current_year" => $current_year_client
        // ];

        $plantation = [];
        function group_by_me($array, $key)
        {
            $return = array();

            foreach ($array as $val) {
                $return[$val->$key][] = $val;
                //  ou para gettype($val) = array
                //  $return[$val[$key]][] = $val; 
            }
            return $return;
        }

        $plann = Tree::where('reason', "Plantation")->get();
        // dd($plann, "desc");
        // function group_by($key, $data)
        // {
        //     $result = array();

        //     foreach ($data as $val) {
        //         if (array_key_exists($key, $val)) {
        //             $result[$val[$key]][] = $val;
        //         } else {
        //             $result[""][] = $val;
        //         }
        //     }

        //     return $result;
        // }

        foreach ($farms as $farm) {
            # code...
            $get = Tree::where(["farm_id" => $farm->id, 'reason' => "Plantation"])->get()->sum('quantity');
            $get_tree = "";
            $get_tree = Tree::where(['reason' => "Plantation"])->get();
            $ggg = Tree::select('desc', DB::raw('GROUP_CONCAT(quantity) as quantity'))
                ->groupBy('desc')
                ->get();
            // dd($ggg, $get_tree);
            if ($get && $get_tree) {
                // dd($get, $get_tree);
                $params =
                    (object)[
                        "name" => $farm->farm_name,
                        "desc" => $get_tree,
                        "quantity" => $get,
                    ];
                array_push($plantation, $params);
            }
        }
        // dd($plantation);
        $data['plantations'] = $plantation;

        $death_report = [];
        foreach ($farms as $farm) {
            # code...
            $get = Tree::where(["farm_id" => $farm->id, 'reason' => "Death"])->get()->sum('quantity');
            if ($get) {
                $params =
                    (object)[
                        "name" => $farm->farm_name,
                        "desc" => $farm->farm_desc,
                        "quantity" => $get,
                    ];
                array_push($death_report, $params);
            }
        }
        $data['death_reports'] = $death_report;

        //Employer Salary
        // $last_year_expense = Salary::whereYear('created_at', now()->subYear()->year)->get()->sum('amount');
        // $current_year_expense = Salary::whereYear('created_at', now()->year)->get()->sum('amount');
        // $s = Salary::groupBy('employee_id')
        //     ->selectRaw('sum(amount) as sum, employee_id')->whereYear('created_at', now()->year)
        //     ->get();
        // $ls = Salary::groupBy('employee_id')
        //     ->selectRaw('sum(amount) as sum, employee_id')->whereYear('created_at', now()->subYear()->year)
        // ->get();
        //dd($s, $ls);
        // $data['employee_salaries'] =  array(
        //     (object)[
        //         "name" => "Expense",
        //         "last_year" => $last_year_expense,
        //         "current_year" => $current_year_expense
        //     ],
        // );


        $employee_salaries = [];
        foreach ($employers as $employee) {
            # code...
            $current_year_expense = Salary::where("employee_id", $employee->id)
                ->whereYear('created_at', now()->year)
                ->get()->sum('amount');
            $last_year_expense = Salary::where("employee_id", $employee->id)
                ->whereYear('created_at', now()->subYear()->year)
                ->get()->sum('amount');
            $params =
                (object)[
                    "name" => $employee->first_name . " " . $employee->last_name,
                    "last_year" => $last_year_expense,
                    "current_year" => $current_year_expense
                ];
            array_push($employee_salaries, $params);
        }
        $data['employee_salaries'] = $employee_salaries;


        //Expenses per farm vs last yr/ current year
        $last_year_expense = Expense::groupBy('farm_id')
            ->selectRaw('sum(amount) as sum')->whereYear('created_at', now()->subYear()->year)
            ->get();
        $current_year_expense = Expense::groupBy('farm_id')
            ->selectRaw('sum(amount) as sum')->whereYear('created_at', now()->year)
            ->get();

        //Expenses per year
        $last_year_expense = Expense::whereYear('created_at', now()->subYear()->year)->get()->sum('amount');
        $current_year_expense = Expense::whereYear('created_at', now()->year)->get()->sum('amount');
        $data['expenses'] =  array(
            (object)[
                "name" => "Expense",
                "last_year" => $last_year_expense,
                "current_year" => $current_year_expense
            ],
        );

        return view('dashboard.index', $data);
    }

    public function income()
    {
    }

    public function salary()
    {
        $data['title'] = "Salaries Report";
        $employers = Employee::all();
        $expenses = [];
        foreach ($employers as $employee) {
            # code...
            $current_year_expense = Salary::where("employee_id", $employee->id)
                ->selectRaw('sum(amount) as sum')->whereYear('created_at', now()->year)
                ->get();
            $last_year_expense = Salary::where("employee_id", $employee->id)
                ->selectRaw('sum(amount) as sum')->whereYear('created_at', now()->subYear()->year)
                ->get();
            $params =
                (object)[
                    "name" => $employee->first_name . " " . $employee->last_name,
                    "last_year" => $last_year_expense[0]->sum,
                    "current_year" => $current_year_expense[0]->sum
                ];
            array_push($expenses, $params);
        }
        $data['salaries'] = $expenses;
        return view('report.salary', $data);
    }
}