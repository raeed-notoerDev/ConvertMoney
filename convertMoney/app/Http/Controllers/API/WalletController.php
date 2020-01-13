<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $last_wallet = Wallet::where('member_id', $request['agent'])->orderBy('created_at', 'desc')->first();
            if ($last_wallet) {
                $last_wallet->update([
                    'calculate' => true
                ]);
                Wallet::create([
                    'amount_plus' => $request['amount'],
                    'member_id' => $request['agent'],
                    'uuid' => uniqid(),
                ]);
                $this->calculate_revenue($last_wallet->amount, $request['amount'], $request['agent']);
                return response()->json([
                    'status' => true,
                    'message' => 'Amount Added Successfully'
                ]);
            } else {
                Wallet::create([
                    'amount_plus' => $request['amount'],
                    'amount' => $request['amount'],
                    'member_id' => $request['agent'],
                    'uuid' => uniqid(),
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Amount Added Successfully'
                ]);
            }
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // update commission

    }


    public function destroy(Request $request)
    {
        $last_wallet = Wallet::where('member_id', $request['agent'])->orderBy('created_at', 'desc')->first();
        if ($last_wallet) {
            $last_wallet->update([
                'calculate' => true
            ]);
            Wallet::create([
                'amount_minis' => $request['amount'],
                'member_id' => $request['agent'],
                'uuid' => uniqid()
            ]);
            $this->calculate_expense($last_wallet->amount, $request['amount'], $request['agent']);
            return response()->json([
                'status' => true,
                'message' => 'Amount Discounted Successfully'
            ]);
        } else {
            Wallet::create([
                'amount_minis' => $request['amount'],
                'amount' => $request['amount'],
                'member_id' => $request['agent'],
                'uuid' => uniqid()
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Amount Discounted Successfully'
            ]);
        }
    }

    public function calculate_revenue($amount, $revenue, $ref_id)
    {
        $result = Wallet::where('member_id', $ref_id)->where('calculate', 0)->orderBy('created_at', 'desc')->first();
        $result->update([
            'amount' => $amount + $revenue
        ]);
        User::where('ref_id', $ref_id)->update([
            'wallet' => $amount + $revenue
        ]);

    }

    public function calculate_expense($amount, $expense, $ref_id)
    {
        $result = Wallet::where('member_id', $ref_id)->where('calculate', 0)->orderBy('created_at', 'desc')->first();
        $result->update([
            'amount' => $amount - $expense
        ]);
        User::where('ref_id', $ref_id)->update([
            'wallet' => $amount - $expense
        ]);
    }
}
