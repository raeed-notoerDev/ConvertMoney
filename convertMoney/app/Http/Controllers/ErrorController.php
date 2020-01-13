<?php

namespace App\Http\Controllers;

use App\Beneficiary;
use App\Role;
use App\Transaction;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ErrorController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
//            'password' => 'required',
            'nationality' => 'required',
            'address' => 'required',
//            'status' => 'required',
            'gender' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'agent_commission' => 'numeric',
//            'country_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }
        if ($request->picture) {
            $photo = time() . '.' . explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
        }
        \Image::make($request->picture)->save(public_path('img/profile/') . $photo);
        $user = User::create([
            'user_name' => $request['user_name'],
            'email' => $request['email'],
            'zip_code' => $request['zip_code'],
//            'password' => Hash::make($request['password']),
            'password' => Hash::make('12345678'),
            'country_id' => 1,
//            'country_id' => $request['country_id'],
            'gender' => $request['gender'],
            'agent_commission' => $request['agent_commission'],
            'phone_number' => $request['phone_number'],
            'first_name' => $request['first_name'],
            'address' => $request['address'],
            'last_name' => $request['last_name'],
            'nationality' => $request['nationality'],
            'status' => 'holed',
            'uuid' => uniqid(),
//            'status' => $request['status'],
            'ref_id' => random_strings(8),
            'picture' => $request['picture'],
        ]);


        $user->roles()->attach(Role::where('name', 'client')->first());
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], 200);
//        return response()->json($request['user_name']);
    }

    public function show()
    {
        return view('auth.register');
    }

    public function create_transaction(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'convert_price' => 'required',
            'total_money' => 'required',
            'commission' => 'required',
            'country_id' => 'required',
            'photo' => 'string',
            'sender_full_name' => 'required',
            'sender_phone_number' => 'numeric|required',
            'receiver_phone_number' => 'numeric|required',
            'currency_sender_id' => 'required',
            'currency_receiver_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        try {

            if ((auth()->user()->wallet) > 0) {
                $result_sender = auth()->user()->wallet - (floatval($input['total_money']) - floatval($input['commission']));
                if ($result_sender > 0) {
                    $senderBeneficiary = Beneficiary::where('phone_number', $input['sender_phone_number'])->first();
                    if (!$senderBeneficiary) {
                        $senderBeneficiary = Beneficiary::create([
                            'full_name' => $input['sender_full_name'],
                            'uuid' => uniqid(),
                            'phone_number' => $input['sender_phone_number'],
                            'address' => $input['address_sender'],
                            'id_number' => random_strings(10),
                            'passport_number' => $input['passport_ID'],
                            'birthday' => $input['birthday'],
                            'nationality' => $input['sender_nationality'],
                            'gender' => $input['sender_gender'],
                            'profession' => $input['profession'],
                            'other_info' => $input['other_info'],
                        ]);
                    }
                    $receiverBeneficiary = Beneficiary::where('phone_number', $input['receiver_phone_number'])->first();
                    if (!$receiverBeneficiary) {
                        $receiverBeneficiary = Beneficiary::create([
                            'full_name' => $input['receiver_full_name'],
                            'uuid' => uniqid(),
                            'id_number' => random_strings(10),
                            'phone_number' => $input['receiver_phone_number'],
                        ]);
                    }
                    Transaction::create([
                        'code' => random_strings(11),
                        'total_money' => $input['total_money'],
                        'sender_beneficiary_id' => $senderBeneficiary->id_number,
                        'receiver_beneficiary_id' => $receiverBeneficiary->id_number,
                        'commission' => $input['commission'],
                        'receiver_country_id' => $input['country_id'],
                        'currency_receiver_id' => $input['currency_receiver_id'],
                        'currency_sender_id' => $input['currency_sender_id'],
                        'status' => 'holed',
                        'convert_price' => $input['convert_price'],
                        'agent_id_sender' => auth()->user()->ref_id,
                        'destination_country_id' => $input['country_id'],
                        'photos' => 'photo'
                    ]);
                    Wallet::create([
                        'amount_minis' => $result_sender,
                        'member_id' => auth()->user()->ref_id,
                        'uuid' => uniqid()
                    ]);
                    User::where('ref_id', auth()->user()->ref_id)->update([
                        'wallet' => $result_sender
                    ]);

                    //add method for calculate wallet after transaction
                    // here

                    return response()->json([
                        'status' => true,
                        'message' => 'Transfer is success sender'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => '  Not enough money in your account'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'you dont have Money in your account'
                ]);

            }

        } catch (\Exception $exception) {

            error_log($exception->getMessage());
            return response()->json(['error' => $exception->getMessage()]);
        }

    }

    public function showTransaction()
    {
        return view('transaction');
    }
}
