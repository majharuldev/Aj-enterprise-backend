<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    // public function index()
    // {

    //     // method 1
    //     // $trips = trip::where('user_id', Auth::id())->latest()->get();
    //     // return response()->json($trips);



    //     // method 2
    //     $user = Auth::user();


    //     if ($user->role === 'admin' || $user->role === 'super') {
    //         $trips = Trip::latest();
    //     } else {
    //         $trips = Trip::where('user_id', $user->id)
    //             ->latest();
    //     }

    //    return response()->json($trips);
    // }

public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin' || $user->role === 'super') {
        $trips = Trip::latest()->get();
    } else {
        $trips = Trip::where('user_id', $user->id)
                     ->latest()
                     ->get();
    }

    return response()->json($trips);
}


    public function store(Request $request)
    {
       

        $trip = trip::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'load_point' => $request->load_point,
            'unload_point' => $request->unload_point,
            'vehicle_no' => $request->vehicle_no,
            'driver_name' => $request->driver_name,
            'fuel_cost' => $request->fuel_cost,
            'toll_cost' => $request->toll_cost,
            'police_cost' => $request->police_cost,
            'commision' => $request->commision,
            'labour' => $request->labour,
            'others' => $request->others,
            'total_exp' => $request->total_exp,
            'demrage_day' => $request->demrage_day,
            'demrage_rate' => $request->demrage_rate,
            'demrage_total' => $request->demrage_total,
            'customer_name' => $request->customer_name,
            'customer_mobile' => $request->customer_mobile,
            'Rent_amount' => $request->Rent_amount,
            'advanced' => $request->advanced,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Trip Expense created successfully',
            'data' => $trip
        ]);
    }

    public function show($id)
    {
        $trip = trip::where('user_id', Auth::id())->find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }
        return response()->json($trip);
    }

    public function update(Request $request, $id)
    {
        $trip = trip::where('user_id', Auth::id())->find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $trip->update($request->all());
        return response()->json(['message' => 'Trip updated successfully', 'data' => $trip]);
    }

    public function destroy($id)
    {
        $trip = trip::where('user_id', Auth::id())->find($id);
        if (!$trip) {
            return response()->json(['message' => 'Trip not found'], 404);
        }

        $trip->delete();
        return response()->json(['message' => 'Trip deleted successfully']);
    }
}
