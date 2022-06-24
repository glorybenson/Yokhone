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

        //!income
        $incomes = [];
        foreach ($farms as $farm) {
            # code...
            $last_year = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->subYear()->year)->get()->sum('total_price_before_discount');
            $current_year = Invoice::where("farm_id", $farm->id)->whereYear('date', now()->year)->get()->sum('total_price_before_discount');
            $income = (object) [
                "name" => $farm->farm_name,
                "last_year" => $last_year,
                "current_year" => $current_year
            ];
            if ($last_year > 0 || $current_year > 0) {
                array_push($incomes, $income);
            }
        }
        $data["incomes"] = $incomes;

        //Employer
        // $last_year_employee = Employee::whereYear('created_at', now()->subYear()->year)->count();
        // $current_year_employee = Employee::whereYear('created_at', now()->year)->count();
        // $data['employee'] = $c = (object) [
        //     "name" => "Employee",
        //     "last_year" => $last_year_employee,
        //     "current_year" => $current_year_employee
        // ];

        //Salary
        $last_year_salary = Payment::whereYear('date', now()->subYear()->year)->get()->sum('amount');
        $current_year_salary = Payment::whereYear('date', now()->year)->get()->sum('amount');
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

        $data['plantations'] = Tree::where('reason', "Plantation")->get();

        $data['death_reports']  = Tree::where(['reason' => "Death"])->get();

        //Employee Salary
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


        //Expenses per farm vs last yr/ current year
        // $last_year_expense = Expense::groupBy('farm_id')
        //     ->selectRaw('sum(amount) as sum')->whereYear('date', now()->subYear()->year)
        //     ->get();
        // $current_year_expense = Expense::groupBy('farm_id')
        //     ->selectRaw('sum(amount) as sum')->whereYear('date', now()->year)
        //     ->get();

        //Expenses per year
        $last_year_expense = Expense::whereYear('date', now()->subYear()->year)->get()->sum('amount');
        $current_year_expense = Expense::whereYear('date', now()->year)->get()->sum('amount');
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