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
        $vehicles = Vehicle::where('user_id', Auth::id())->latest()->get();
        return response()->json($vehicles);
    }

    // Store a new vehicle
    public function store(Request $request)
    {
       

        $vehicle = Vehicle::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'driver_name' => $request->driver_name,
            'vehicle_size' => $request->vehicle_size,
            'vehicle_category' => $request->vehicle_category,
            'reg_zone' => $request->reg_zone,
            'reg_serial' => $request->reg_serial,
            'reg_no' => $request->reg_no,
            'reg_date' => $request->reg_date,
            'status' => $request->status,
            'tax_date' => $request->tax_date,
            'route_per_date' => $request->route_per_date,
            'fitness_date' => $request->fitness_date,
            'fuel_capcity' => $request->fuel_capcity,
        ]);

        return response()->json(['message' => 'Vehicle created successfully', 'data' => $vehicle]);
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
