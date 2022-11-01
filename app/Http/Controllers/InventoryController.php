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
use App\Models\Inventory;
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

class InventoryController extends Controller
{
    //
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = "Inventory";
        $data['sn'] = 1;
        $data['inventories'] = Inventory::all();
        return view('inventory.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        try {
            //code...
            $data['title'] = "Create New Inventory";
            $data['employees'] = Employee::all();
            return view('inventory.create', $data);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
            'immatriculation_number' => ['required', 'string', 'max:255'],
            'date_of_acquisition' => ['required', 'string', 'max:255'],
            'acquisition_cost' => ['required', 'string', 'max:255'],
            'millage_on_acquisition' => ['required', 'string', 'max:255'],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serie' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255']
        );

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('warning', __('All fields are required'));
            return back()->withErrors($validator)->withInput();
        }

        Inventory::create([
            'immatriculation_number' => $request->immatriculation_number,
            'date_of_acquisition' => $request->date_of_acquisition,
            'acquisition_cost' => $request->acquisition_cost,
            'millage_on_acquisition' => $request->millage_on_acquisition,
            'make' => $request->make,
            'model' => $request->model,
            'serie' => $request->serie,
            'year' => $request->year
        ]);

        send_notification(__('Created a new Inventory'), $request->immatriculation_number);

        Session::flash(__('success'), __('Inventory created successfully'));
        return redirect()->route('inventory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->route('inventory.index');
        }
        $data['title'] = "View Inventory";
        $data['inventory'] = Inventory::find($id);
        return view('inventory.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->route('inventory.index');
        }
        $data['title'] = "Edit Inventory";
        $data['inventory'] = Inventory::find($id);
        return view('inventory.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'immatriculation_number' => ['required', 'string', 'max:255'],
            'date_of_acquisition' => ['required', 'string', 'max:255'],
            'acquisition_cost' => ['required', 'string', 'max:255'],
            'millage_on_acquisition' => ['required', 'string', 'max:255'],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serie' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:255'],
        );

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('warning', __('All fields are required'));
            return back()->withErrors($validator)->withInput();
        }

        $inventory = Inventory::find($id);
        if (!$inventory) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->route('inventory.index');
        }

        Inventory::where('id', $id)->update([
            'immatriculation_number' => $request->immatriculation_number,
            'date_of_acquisition' => $request->date_of_acquisition,
            'acquisition_cost' => $request->acquisition_cost,
            'millage_on_acquisition' => $request->millage_on_acquisition,
            'make' => $request->make,
            'model' => $request->model,
            'serie' => $request->serie,
            'year' => $request->year
        ]);

        send_notification('Updated an Inventory data', $request->immatriculation_number);
        Session::flash(__('success'), __('Inventory data updated successfully'));
        return redirect()->route('inventory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        if (!$inventory) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->route('inventory.index');
        }
        Inventory::find($id)->delete();
        Session::flash(__('success'), __("Deleted successfully"));
        return redirect()->route('inventory.index');
    }
}