<?php

namespace App\Http\Controllers\API;

use App\Country;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($key)
    {
        return Setting::where('key', $key)->first()['value'];
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
        //
    }


    public function destroy($id)
    {

    }

    public function update_currency(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }
        $currency = Currency::where('id', $request['id'])->first();
        if ($request['name'] !== $currency->name) {
            $unique = Currency::where('name', $request['name'])->first();
            if ($unique)
                return response()->json([
                    'status' => false,
                    'message' => 'Currency Already Exist ....'
                ]);
            else {
                $currency->update([
                    'name' => $request['name'],
                    'block' => $request['status']
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Updated Successfully'
                ]);
            }
        } else {
            $currency->update([
                'block' => $request['status']
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully'
            ]);
        }
    }

    public function allCurrency(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Currency Fetched successfully!',
            'currency_list' => Currency::all()
        ]);
    }


    public function deleteCurrency($id)
    {
        $currency = Currency::findOrfail($id);
        $currency->delete();
        return response()->json([
            'status' => true,
            'message' => 'currency deleted'
        ]);
    }

    public function allCountry(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Countries Fetched successfully!',
            'country_list' => Country::all()
        ]);
    }

    public function update_country(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required',
            'status' => 'required',
            'idCountry' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }
        $country = Country::where('id', $request['idCountry'])->first();
        if ($request['country'] !== $country->name) {
            $unique = Country::where('name', $request['country'])->first();
            if ($unique)
                return response()->json([
                    'status' => false,
                    'message' => 'Country Already Exist ....'
                ]);
            else {
                $country->update([
                    'name' => $request['country'],
                    'block' => $request['status']
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Updated Successfully'
                ]);
            }
        } else {
            $country->update([
                'block' => $request['status']
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully'
            ]);
        }
    }


    public function deleteCountry($id)
    {
        $country = Country::findOrfail($id);
        $country->delete();
        return response()->json([
            'status' => true,
            'message' => 'country deleted'
        ]);
    }

    public function commission_update(Request $request)
    {
        try {
            Setting::where('key', 'commission_admin')->update([
                'value' => $request->commission_admin]);
            Setting::where('key', 'commission_currency')->update([
                'value' => $request->commission_currency
            ]);
            Setting::where('key', 'current_currency')->update([
                'value' => $request->current_currency
            ]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

    }

    public function getDataHeader()
    {

        return response()->json([
            'logo' => Setting::where('key', 'logo')->first()['value'],
            'company_name' => Setting::where('key', 'company_name')->first()['value'],
            'description' => Setting::where('key', 'description')->first()['value'],
        ]);
    }


    public function updateHeaderData(Request $request)
    {
//        try {

        $validator = Validator::make($request->all(), [
            'company_name' => 'string',
            'description' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $company_name = Setting::where('key', 'company_name')->first()['value'];
        $description = Setting::where('key', 'description')->first();
        $currentPhoto = Setting::where('key', 'logo')->first()['value'];

        if ($request->logo != $currentPhoto && $request->logo != "") {
            $name = time() . '.' . explode('/', explode(':', substr($request->logo, 0, strpos($request->logo, ';')))[1])[1];
            \Image::make($request->logo)->save(public_path('img/profile/') . $name);
            $request->merge(['logo' => $name]);
            $userPhoto = public_path('img/profile/') . $currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
            Setting::where('key', 'logo')->update([
                'value' => $request['logo']
            ]);
        }
        if ($request->company_name != $company_name) {

            Setting::where('key', 'company_name')->update([
                'value' => $request->company_name,
            ]);
        }
        if ($request->description != $description->value) {
            $description->update([
                'value' => $request->description
            ]);
        }
        return response()->json([
            'status' => true,
            'message' => 'Settings Updated Successfully :)'
        ]);
    }

}
