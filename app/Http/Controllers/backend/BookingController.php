<?php

namespace App\Http\Controllers\backend;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $allCustomers=Customer::all();
        return view('backend.layouts.booking.create',compact('allCustomers'));
    }


    public function availableRooms(Request $request,$checkinDate){
        $aroom=DB::SELECT("SELECT * FROM rooms WHERE id NOT IN (SELECT room_id FROM bookings WHERE 
        '$checkinDate' BETWEEN checkin AND checkout )");
        return response()->json(['data'=>$aroom]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'room_id' => 'required',
            'total_adults' => 'required',
            'total_children' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
           
            $booking = new Booking();
            $booking->customer_id = $request->customer_id;
            $booking->room_id     = $request->room_id;
            $booking->total_adults    = $request->total_adults;
            $booking->total_children   = $request->total_children;
            $booking->checkin  = $request->checkin;
            $booking->checkout     = $request->checkout;
            $status              = $booking->save();
            if ($status) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Room is booked successfully!',
                ]);
            }
        }
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
    public function destroy($id)
    {
        //
    }
}
