<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $countries = Country::where('deleted_at', null)
            ->where('block', false)->get();
        if ($countries)
            return response()->json([
                'status' => true,
                'message' => 'Country Fetched successfully!',
                'country_list' => $countries
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
            'country' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }
        Country::create([
            'name' => $request['country'],
            'block' => 0
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Country Added Successfully'
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
        $country = Country::where('id', $id)->first();
        $r = $country->update([
            'block' => (!$country->block)
        ]);
        if ($r)
            return response()->json([
                'status' => true,
                'message' => 'Status  Updated'
            ]);
        else
            return response()->json([
                'status' => false,
                'message' => 'Status Not Updated'
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
        //
    }
}
