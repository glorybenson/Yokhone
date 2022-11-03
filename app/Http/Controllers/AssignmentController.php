<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Inventory;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
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
        $data['title'] = "Assignment";
        $data['sn'] = 1;
        $data['assignment_array'] = $a = Assignment::with('employee')->where('inventory_id', $id)->get();
        $data['employees'] = Employee::orderBy('id', 'desc')->get();
        return view('inventory.tabs.assignment', $data);
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
            'driver_id' => ['required', 'string', 'max:255'],
            'assigned_date' => ['required', 'string', 'max:255'],
            'revoked_date' => ['required', 'string', 'max:255'],
            'details_of_revokation' => ['required', 'string', 'max:255'],
        );

        $messages = [
            'driver_id.required' => __('The driver name is required')
        ];

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
            $data['assignment'] = $assignment = Assignment::where([$request->inventory_id => 'inventory_id', $request->id =>  'id']);
            if (!$assignment) {
                Session::flash(__('warning'), __('No Assignment found for the ID'));
                return redirect()->back();
            }

            Assignment::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->update([
                'driver_id' => $request->driver_id,
                'assigned_date' => $request->assigned_date,
                'revoked_date' => $request->revoked_date,
                'details_of_revokation' => $request->details_of_revokation
            ]);

            send_notification(__('Updated an Assignment'), $request->driver_id);

            Session::flash(__('success'), __('Assignment updated successfully'));
            return redirect()->route('assignment.index', $request->inventory_id);
        }

        Assignment::create([
            'inventory_id' => $request->inventory_id,
            'driver_id' => $request->driver_id,
            'assigned_date' => $request->assigned_date,
            'revoked_date' => $request->revoked_date,
            'details_of_revokation' => $request->details_of_revokation,
        ]);

        send_notification(__('Created a new Assignment'), $request->driver_id);

        Session::flash(__('success'), __('Assignment created successfully'));
        return redirect()->route('assignment.index', $request->inventory_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $insurance = Assignment::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->get();
        if (!$insurance) {
            Session::flash(__('warning'), __('No Assignment found for the ID'));
            return redirect()->back();
        }
        Assignment::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->delete();
        Session::flash(__('success'), __("Deleted successfully"));
        return redirect()->back();
    }
}