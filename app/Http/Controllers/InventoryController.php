<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Inventory;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

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
        } catch (\Throwable $th) {
            Session::flash('error', $th->getMessage());
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