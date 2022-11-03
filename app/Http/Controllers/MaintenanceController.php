<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Maintenance;
use App\Models\Inventory;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MaintenanceController extends Controller
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
    public function index($id)
    {
        $data['inventory'] = $inventory = Inventory::find($id);
        if (!$inventory) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->back();
        }
        $data['title'] = "Maintenance";
        $data['sn'] = 1;
        $data['maintenance_array'] = Maintenance::where('inventory_id', $id)->get();
        return view('inventory.tabs.maintenance', $data);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        //
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
            'date_maintenance' => ['required', 'string', 'max:255'],           
            'reason' => ['required', 'string', 'max:255'],
            'amount_paid' => ['required', 'string', 'max:255'],
            'diagnostics' => ['required', 'string', 'max:255'],
        );

        $messages = [];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('warning', __('All fields are required'));
            return back()->withErrors($validator)->withInput();
        }

        $data['inventory'] = $inventory = Inventory::find($request->inventory_id);
        if (!$inventory) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->back();
        }

        if ($request->id) {
            $data['maintenance'] = $maintenance = Maintenance::where([$request->inventory_id => 'inventory_id', $request->id =>  'id']);
            if (!$maintenance) {
                Session::flash(__('warning'), __('No maintenance found for the ID'));
                return redirect()->back();
            }

            Maintenance::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->update([
                'date_maintenance' => $request->date_maintenance,
                'reason' => $request->reason,
                'amount_paid' => $request->amount_paid,
                'diagnostics' => $request->diagnostics
            ]);

            send_notification(__('Updated an maintenance'), $request->date_maintenance);

            Session::flash(__('success'), __('maintenance updated successfully'));
            return redirect()->route('maintenance.index', $request->inventory_id);
        }

        Maintenance::create([
            'inventory_id' => $request->inventory_id,            
            'date_maintenance' => $request->date_maintenance,
            'amount_paid' => $request->amount_paid,
            'reason' => $request->reason,
            'diagnostics' => $request->diagnostics
        ]);

        send_notification(__('Created a new Maintenance'), $request->date_maintenance);

        Session::flash(__('success'), __('Maintenance created successfully'));
        return redirect()->route('maintenance.index', $request->inventory_id);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $maintenance = Maintenance::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->get();
        if (!$maintenance) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->back();
        }
        Maintenance::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->delete();
        Session::flash(__('success'), __("Deleted successfully"));
        return redirect()->back();
        //
    }
}
