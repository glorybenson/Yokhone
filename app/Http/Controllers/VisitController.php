<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Visit;
use App\Models\Inventory;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
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
        $data['title'] = "Visit";
        $data['sn'] = 1;
        $data['visit_array'] = Visit::where('inventory_id', $id)->get();
        return view('inventory.tabs.visit', $data);
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
            
            'date_of_visit' => ['required', 'string', 'max:255'],
            'visit_expiration' => ['required', 'string', 'max:255'],
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
            $data['visit'] = $visit = Visit::where([$request->inventory_id => 'inventory_id', $request->id =>  'id']);
            if (!$visit) {
                Session::flash(__('warning'), __('No Technical Visit found for the ID'));
                return redirect()->back();
            }

            Visit::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->update([
                
                'date_of_visit' => $request->date_of_visit,
                'visit_expiration' => $request->visit_expiration
            ]);

            send_notification(__('Updated a Technical Visit'), $request->date_of_visit);

            Session::flash(__('success'), __('Technical Visit updated successfully'));
            return redirect()->route('visit.index', $request->inventory_id);
        //
    }

    Visit::create([
        'inventory_id' => $request->inventory_id,
        'date_of_visit' => $request->date_of_visit,
        'visit_expiration' => $request->visit_expiration
    ]);

    send_notification(__('Created a new Technical Visit'), $request->date_of_visit);

        Session::flash(__('success'), __('Technical Visit created successfully'));
        return redirect()->route('visit.index', $request->inventory_id);
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
        $visit = Visit::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->get();
        if (!$visit) {
            Session::flash(__('warning'), __('No Inventory found for the ID'));
            return redirect()->back();
        }
        Visit::where(['inventory_id' => $request->inventory_id, 'id' => $request->id])->delete();
        Session::flash(__('success'), __("Deleted successfully"));
        return redirect()->back();
        //
    }
}
