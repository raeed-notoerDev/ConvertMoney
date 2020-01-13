<?php

namespace App\Http\Controllers\API;

use App\Beneficiary;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
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


    public function show($uuid)
    {
        return Beneficiary::where('uuid', $uuid)->first();
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

    public function search()
    {
        if ($search = \Request::get('q')) {
            $beneficiaries = Beneficiary::where(function ($query) use ($search) {
                $query->where('full_name', 'LIKE', "%$search%")
                    ->orWhere('passport_number', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%")
                    ->orWhere('phone_number', 'LIKE', "%$search%");
            })->get();
        } else {
//            $beneficiaries = Beneficiary::latest()->paginate(5);
            $beneficiaries = Beneficiary::all();
        }
        return $beneficiaries;
    }
}
