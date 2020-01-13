<?php

namespace App\Http\Controllers\API;

use App\Beneficiary;
use App\Country;
use App\Http\Controllers\Controller;
use App\Image;
use App\Transaction;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
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


    public function show($code)
    {
        try {
            $transaction_data = DB::table('users')
                ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                ->select('transactions.*', 'countries.*')
                ->where('transactions.code', $code)
                ->get();
            if ($transaction_data) {
                return response()->json([
                    'transaction' => $this->list_transaction($transaction_data),
                    'images' => Image::where('transaction_id', $code)->get(),
                    'receiver_id' => $transaction_data[0]->agent_id_sender
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error Transaction Not Found Code Error'
                ], 404);
            }
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function showTransaction($code)
    {
        try {
            $transaction_data = DB::table('users')
                ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                ->join('countries', 'transactions.destination_country_id', '=', 'countries.id')
                ->select('transactions.*', 'countries.*')
                ->where('transactions.code', $code)
                ->first();

            if ($transaction_data) {
                return response()->json([
                    'transaction' => $this->listDetailsTransaction($transaction_data),
                    'images' => Image::where('transaction_id', $code)->get()
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error Transaction Not Found Code Error'
                ], 404);
            }
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
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

    }

    public function create()
    {
        return response()->json(['code' => random_strings(11)]);
    }

    public function upload_images(Request $request, $code)
    {
        try {
//            $validator = Validator::make($request->all(), [
//                'name' => 'string|required',
//                'photo' => 'required'
//            ]);
//            if ($validator->fails()) {
//                return response()->json([
//                    'status' => false,
//                    'message' => $validator->errors()
//                ], 403);
//            }
//            if ($request->hasFile('file')) {
//                $file = $request->file('file');
//                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
//                $path = $file->storeAs('public\images', $fileName);
//                if ($path) {
//                    // enter the code in images database
//                    $images = new Image();
//                    $images->path = $fileName;
//                    $images->uuid = uniqid(5);
//                    $images->transaction_id = $code;
//                    $images->name = $request['name'];
//                    $images->save();
//                    return response()->json([
//                        'upload_status' => 'success'
//                    ], 200);
//                } else {
//                    return response()->json([
//                        'upload_status' => 'failed'
//                    ], 401);
//                }
//            }
//            error_log($request->photo);
            if ($request->photo) {
                $nameImage = time() . '.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
                \Image::make($request->photo)->save(public_path('images/') . $nameImage);
//            $request->merge(['photo' => $name]);
//            $photo = public_path('images/') . $name;

                $images = new Image();
                $images->path = $nameImage;
                $images->uuid = uniqid(5);
                $images->transaction_id = $code;
                $images->name = $request['name'];
                $images->save();
                return response()->json([
                    'upload_status' => 'success'
                ], 200);
            } else
                return response()->json([
                    'upload_status' => 'failed'
                ], 401);

        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }

    }

    public function delete_image(Request $request)
    {
        try {

            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'name' => 'string|required',
                'code' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 403);
            }
//            if (Storage::delete('public/images/' . $input['name'])) {
//                Image::where('transaction_id', $input['code'])->first()->delete();
//                return response()->json([
//                    'status' => true,
//                    'message' => 'deleted Successfully'
//                ], 200);
//            } else
//                return response()->json([
//                    'status' => true,
//                    'message' => 'Some Thing Wrong -_- '
//                ], 403);

            $photo = public_path('images/') . $request['name'];
            if (file_exists($photo)) {
                @unlink($photo);
                Image::where('transaction_id', $input['code'])->where('path', $request['name'])->first()->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'deleted Successfully'
                ], 200);
            } else
                return response()->json([
                    'status' => true,
                    'message' => 'Some Thing Wrong -_- '
                ], 403);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function show_images($code)
    {
        $images = Image::where('transaction_id', $code)->get();
        if ($images) {
            return response()->json([
                'status' => true,
                'list_images' => $images
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'The Code Not available'
            ], 404);
        }
    }

    public function create_transaction(Request $request)
    {
        try {
            $input = $request->all();
            $validator = Validator::make($request->all(), [
                'convert_price' => 'required',
                'total_money' => 'required',
                'commission' => 'required',
                'country_id' => 'required',
//                'photo' => 'string',
                'sender_full_name' => 'required',
                'sender_phone_number' => 'numeric|required',
                'receiver_phone_number' => 'numeric|required',
                'currency_sender_id' => 'required',
                'currency_receiver_id' => 'required',
                'code' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ],401);
            }
            if (auth('api')->user()->wallet > 0 && auth('api')->user()->wallet > floatval($input['total_money'])) {
                $result_sender = auth('api')->user()->wallet - (floatval($input['total_money']) - floatval($input['commission']));
//                error_log('result  ' . $result_sender);
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
                        'code' => $request['code'],
                        'total_money' => $input['total_money'],
                        'sender_beneficiary_id' => $senderBeneficiary->id_number,
                        'receiver_beneficiary_id' => $receiverBeneficiary->id_number,
                        'commission' => $input['commission'],
                        'receiver_country_id' => Country::where('id', $input['country_id'])->first()['name'],
                        'currency_receiver_id' => $input['currency_receiver_id'],
                        'currency_sender_id' => $input['currency_sender_id'],
                        'status' => 'hold',
                        'convert_price' => $input['convert_price'],
                        'agent_id_sender' => auth('api')->user()->ref_id,
                        'destination_country_id' => $input['country_id'],
                        'photos' => 'photo'
                    ]);
                    $last_wallet = Wallet::where('member_id', auth('api')->user()->ref_id)->orderBy('created_at', 'desc')->first();
                    $last_wallet->update([
                        'calculate' => true
                    ]);
                    Wallet::create([
                        'amount_minis' =>($last_wallet->amount - $result_sender) ,
                        'member_id' => auth('api')->user()->ref_id,
                        'amount' => $result_sender,
                        'uuid' => uniqid()
                    ]);
//                    auth('api')->user()->calculate_expense($last_wallet->amount, $result_sender);
                    User::where('ref_id', auth('api')->user()->ref_id)->update([
                        'wallet' => $result_sender
                    ]);
                    return response()->json([
                        'status' => true,
                        'message' => 'Transfer is success sender'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => '  Not enough money in your account'
                    ],401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'you dont have Money in your account'
                ],401);
            }
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response()->json($exception->getMessage());
        }
    }

    function list_transaction($transactions)
    {
        try {
            $myArray = [];
            for ($i = 0; $i < $transactions->count(); $i++) {
                array_push($myArray, (object)[
                    'code' => $transactions[$i]->code,
                    'total_money' => $transactions[$i]->total_money,
                    'name_sender' => Beneficiary::where('id_number', $transactions[$i]->sender_beneficiary_id)->first()['full_name'],
                    'name_receiver' => Beneficiary::where('id_number', $transactions[$i]->receiver_beneficiary_id)->first()['full_name'],
                    'tax' => $transactions[$i]->tax,
                    'commission' => $transactions[$i]->commission,
                    'currency_sender' => $transactions[$i]->currency_sender_id,
                    'currency_receiver' => $transactions[$i]->currency_receiver_id,
                    'agent_sender' => User::where('ref_id', $transactions[$i]->agent_id_sender)->first()['first_name'] . '   ' . User::where('ref_id', $transactions[$i]->agent_id_sender)->first()['last_name'],
                    'agent_receiver' => User::where('ref_id', $transactions[$i]->agent_id_receiver)->first()['first_name'] . '   ' . User::where('ref_id', $transactions[$i]->agent_id_receiver)->first()['last_name'],
                    'city_destination' => $transactions[$i]->name,
                    'status' => $transactions[$i]->status,
                    'date' => $transactions[$i]->created_at,
                    'convert_price' => $transactions[$i]->convert_price
                ]);
            }

            return $myArray;
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }


    function listDetailsTransaction($transactions)
    {
        try {
            $myArray = [
                'code' => $transactions->code,
                'total_money' => $transactions->total_money,
                'name_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['full_name'],
                'address_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['address'],
                'passport_number_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['passport_number'],
                'phone_number_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['phone_number'],
                'nationality_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['nationality'],
                'gender_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['gender'],
                'profession_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['profession'],
                'other_info_sender' => Beneficiary::where('id_number', $transactions->sender_beneficiary_id)->first()['other_info'],
                'name_receiver' => Beneficiary::where('id_number', $transactions->receiver_beneficiary_id)->first()['full_name'],
                'phone_number_receiver' => Beneficiary::where('id_number', $transactions->receiver_beneficiary_id)->first()['phone_number'],
                'receiver_full_name' => Beneficiary::where('id_number', $transactions->receiver_beneficiary_id)->first()['full_name'],
                'tax' => $transactions->tax,
                'commission' => $transactions->commission,
                'currency_sender' => $transactions->currency_sender_id,
                'currency_receiver' => $transactions->currency_receiver_id,
                'agent_sender' => User::where('ref_id', $transactions->agent_id_sender)->first()['first_name'] . '   ' . User::where('ref_id', $transactions->agent_id_sender)->first()['last_name'],
                'receiver_money' => ($transactions->total_money - ($transactions->total_money * ((User::where('ref_id', $transactions->agent_id_sender)->first()['agent_commission']) + (User::where('ref_id', auth('api')->user()->ref_id)->first()['agent_commission'])) / 100)),
//              'agent_receiver' => User::where('ref_id', $transactions->agent_id_receiver)->first()['first_name'] . '   ' . User::where('ref_id', $transactions->agent_id_receiver)->first()['last_name'],
                'city_destination' => $transactions->name,
                'status' => $transactions->status,
                'date' => $transactions->created_at,
                'convert_price' => $transactions->convert_price,
            ];
            return $myArray;
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function blocked_transaction(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }
            $transaction = Transaction::where('code', $request['code'])
                ->where('status', '<>', 'received')
                ->first();
            $transaction->update([
                'status' => 'blocked'
            ]);
            $agent_sender = User::where('ref_id', $transaction->agent_id_sender)->first();
            $result_sender = $agent_sender->wallet + ($transaction->total_money - $transaction->commission);
            $last_wallet = Wallet::where('member_id', auth('api')->user()->ref_id)->orderBy('created_at', 'desc')->first();
            $last_wallet->update([
                'calculate' => true
            ]);
            Wallet::create([
                'amount_plus' => $result_sender,
                'member_id' => $transaction->agent_id_sender,
                'amount' => ($last_wallet + $result_sender),
                'uuid' => uniqid(),
            ]);
            $agent_sender->update([
                'wallet' => ($result_sender + $last_wallet)
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Transaction blocked'
            ]);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function accepted_transaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $transaction = Transaction::where('code', $request['code'])
            ->where('status', '<>', 'received')
            ->first();
        $transaction->update([
            'status' => 'approved'
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Transaction Approved '
        ]);
    }

    public function cancelled_transaction(Request $request)
    {

    }

}
