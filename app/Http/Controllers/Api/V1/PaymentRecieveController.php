<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\PaymentRec;
use App\Models\OfficeLedger;
use Illuminate\Http\Request;
use App\Models\CustomerLedger;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentRecieveController extends Controller
{


    public function index()
    {
        $data = PaymentRec::all();

        return response()->json([
            'status' => 'Success',
            'data' => $data
        ], 200);
    }
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            // Insert into trips table
            $payment_rec = PaymentRec::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'date'  => $request->date,
                'bill_ref'  => $request->bill_ref,
                'amount' => $request->amount,
                'status' => $request->status,
                'branch_name' => $request->branch_name,
                'remarks' => $request->remarks,
                'cash_type' => $request->cash_type,
                'created_by'   => $request->created_by,

            ]);

            // Insert into branch_ledgers
            OfficeLedger::create([
                'user_id' => Auth::id(),
                'date'               => $request->date,
                'payment_rec_id' => $payment_rec->id,
                'customer'           => $request->customer_name,
                'branch_name' => $request->branch_name,
                'cash_in'      => $request->amount,
                'created_by'         => $request->created_by,
            ]);

            CustomerLedger::create([
                'user_id' => Auth::id(),
                'bill_date'  => $request->date,
                'payment_rec_id' => $payment_rec->id,
                'customer_name'  => $request->customer_name,
                'rec_amount' => $request->amount,
                'created_by'  => $request->created_by,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ' created successfully',
                'data'    => $payment_rec
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
