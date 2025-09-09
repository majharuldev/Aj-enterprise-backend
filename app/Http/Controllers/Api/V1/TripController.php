<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\trip;
use App\Models\DriverLedger;
use App\Models\VendorLedger;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{


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
        DB::beginTransaction();

        try {
            // Insert into trips table
            $trip = trip::create([
                'user_id' => Auth::id(),
                'customer'           => $request->customer,
                'date'               => $request->date,
                'load_point'         => $request->load_point,
                'unload_point'       => $request->unload_point,
                'transport_type'     => $request->transport_type,
                'vehicle_no'         => $request->vehicle_no,
                'total_rent'         => $request->total_rent,
                'quantity'           => $request->quantity,
                'dealer_name'        => $request->dealer_name,
                'driver_name'        => $request->driver_name,
                'fuel_cost'          => $request->fuel_cost,
                'do_si'              => $request->do_si,
                'driver_mobile'      => $request->driver_mobile,
                'challan'            => $request->challan,
                'sti'                => $request->sti,
                'model_no'           => $request->model_no,
                'co_u'               => $request->co_u,
                'masking'            => $request->masking,
                'unload_charge'      => $request->unload_charge,
                'extra_fare'         => $request->extra_fare,
                'vehicle_rent'       => $request->vehicle_rent,
                'goods'              => $request->goods,
                'distribution_name'  => $request->distribution_name,
                'remarks'            => $request->remarks,
                'no_of_trip'         => $request->no_of_trip,
                'vehicle_mode'       => $request->vehicle_mode,
                'per_truck_rent'     => $request->per_truck_rent,
                'vat'                => $request->vat,
                'total_rent_cost'    => $request->total_rent_cost,
                'driver_commission'  => $request->driver_commission,
                'road_cost'          => $request->road_cost,
                'food_cost'          => $request->food_cost,
                'total_exp'      => $request->total_exp,
                'trip_rent'          => $request->trip_rent,
                'advance'            => $request->advance,
                'due_amount'         => $request->due_amount,
                'body_fare'          => $request->body_fare,
                'parking_cost'       => $request->parking_cost,
                'branch_name'       => $request->branch_name,
                'night_guard'        => $request->night_guard,
                'toll_cost'          => $request->toll_cost,
                'feri_cost'          => $request->feri_cost,
                'police_cost'        => $request->police_cost,
                'driver_adv'         => $request->driver_adv,
                'chada'              => $request->vehicle_size,
                'trip_id'             => $request->trip_id,
                'vehicle_size'         => $request->chada,
                'vehicle_category'    => $request->vehicle_category,
                'labor'                  => $request->labor,
                'callan_cost'              => $request->callan_cost,
                'others_cost'              => $request->others_cost,
                'vendor_name'        => $request->vendor_name,
                'additional_load'    => $request->additional_load,
                'trip_type'  => $request->trip_type,
                'additional_cost'  => $request->additional_cost,
                'status'  => "Pending",
            ]);

            // Insert into driver or vendor ledger based on transport type
            if ($request->transport_type === "own_transport") {
                DriverLedger::create([
                    'user_id' => Auth::id(),
                    'date'              => $request->date,
                    'driver_name'       => $request->driver_name,
                    'trip_id'           => $trip->id,
                    'load_point'        => $request->load_point,
                    'unload_point'      => $request->unload_point,
                    'driver_commission' => $request->driver_commission,
                    'driver_adv'        => $request->driver_adv,
                    'parking_cost'      => $request->parking_cost,
                    'night_guard'       => $request->night_guard,
                    'toll_cost'         => $request->toll_cost,
                    'feri_cost'         => $request->feri_cost,
                    'police_cost'       => $request->police_cost,
                    'chada'             => $request->chada,
                    'branch_name'       => $request->branch_name,
                    'callan_cost'       => $request->callan_cost,
                    'others_cost'       => $request->others_cost,
                    'labor'             => $request->labor,
                    'total_exp'         => $request->total_exp,
                ]);
            } else {
                VendorLedger::create([
                    'user_id' => Auth::id(),
                    'date'         => $request->date,
                    'driver_name'  => $request->driver_name,
                    'trip_id'      => $trip->id,
                    'load_point'   => $request->load_point,
                    'unload_point' => $request->unload_point,
                    'customer'     => $request->customer,
                    'vendor_name'  => $request->vendor_name,
                    'vehicle_no'   => $request->vehicle_no,
                    'trip_rent'    => $request->total_exp,
                    'advance'      => $request->advance,
                    'due_amount'   => $request->due_amount,
                ]);
            }

            // Insert into branch ledgers
            OfficeLedger::create([
                'user_id' => Auth::id(),
                'date'         => $request->date,
                'unload_point' => $request->unload_point,
                'customer'     => $request->customer,
                'trip_id'      => $trip->id,
                'branch_name'  => $request->branch_name,
                'status'       => $request->status,
                'cash_out'     => $request->total_exp,
                'created_by'   => $request->created_by,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Trip created successfully',
                'data'    => $trip,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
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
