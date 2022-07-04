<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Crop;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Farm;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Record;
use App\Models\Absence;
use App\Models\Role;
use App\Models\Salary;
use App\Models\Tree;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        function save_file($file, $path)
        {
            $name = $path . date('dMY') . time() . '.' . $file->getClientOriginalExtension();
            $fileDestination = $path;
            $file->move($fileDestination, $name);
            return $name;
        }

        function send_notification($message, $first = null, $last = null)
        {
            $data = [
                'message' => $message,
                'data' => $first . ' ' . $last
            ];
            Notification::send(Auth::user(), new GeneralNotification($data));
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['title'] = "Users";
        $data['sn'] = 1;
        $data['users'] = User::with('created_user:id,first_name,last_name')->orderBy('id', 'desc')->get();
        return view('users.index', $data);
    }

    public function my_profile(Request $request)
    {
        try {
            # code...
            $data['mode'] = 'profile';
            if ($_POST) {
                $rules = array(
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::user()->id],
                );

                $validator = Validator::make($request->all(), $rules);
                // $validator->setAttributeNames($fieldNames);

                if ($validator->fails()) {
                    Session::flash(__('warning'),  __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                $user = User::find($request->id);
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->save();

                Session::flash(__('success'), __('Profile updated successfully'));
                return back();
            }
            return view('settings.profile', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function change_password(Request $request)
    {
        # code...
        try {
            //code...
            $data['mode'] = 'password';
            if ($_POST) {
                $rules = array(
                    'current_password'     => 'required',
                    'new_password'  => ['required', 'min:8', 'same:confirm_new_password', 'max:16', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&+-]/'],
                    'confirm_new_password' => 'required'
                );

                $fieldNames = array(
                    'current_password'     => 'Current Password',
                    'new_password'  => 'New Password',
                    'confirm_new_password' => 'Confirm New Password'
                );
                //dd($request);
                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);
                if ($validator->fails()) {
                    $request->session()->flash(__('warning'), __('Password must 8 character long, maximum of 16 character, One English uppercase characters (A – Z), One English lowercase characters (a – z), One Base 10 digits (0 – 9) and One Non-alphanumeric (For example: !, $, #, or %)'));
                    return back()->withErrors($validator);
                }

                $current_password = Auth::user()->password;
                if (!Hash::check($request->current_password, $current_password)) {
                    $request->session()->flash(__('warning'), __('Password Wrong'));
                    return back()->withErrors(['current_password' => __('Please enter correct current password')]);
                }

                $obj_user = User::find(Auth::user()->id);
                $obj_user->password = Hash::make($request->new_password);
                $obj_user->save();
                $request->session()->flash(__('success'), __('Password changed successfully'));
                return \back();
            }
            return view('settings.profile', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }


    public function create_user(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            if ($_POST) {
                //dd($request->all());
                $rules = array(
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'role' => ['required'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash(__('warning'), __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'roles' => $request->role,
                    'created_by' => Auth::user()->id,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);
                send_notification(__('Created a new user'), $request->first_name, $request->last_name);

                Session::flash(__('success'), __('User created successfully'));
                return redirect()->route('home');
            }

            $data['roles'] = Role::where('name', '!=', 'Admin')->get();
            $data['title'] = "Create User";
            return view('users.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_user(Request $request, $id)
    {
        try {
            if ($_POST) {
                $rules = array(
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'role' => ['required'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id],
                );

                $validator = Validator::make($request->all(), $rules);
                // $validator->setAttributeNames($fieldNames);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                $user = User::find($request->id);
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->roles = $request->role;
                $user->save();
                send_notification('Updated a user data', $user->first_name, $user->last_name);
                Session::flash(__('success'), __('User updated successfully'));
                return redirect()->route('home');
            }
            $data['mode'] = "edit";
            $data['roles'] = Role::where('name', '!=', 'Admin')->get();
            $data['user'] = User::where('id', $id)->with('user_role')->first();
            $data['title'] = "Edit User";
            return view('users.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function delete_user($id)
    {
        try {
            //code...
            if (!in_array(1, Auth::user()->roles)) {
                Session::flash('permission_warning', __('You no not have access to delete this record'));
                return back();
            }
            $user = User::find($id);
            if ($user->role == 1) {
                Session::flash('permission_warning', __('The Admin can not be deleted'));
                return back();
            }
            $user->delete();
            send_notification('Updated a user data', $user->first_name, $user->last_name);
            Session::flash(__('success'), __('User Deleted successfully'));
            return redirect()->route('home');
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function employees()
    {
        $data['title'] = "Employees";
        $data['sn'] = 1;
        $data['employees'] = Employee::orderBy('id', 'desc')->get();
        return view('employees.index', $data);
    }

    public function view_employee($id)
    {
        $data['employee'] = $employee = Employee::find($id);
        if (!isset($employee)) {
            Session::flash('warning', __('Employee not found'));
            return redirect()->route('employees');
        }
        $data['mode'] = $employee->first_name . " " . $employee->last_name . " Data";
        return view('employees.view', $data);
    }

    public function employee_salary($id)
    {
        $data['sn'] = 1;
        $data['employee'] = $employee = Employee::find($id);
        if (!isset($employee)) {
            Session::flash('warning', __('Employee not found'));
            return redirect()->route('employees');
        }
        $data['salaries'] = Salary::where('employee_id', $employee->id)->orderBy('id', 'desc')->get();
        $data['title'] = $employee->first_name . " " . $employee->last_name . " Salary History";
        return view('employees.salary', $data);
    }

    public function add_salary(Request $request)
    {
        try {
            $data['employee'] = $employee = Employee::find($request->employee_id);
            //code...
            $rules = array(
                'salary_amount' => ['required', 'string', 'max:255'],
                'salary_start_date' => ['required', 'string', 'max:255'],
                'salary_end_date' => ['required', 'string', 'max:255'],
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Session::flash('warning', __('All fields are required'));
                if (isset($request->id)) {
                    # code...
                    return back()->withErrors($validator);
                }
                return back()->withErrors($validator)->withInput();
            }
            if ($request->id) {
                Salary::where(['employee_id' => $request->employee_id, 'id' => $request->id])->update([
                    'employee_id' => $request->employee_id,
                    'amount' => $request->salary_amount,
                    'start_date' => $request->salary_start_date,
                    'end_date' => $request->salary_end_date,
                ]);
                send_notification(__('Updated salary for employee'), $employee->first_name, $employee->last_name);

                Session::flash(__('success'), __('Salary Record Updated successfully'));
                return back();
            }

            Salary::create([
                'employee_id' => $request->employee_id,
                'amount' => $request->salary_amount,
                'start_date' => $request->salary_start_date,
                'end_date' => $request->salary_end_date,
            ]);
            send_notification(__('Created a new salary for employee'), $employee->first_name, $employee->last_name);

            Session::flash(__('success'), __('Salary added successfully'));
            return back();
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function employee_record($id)
    {
        $data['sn'] = 1;
        $data['employee'] = $employee = Employee::find($id);
        if (!isset($employee)) {
            Session::flash('warning', 'Employee not found');
            return redirect()->route('employees');
        }
        $data['records'] = Record::where('employee_id', $employee->id)->orderBy('id', 'desc')->get();
        $data['title'] = $employee->first_name . " " . $employee->last_name . " Records";
        return view('employees.record', $data);
    }

    public function add_record(Request $request)
    {
        try {
            $data['employee'] = $employee = Employee::find($request->employee_id);
            //code...
            $rules = array(
                'date' => ['required'],
                'reason' => ['required'],
                'details' => ['required', 'string', 'max:255'],
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Session::flash('warning', __('All fields are required'));
                if (isset($request->id)) {
                    # code...
                    return back()->withErrors($validator);
                }
                return back()->withErrors($validator)->withInput();
            }
            if ($request->id) {
                Record::where(['employee_id' => $request->employee_id, 'id' => $request->id])->update([
                    'employee_id' => $request->employee_id,
                    'date' => $request->date,
                    'reason' => $request->reason,
                    'details' => $request->details,
                ]);
                send_notification('Updated record for employee', $employee->first_name, $employee->last_name);

                Session::flash(__('success'), __('Record Updated successfully'));
                return back();
            }

            Record::create([
                'employee_id' => $request->employee_id,
                'date' => $request->date,
                'reason' => $request->reason,
                'details' => $request->details,
            ]);
            send_notification('Created a new record for employee', $employee->first_name, $employee->last_name);

            Session::flash(__('success'), __('Record added successfully'));
            return back();
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function employee_payment($id)
    {
        $data['sn'] = 1;
        $data['employee'] = $employee = Employee::find($id);
        if (!isset($employee)) {
            Session::flash('warning', __('Employee not found'));
            return redirect()->route('employees');
        }
        $data['payments'] = Payment::where('employee_id', $employee->id)->orderBy('id', 'desc')->get();
        $data['title'] = $employee->first_name . " " . $employee->last_name . " Payments";
        return view('employees.payment', $data);
    }

    public function add_payment(Request $request)
    {
        try {
            $data['employee'] = $employee = Employee::find($request->employee_id);
            //code...
            $rules = array(
                'employee_id' => ['required'],
                'amount' => ['required'],
                'date' => ['required'],
                'details' => ['required', 'string', 'max:255'],
                'payment_method' => ['required', 'string', 'max:255'],
                'payment_proof' => ['max:15000'],
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Session::flash('warning', __('All fields are required'));
                if (isset($request->id)) {
                    # code...
                    return back()->withErrors($validator);
                }
                return back()->withErrors($validator)->withInput();
            }
            if ($request->id) {
                if ($request->hasFile('payment_proof')) {
                    $payment_proof = save_file($request->file('payment_proof'), "PAYMENT_PROOF");
                }
                $get_payment = Payment::where(['employee_id' => $employee->id, 'id' => $request->id])->first();
                $get_payment->employee_id = $employee->id;
                $get_payment->amount = $request->amount;
                $get_payment->date = $request->date;
                $get_payment->payment_method = $request->payment_method;
                $get_payment->details = $request->details;
                $get_payment->payment_proof = $payment_proof ?? $get_payment->payment_proof;
                $get_payment->save();
                send_notification('Updated payment for employee', $employee->first_name, $employee->last_name);

                Session::flash('success', __("Payment Updated successfully"));
                return back();
            }

            if ($request->hasFile('payment_proof')) {
                $payment_proof = save_file($request->file('payment_proof'), "PAYMENT_PROOF");
            }

            Payment::create([
                'employee_id' => $request->employee_id,
                'amount' => $request->amount,
                'date' => $request->date,
                'payment_method' => $request->payment_method,
                'details' => $request->details,
                'payment_proof' => $payment_proof ?? '',
            ]);
            send_notification('Created a new payment for employee', $employee->first_name, $employee->last_name);

            Session::flash('success', __('Payment added successfully'));
            return back();
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function employee_absence($id)
    {
        $data['sn'] = 1;
        $data['employee'] = $employee = Employee::find($id);
        if (!isset($employee)) {
            Session::flash('warning', 'Employee not found');
            return redirect()->route('employees');
        }
        $data['absences'] = Absence::where('employee_id', $employee->id)->orderBy('id', 'desc')->get();
        $data['title'] = $employee->first_name . " " . $employee->last_name . " absences";
        return view('employees.absence', $data);
    }

    public function add_absence(Request $request)
    {
        try {
            $data['employee'] = $employee = Employee::find($request->employee_id);
            //code...
            $rules = array(
                'start_date' => ['required'],
                'return_date' => ['required'],
                'reason' => ['required'],
                'comment' => ['required', 'string', 'max:255'],
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Session::flash('warning', __('All fields are required'));
                $total_to_be_cut = 0;
                if ($request->reason == "Absence") {
                $total_to_be_cut = $request->total_to_be_cut;
                }
                $total_to_be_cut;

                if (isset($request->id)) {
                    # code...
                    return back()->withErrors($validator);
                }
                return back()->withErrors($validator)->withInput();
            }
            if ($request->id) {
                Absence::where(['employee_id' => $request->employee_id, 'id' => $request->id])->update([
                    'employee_id' => $request->employee_id,
                    'start_date' => $request->start_date,
                    'return_date' => $request->return_date,
                    'reason' => $request->reason,
                    'total_number_of_days' => $request->total_number_of_days,
                    'total_to_be_cut' => $request->total_to_be_cut,
                    'comment' => $request->comment,
                ]);
                send_notification('Updated record for absence', $employee->first_name, $employee->last_name);

                Session::flash(__('success'), __('Absence Updated successfully'));
                return back();
            }

            Absence::create([
                'employee_id' => $request->employee_id,
                'start_date' => $request->start_date,
                'return_date' => $request->return_date,
                'reason' => $request->reason,
                'total_number_of_days' => $request->total_number_of_days,
                'total_to_be_cut' => $request->total_to_be_cut,
                'comment' => $request->comment,
            ]);
            send_notification('Created an absence record', $employee->first_name, $employee->last_name);

            Session::flash(__('success'), __('Absence added successfully'));
            return back();
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_employee(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['employee'] = $employee = Employee::find($id);
            if (!isset($employee)) {
                Session::flash('warning', __('Employee not found'));
                return redirect()->route('employees');
            }
            if ($_POST) {
                $rules = array(
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:employees,email,' . $employee->id],
                    'employee_id' => ['required', 'string', 'max:255'],
                    'hiring_date' => ['required', 'string', 'max:255'],
                    // 'end_date' => ['required', 'string', 'max:255'],
                    'CIN' => ['required', 'string', 'max:255'],
                    'CIN_proof' => ['exclude_if:CIN_proof,null', 'max:15000'],
                    'cell_1' => ['required', 'string', 'max:255'],
                    // 'cell_2' => ['required', 'string', 'max:255'],
                    'address' => ['required', 'string'],
                    'contact_full_name' => ['required', 'string', 'max:255'],
                    'contact_1_cell' => ['required', 'string', 'max:255'],
                    'contact_1_cell2' => ['required', 'string', 'max:255'],
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                if ($request->hasFile('CIN_proof')) {
                    $CIN_proof = save_file($request->file('CIN_proof'), "CIN_PROOF");
                }


                Employee::where('id', $request->id)->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'employee_id' => $request->employee_id,
                    'hiring_date' => $request->hiring_date,
                    'end_date' => $request->end_date,
                    'CIN' => $request->CIN,
                    'CIN_proof' => $CIN_proof ?? $employee->CIN_proof,
                    'cell_1' => $request->cell_1,
                    'cell_2' => $request->cell_2,
                    'address' => $request->address,
                    'contact_full_name' => $request->contact_full_name,
                    'contact_1_cell' => $request->contact_1_cell,
                    'contact_1_cell2' => $request->contact_1_cell2
                ]);

                send_notification('Updated an employee data', $employee->first_name, $employee->last_name);
                Session::flash(__('success'), __('Employee data updated successfully'));
                return redirect()->route('employees');
            }
            $data['title'] = "Edit Employee";
            return view('employees.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function create_employee(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            if ($_POST) {
                $rules = array(
                    'first_name' => ['required', 'string', 'max:255'],
                    'last_name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
                    'employee_id' => ['required', 'string', 'max:255'],
                    'hiring_date' => ['required', 'string', 'max:255'],
                    // 'end_date' => ['required', 'string', 'max:255'],
                    'CIN' => ['required', 'string', 'max:255'],
                    'CIN_proof' => ['required', 'max:15000'],
                    'cell_1' => ['required', 'string', 'max:255'],
                    // 'cell_2' => ['required', 'string', 'max:255'],
                    'address' => ['required', 'string'],
                    'contact_full_name' => ['required', 'string', 'max:255'],
                    'contact_1_cell' => ['required', 'string', 'max:255'],
                    'contact_1_cell2' => ['required', 'string', 'max:255'],
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                if ($request->hasFile('CIN_proof')) {
                    $CIN_proof = save_file($request->file('CIN_proof'), "CIN_PROOF");
                }

                Employee::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'employee_id' => $request->employee_id,
                    'hiring_date' => $request->hiring_date,
                    'end_date' => $request->end_date,
                    'CIN' => $request->CIN,
                    'CIN_proof' => $CIN_proof ?? "",
                    'cell_1' => $request->cell_1,
                    'cell_2' => $request->cell_2,
                    'address' => $request->address,
                    'contact_full_name' => $request->contact_full_name,
                    'contact_1_cell' => $request->contact_1_cell,
                    'contact_1_cell2' => $request->contact_1_cell2
                ]);
                send_notification(__('Created a new Employee'), $request->first_name, $request->last_name);

                Session::flash(__('success'), __('Employee created successfully'));
                return redirect()->route('employees');
            }

            $data['title'] = "Create New Employee";
            return view('employees.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            // Session::flash('error', "An error occur try again");
            return back();
        }
    }


    public function farms()
    {
        $data['title'] = "Farms";
        $data['sn'] = 1;
        $data['farms'] = Farm::orderBy('id', 'desc')->get();
        return view('farms.index', $data);
    }

    public function create_farm(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            if ($_POST) {
                $rules = array(
                    'farm_name' => ['required', 'string', 'max:255', 'unique:farms'],
                    'farm_desc' => ['required', 'string', 'max:255'],
                    'acquisition_date' => ['required', 'string', 'max:255'],
                    'surface' => ['required', 'string', 'max:255'],
                    'amount' => ['required', 'string'],
                    'latitude' => ['required', 'string'],
                    'longitude' => ['required', 'string'],
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Farm::create([
                    'farm_name' => $request->farm_name,
                    'farm_desc' => $request->farm_desc,
                    'acquisition_date' => $request->acquisition_date,
                    'surface' => $request->surface,
                    'amount' => $request->amount,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude
                ]);
                send_notification(__('Created a new farm data'), $request->farm_name);


                Session::flash(__('success'), __('Farm created successfully'));
                return redirect()->route('farms');
            }

            $data['title'] = "Create New Farm";
            return view('farms.create', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "An error occur try again");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_farm(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['farm'] = $farm = Farm::find($id);
            if (!isset($farm)) {
                Session::flash('warning', __('Farm not found'));
                return redirect()->route('farms');
            }
            if ($_POST) {

                $rules = array(
                    'farm_name' => ['required', 'string', 'max:255', 'unique:farms,farm_name,' . $request->id],
                    'farm_desc' => ['required', 'string', 'max:255'],
                    'acquisition_date' => ['required', 'string', 'max:255'],
                    'surface' => ['required', 'string', 'max:255'],
                    'amount' => ['required', 'string'],
                    'latitude' => ['required', 'string'],
                    'longitude' => ['required', 'string'],
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Farm::where('id', $request->id)->update([
                    'farm_name' => $request->farm_name,
                    'farm_desc' => $request->farm_desc,
                    'acquisition_date' => $request->acquisition_date,
                    'surface' => $request->surface,
                    'amount' => $request->amount,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude
                ]);
                send_notification('Updated a farm data', $request->farm_name);

                Session::flash(__('success'), __('Farm data updated successfully'));
                return redirect()->route('farms');
            }
            $data['title'] = "Edit Farm";
            return view('farms.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', "Try again!");
            return back();
        }
    }

    public function trees()
    {
        try {
            //code...
            $data['title'] = "Trees";
            $data['sn'] = 1;
            $data['trees'] = Tree::with('farm:id,farm_name')->orderBy('id', 'desc')->get();
            return view('trees.index', $data);
        } catch (\Throwable $th) {
            Session::flash('error', __('Try again!'));
            return back();
        }
    }

    public function create_tree(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            $data['farms'] = $f = Farm::orderBy('id', 'desc')->get();
            if ($_POST) {
                $rules = array(
                    'farm_id' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string', 'max:255'],
                    'reason' => ['required', 'string', 'max:255'],
                    'quantity' => ['required', 'string', 'max:255'],
                    'date_planted' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Tree::create([
                    'farm_id' => $request->farm_id,
                    'desc' => $request->desc,
                    'reason' => $request->reason,
                    'quantity' => $request->quantity,
                    'date_planted' => $request->date_planted
                ]);

                send_notification('Created a new Tree data');

                Session::flash(__('success'), __('Tree created successfully'));
                return redirect()->route('trees');
            }

            $data['title'] = "Create New Tree";
            return view('trees.create', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "An error occur try again");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_tree(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['tree'] = $tree = Tree::find($id);
            $data['farms'] = Farm::orderBy('id', 'desc')->get();
            if (!isset($tree)) {
                Session::flash('warning', __('Tree not found'));
                return redirect()->route('trees');
            }
            if ($_POST) {

                $rules = array(
                    'farm_id' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string', 'max:255'],
                    'reason' => ['required', 'string', 'max:255'],
                    'quantity' => ['required', 'string', 'max:255'],
                    'date_planted' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Tree::where('id', $request->id)->update([
                    'farm_id' => $request->farm_id,
                    'desc' => $request->desc,
                    'reason' => $request->reason,
                    'quantity' => $request->quantity,
                    'date_planted' => $request->date_planted
                ]);
                send_notification('Updated Tree data');

                Session::flash(__('success'), __('Tree data updated successfully'));
                return redirect()->route('trees');
            }
            $data['title'] = "Edit Tree";
            return view('trees.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function crops()
    {
        try {
            //code...
            $data['title'] = "Crops";
            $data['sn'] = 1;
            $data['crops'] = Crop::with('farm:id,farm_name')->orderBy('id', 'desc')->get();
            return view('crop.index', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            // Session::flash('error', "Try again!");
            return back();
        }
    }

    public function create_crop(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            $data['farms'] = $f = Farm::orderBy('id', 'desc')->get();
            $data['trees'] = Tree::orderBy('id','desc')->get();
            $new_array = [];
            $data['trees'] = $data['trees']->groupBy(['desc', function ($item) {
            return $item['desc'];
        }], preserveKeys: true);

        foreach ($data['trees'] as $key => $value) {
            # code...
            $data['trees'] = $value[$key];
            $obj = (object)[
                "name" => $key,
            ];
            array_push($new_array, $obj);
        }
        $data['trees'] = $new_array;
        //dd($new_array);

            if ($_POST) {
                $rules = array(
                    'farm_id' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string', 'max:255'],
                    'type_of_crop' => ['required', 'string', 'max:255'],
                    'quantity' => ['required', 'string', 'max:255'],
                    'weight' => ['required', 'string', 'max:255'],
                    'date' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Crop::create([
                    'farm_id' => $request->farm_id,
                    'desc' => $request->desc,
                    'type_of_crop' => $request->type_of_crop,
                    'quantity' => $request->quantity,
                    'weight' => $request->weight,
                    'date' => $request->date
                ]);

                send_notification(__('Created a new Crop data'));

                Session::flash(__('success'), __('Crop created successfully'));
                return redirect()->route('crops');
            }

            $data['title'] = "Create New Crop";
            return view('crop.create', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "An error occur try again");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_crop(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['crop'] = $crop = Crop::find($id);
            $data['farms'] = Farm::orderBy('id', 'desc')->get();
            $data['trees'] = Tree::orderBy('id', 'desc')->get();
            if (!isset($crop)) {
                Session::flash('warning', 'Crop not found');
                return redirect()->route('crops');
            }
            if ($_POST) {


                $rules = array(
                    'farm_id' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string', 'max:255'],
                    'type_of_crop' => ['required', 'string', 'max:255'],
                    'quantity' => ['required', 'string', 'max:255'],
                    'weight' => ['required', 'string', 'max:255'],
                    'date' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Crop::where('id', $request->id)->update([
                    'farm_id' => $request->farm_id,
                    'desc' => $request->desc,
                    'type_of_crop' => $request->type_of_crop,
                    'quantity' => $request->quantity,
                    'weight' => $request->weight,
                    'date' => $request->date
                ]);
                send_notification('Updated a Crop data');

                Session::flash(__('success'), __('Crop data updated successfully'));
                return redirect()->route('crops');
            }
            $data['title'] = "Update Crop Data";
            return view('crop.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function clients()
    {
        try {
            //code...
            $data['title'] = "Clents";
            $data['sn'] = 1;
            $data['clients'] = Client::with('employee:id,first_name,last_name')->orderBy('id', 'desc')->get();
            return view('clients.index', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "Try again!");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function create_client(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            $data['employees'] = Employee::orderBy('first_name', 'asc')->get(['id', 'first_name', 'last_name']);
            if ($_POST) {
                $rules = array(
                    'client_name' => ['required', 'string', 'max:255'],
                    'full_address' => ['required', 'string', 'max:255'],
                    'contact_full_name' => ['required', 'string', 'max:255'],
                    'contact_phone' => ['required', 'string', 'max:255'],
                    'contact_email' => ['required', 'string', 'max:255'],
                    'date_become_client' => ['required', 'string', 'max:255'],
                    'referred_by' => ['required', 'string', 'max:255'],
                    'employee' => ['required_if:referred_by,==,employee'],
                    'note' => ['required_if:referred_by,==,other'],
                );

                $customMessages = [
                    'note.required_if' => 'The :attribute field is required.',
                    'employee.required_if' => 'The :attribute field is required.',
                ];

                $validator = Validator::make($request->all(), $rules, $customMessages);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Client::create([
                    'client_name' => $request->client_name,
                    'full_address' => $request->full_address,
                    'contact_full_name' => $request->contact_full_name,
                    'contact_phone' => $request->contact_phone,
                    'contact_email' => $request->contact_email,
                    'date_become_client' => $request->date_become_client,
                    'referred_by' => $request->referred_by,
                    'employee_id' => $request->employee,
                    'note' => $request->note ?? null,
                ]);


                send_notification('Created a new client data', $request->client_name);

                Session::flash(__('success'), __('Client created successfully'));
                return redirect()->route('clients');
            }

            $data['title'] = "Create New Client";
            return view('clients.create', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "An error occur try again");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_client(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['client'] = $client = Client::find($id);
            $data['employees'] = Employee::orderBy('first_name', 'asc')->get(['id', 'first_name', 'last_name']);
            if (!isset($client)) {
                Session::flash('warning', __('Client not found'));
                return redirect()->route('clients');
            }
            if ($_POST) {
                $rules = array(
                    'client_name' => ['required', 'string', 'max:255'],
                    'full_address' => ['required', 'string', 'max:255'],
                    'contact_full_name' => ['required', 'string', 'max:255'],
                    'contact_phone' => ['required', 'string', 'max:255'],
                    'contact_email' => ['required', 'string', 'max:255'],
                    'date_become_client' => ['required', 'string', 'max:255'],
                    'referred_by' => ['required', 'string', 'max:255'],
                    'employee' => ['required_if:referred_by,==,employee'],
                    'note' => ['required_if:referred_by,==,other'],
                );

                $customMessages = [
                    'note.required_if' => 'The :attribute field is required.',
                    'employee.required_if' => 'The :attribute field is required.',
                ];

                $validator = Validator::make($request->all(), $rules, $customMessages);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                Client::where('id', $request->id)->update([
                    'client_name' => $request->client_name,
                    'full_address' => $request->full_address,
                    'contact_full_name' => $request->contact_full_name,
                    'contact_phone' => $request->contact_phone,
                    'contact_email' => $request->contact_email,
                    'date_become_client' => $request->date_become_client,
                    'referred_by' => $request->referred_by,
                    'employee_id' => $request->employee ?? $client->employee_id,
                    'note' => $request->note ?? $client->note,
                ]);
                send_notification('Updated a client data', $request->client_name);

                Session::flash(__('success'), __('Client data updated successfully'));
                return redirect()->route('clients');
            }
            $data['title'] = "Edit Client";
            return view('clients.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function expenses()
    {
        try {
            //code...
            $data['title'] = "Expenses";
            $data['sn'] = 1;
            $data['expenses'] = Expense::with(['employee:id,first_name,last_name', 'farm:id,farm_name'])->orderBy('id', 'desc')->get();
            return view('expenses.index', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "Try again!");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function create_expense(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            $data['employees'] = Employee::orderBy('first_name', 'asc')->get(['id', 'first_name', 'last_name']);
            $data['farms'] = Farm::orderBy('farm_name', 'asc')->get(['id', 'farm_name']);
            if ($_POST) {
                $rules = array(
                    'date' => ['required', 'string'],
                    'desc' => ['required', 'string'],
                    'amount' => ['required', 'string'],
                    'farm' => ['required', 'string'],
                    'employee' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }


                Expense::create([
                    'date' => $request->date,
                    'desc' => $request->desc,
                    'amount' => $request->amount,
                    'farm_id' => $request->farm,
                    'employee_id' => $request->employee,
                ]);

                send_notification('Created a new expense data');
                Session::flash(__('success'), __('Expense created successfully'));
                return redirect()->route('expenses');
            }

            $data['title'] = "Create New Expenses";
            return view('expenses.create', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "An error occur try again");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_expense(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['expense'] = $expense = Expense::find($id);
            $data['employees'] = Employee::orderBy('first_name', 'asc')->get(['id', 'first_name', 'last_name']);
            $data['farms'] = Farm::orderBy('farm_name', 'asc')->get(['id', 'farm_name']);
            if (!isset($expense)) {
                Session::flash('warning', __('Expense not found'));
                return redirect()->route('expenses');
            }
            if ($_POST) {
                $rules = array(
                    'date' => ['required', 'string'],
                    'desc' => ['required', 'string'],
                    'amount' => ['required', 'string'],
                    'farm' => ['required', 'string'],
                    'employee' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                Expense::where('id', $request->id)->update([
                    'date' => $request->date,
                    'desc' => $request->desc,
                    'amount' => $request->amount,
                    'farm_id' => $request->farm,
                    'employee_id' => $request->employee,
                ]);
                send_notification('Updated an expense data');

                Session::flash(__('success'), __('Expense data updated successfully'));
                return redirect()->route('expenses');
            }
            $data['title'] = "Edit Expense";
            return view('expenses.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function invoices()
    {
        try {
            //code...
            $data['title'] = "Invoices";
            $data['sn'] = 1;
            $data['invoices'] = Invoice::with(['farm:id,farm_name', 'client:id,client_name', 'crop:*'])->orderBy('id', 'desc')->get();
            return view('invoices.index', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "Try again!");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function create_invoice(Request $request)
    {
        try {
            //code...
            $data['mode'] = "create";
            $data['clients'] = Client::orderBy('client_name', 'asc')->get(['id', 'client_name']);
            $data['farms'] = Farm::orderBy('farm_name', 'asc')->get(['id', 'farm_name']);
            $data['crops'] = Crop::orderBy('id', 'desc')->get();
            $data['employees'] = Employee::orderBy('first_name', 'asc')->get(['id', 'first_name', 'last_name']);
            if ($_POST) {
                $rules = array(
                    'client_name' => ['required', 'string', 'max:255'],
                    'date' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string'],
                    'quantity' => ['required', 'string'],
                    'unit_price' => ['required', 'string'],
                    'discount' => ['required', 'string'],
                    'crop' => ['required', 'string'],
                    'farm' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    return back()->withErrors($validator)->withInput();
                }

                Invoice::create([
                    'client_id' => $request->client_name,
                    'date' => $request->date,
                    'desc' => $request->desc,
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                    'total_price_before_discount' => $request->quantity * $request->unit_price,
                    'discount' => $request->discount,
                    'total_price_after_discount' => ($request->quantity * $request->unit_price) - $request->discount,
                    'crop_id' => $request->crop,
                    'farm_id' => $request->farm,
                ]);

                send_notification('Created a new invoice data');
                Session::flash(__('success'), __('Invoice created successfully'));
                return redirect()->route('invoices');
            }

            $data['title'] = "Create New Invoice";
            return view('invoices.create', $data);
        } catch (\Throwable $th) {
            // Session::flash('error', "An error occur try again");
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function edit_invoice(Request $request, $id)
    {
        try {
            $data['mode'] = "edit";
            $data['clients'] = Client::orderBy('client_name', 'asc')->get(['id', 'client_name']);
            $data['crops'] = Crop::orderBy('id', 'desc')->get();
            $data['farms'] = Farm::orderBy('farm_name', 'asc')->get(['id', 'farm_name']);
            $data['invoice'] = $invoice = Invoice::where('id', $id)->with(['farm:id,farm_name', 'client:id,client_name'])->first();
            if (!isset($invoice)) {
                Session::flash('warning', __('Invoice not found'));
                return redirect()->route('clients');
            }
            if ($_POST) {
                $rules = array(
                    'client_name' => ['required', 'string', 'max:255'],
                    'date' => ['required', 'string', 'max:255'],
                    'desc' => ['required', 'string'],
                    'quantity' => ['required', 'string'],
                    'unit_price' => ['required', 'string'],
                    'discount' => ['required', 'string'],
                    'crop' => ['required', 'string'],
                    'farm' => ['required', 'string']
                );

                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    Session::flash('warning', __('All fields are required'));
                    dd($request->all());
                    return back()->withErrors($validator)->withInput();
                }

                Invoice::where('id', $request->id)->update([
                    'client_id' => $request->client_name,
                    'date' => $request->date,
                    'desc' => $request->desc,
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                    'total_price_before_discount' => $request->quantity * $request->unit_price,
                    'discount' => $request->discount,
                    'total_price_after_discount' => ($request->quantity * $request->unit_price) - $request->discount,
                    'crop_id' => $request->crop,
                    'farm_id' => $request->farm,
                ]);

                send_notification('Updated a invoice data', $invoice->client->client_name);

                Session::flash(__('success'), __('Invoice data updated successfully'));
                return redirect()->route('invoices');
            }
            $data['title'] = "Edit Invoice";
            return view('invoices.create', $data);
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
            return back();
        }
    }

    public function get_farm_crop(Request $request)
    {
        # code...
        $crop = Crop::where('id', $request->crop_id)->with('farm:id,farm_name')->first();
        $data = array(
            'farm_id' => $crop->farm->id,
            'farm_name' => $crop->farm->farm_name,
            'status' => true
        );
        return $data;
    }

    public function delete_notification(Request $request)
    {
        # code...
        $Notification = Auth::user()->Notifications->find($request->not_id);
        if ($Notification) {
            $Notification->markAsRead();
        }
        // $data = array(
        //     'data' => $Notification,
        //     'request' => $request
        // );
        return true;
    }

    public function delete_all_notification()
    {
        # code...
        $user = Auth::user();
        $user->unreadNotifications()->update(['read_at' => now()]);
        return back();
    }
}