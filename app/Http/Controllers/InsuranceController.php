<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Insurance;
use App\Models\Inventory;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
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
        $data['title'] = "Insurance";
        $data['sn'] = 1;
        $data['insurance_array'] = Insurance::where('inventory_id', $id)->get();
        return view('inventory.tabs.insurance', $data);
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
            'company_name' => ['required', 'string', 'max:255'],
            'date_started' => ['required', 'string', 'max:255'],
            'company_contact_name' => ['required', 'string', 'max:255'],
            'company_contact_tel_no' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'max:255'],
            'date_ending' => ['required', 'string', 'max:255'],
            'other_details' => ['required', 'string', 'max:255'],
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
            $data['insurance'] = $insurance = Insurance::where([$request->inventory_id => 'inventory_id', $request->id =>  'id']);
            if (!$insurance) {
                Session::flash(__('warning'), __('No Insurance found for the ID'));
                return redirect()->back();
            }

            Insurance::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->update([
                'company_name' => $request->company_name,
                'date_started' => $request->date_started,
                'date_ending' => $request->date_ending,
                'company_contact_name' => $request->company_contact_name,
                'company_contact_tel_no' => $request->company_contact_tel_no,
                'company_email' => $request->company_email,
                'other_details' => $request->other_details
            ]);

            send_notification(__('Updated an Insurance'), $request->company_name);

            Session::flash(__('success'), __('Insurance updated successfully'));
            return redirect()->route('insurance.index', $request->inventory_id);
        }

        Insurance::create([
            'inventory_id' => $request->inventory_id,
            'company_name' => $request->company_name,
            'date_started' => $request->date_started,
            'date_ending' => $request->date_ending,
            'company_contact_name' => $request->company_contact_name,
            'company_contact_tel_no' => $request->company_contact_tel_no,
            'company_email' => $request->company_email,
            'other_details' => $request->other_details
        ]);

        send_notification(__('Created a new Insurance'), $request->company_name);

        Session::flash(__('success'), __('Insurance created successfully'));
        return redirect()->route('insurance.index', $request->inventory_id);
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
        $insurance = Insurance::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->get();
        if (!$insurance) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->back();
        }
        Insurance::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->delete();
        Session::flash(__('success'), __("Deleted successfully"));
        return redirect()->back();
    }
}