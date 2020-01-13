<?php

namespace App\Http\Controllers\API;

use App\Currency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $currencies = Currency::where('deleted_at', null)
            ->where('block', false)->get();
        if ($currencies)
            return response()->json([
                'status' => true,
                'message' => 'Currency Fetched successfully!',
                'currency_list' => $currencies
            ]);
        else
            return response()->json([
                'status' => false,
                'message' => 'Error'
            ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }
        Currency::create([
            'name' => $request['name'],
            'block' => 0
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Currency Added Successfully'
        ]);
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

    public function update(Request $request, $id)
    {
        $currency = Currency::where('id', $id)->first();
//        error_log(!$currency->block);
        $r = $currency->update([
            'block' => (!$currency->block)
        ]);
        error_log($r);
        return response()->json([
            'status' => true,
            'message' => 'Status Updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
