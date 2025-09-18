<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json($vehicles);
    }

    // Store a new vehicle
   public function store(Request $request)
{
    $validated = $request->validate([
        'date'             => 'required|date',
        'driver_name'      => 'required|string|max:255',
        'vehicle_name'     => 'required|string|max:255',
        'insurance_date'   => 'nullable|date',
        'vehicle_size'     => 'required|string|max:100',
        'vehicle_category' => 'required|string|max:100',
        'reg_zone'         => 'required|string|max:50',
        'reg_serial'       => 'required|string|max:50',
        'reg_no'           => 'required|string|max:50',
        'reg_date'         => 'required|date',
        'status'           => 'required|string|max:50',
        'tax_date'         => 'nullable|date',
        'route_per_date'   => 'nullable|date',
        'fitness_date'     => 'nullable|date',
        'fuel_capcity'     => 'nullable|numeric',
    ]);

    $vehicle = Vehicle::create([
        'user_id'          => Auth::id(),
        'date'             => $validated['date'],
        'driver_name'      => $validated['driver_name'],
        'vehicle_name'     => $validated['vehicle_name'],
        'insurance_date'   => $validated['insurance_date'] ?? null,
        'vehicle_size'     => $validated['vehicle_size'],
        'vehicle_category' => $validated['vehicle_category'],
        'reg_zone'         => $validated['reg_zone'],
        'reg_serial'       => $validated['reg_serial'],
        'reg_no'           => $validated['reg_no'],
        'reg_date'         => $validated['reg_date'],
        'status'           => $validated['status'],
        'tax_date'         => $validated['tax_date'] ?? null,
        'route_per_date'   => $validated['route_per_date'] ?? null,
        'fitness_date'     => $validated['fitness_date'] ?? null,
        'fuel_capcity'     => $validated['fuel_capcity'] ?? null,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Vehicle created successfully',
        'data' => $vehicle
    ], 201);
}


    // Show single vehicle
    public function show($id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        return response()->json($vehicle);
    }

    // Update vehicle
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle->update($request->all());

        return response()->json(['message' => 'Vehicle updated successfully', 'data' => $vehicle]);
    }

    // Delete vehicle
    public function destroy($id)
    {
        $vehicle = Vehicle::where('user_id', Auth::id())->find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted successfully']);
    }
}
