<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Attendence;
use Illuminate\Http\Request;

class AttendenceController extends Controller
{
   public function index()
    {
        $data = Attendence::all();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        $data = Attendence::create($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function show($id)
    {
        $data = Attendence::findOrFail($id);
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data = Attendence::findOrFail($id);
        $data->update($request->all());
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        $data = Attendence::findOrFail($id)->delete();
        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
}

