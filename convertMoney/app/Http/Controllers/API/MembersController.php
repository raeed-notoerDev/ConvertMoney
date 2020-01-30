<?php

namespace App\Http\Controllers\API;

use App\Beneficiary;
use App\Country;
use App\Http\Controllers\Controller;
use App\Member;
use App\Role;
use App\Transaction;
use App\User;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MembersController extends Controller
{

    public function index()
    {
        $members = User::all();


        return response()->json($this->list_members($members));
    }

    function list_members($members)
    {
        $myArray = [];
        for ($i = 0; $i < $members->count(); $i++) {
            if ($members[$i]->hasAnyRole('client')){
                array_push($myArray, (object)[
                    'ref_id' => $members[$i]->ref_id,
                    'first_name' => $members[$i]->first_name,
                    'last_name' => $members[$i]->last_name,
                    'user_name' => $members[$i]->user_name,
                    'gender' => $members[$i]->gender,
                    'nationality' => $members[$i]->nationality,
                    'status' => $members[$i]->status,
                    'email' => $members[$i]->email,
                    'phone_number' => $members[$i]->phone_number,
                    'agent_commission' =>$members[$i]->agent_commission,
                    'wallet' => $members[$i]->wallet,
                    'address' => $members[$i]->address,
                    'created_at' => $members[$i]->created_at,
                ]);
            }

        }
        return $myArray;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'max:30|email|required|exists:members,email',
            'password' => 'min:8|required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $memberData = Member::where([
            ['email', 'like', $request->get('email')],
            ['password', 'like', $request->get('password')],
            ['state', 'like', 'accepted'],
            ['deleted_at', '=', null]
        ])->first();
        if ($memberData) {
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
//                $member = Auth::user();
//                $token = $member->createToken('MyApp')->accessToken;
                $memberToken = Member::find($memberData->id);
                $token = $memberToken->createToken('MyApp')->accessToken;
                return response()->json([
                    'success' => $token
                ], 200);
            }
            return response()->json(false);

        } else if (Member::where([
            ['email', 'like', $request->get('email')],
            ['password', 'like', $request->get('password')],
            ['deleted_at', '<>', null]
        ])->first()) {
            return response()->json([
                'status' => false,
                'message' => 'account not found'
            ]);
        } else if (Member::where([
            ['email', 'like', $request->get('email')],
            ['password', 'like', $request->get('password')],
            ['state', 'like', 'hold'],
            ['deleted_at', '=', null]
        ])->first()) {
            return response()->json([
                'status' => false,
                'message' => ' Please activate your account'
            ]);
        } else if (Member::where([
            ['email', 'like', $request->get('email')],
            ['password', 'like', $request->get('password')],
            ['state', 'like', 'blocked'],
            ['deleted_at', '=', null]
        ])->first()) {
            return response()->json([
                'status' => false,
                'message' => ' Please account has been blocked'
            ]);
        } else
            return response()->json([
                'status' => false,
                'message' => 'some think wrong '
            ]);
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
        $member = User::where('ref_id', $code)->first();
        if ($member)
            return response()->json([
                'status' => true,
                'member' => $member
            ]);
        else
            return response()->json([
                'status' => true,
                'message' => 'Member Not Found ):'
            ], 404);
    }

    public function blocked_member(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $member = User::where('ref_id', $request['ref_id'])->first();
        if ($member == null) {
            return response()->json([
                'status' => false,
                'message' => 'Member Not Found '
            ]);
        } else {
            $member->update([
                'status' => 'block'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Client Blocked ....'
            ]);
        }
    }

    public function active_member(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $member = User::where('ref_id', $request['ref_id'])->first();
        if ($member == null) {
            return response()->json([
                'status' => false,
                'message' => 'Member Not Found '
            ]);
        } else {
            $member->update([
                'status' => 'active'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Client Activated....'
            ]);
        }
    }

    public function hold_member(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ref_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $member = User::where('ref_id', $request['ref_id'])->first();
        if ($member == null) {
            return response()->json([
                'status' => false,
                'message' => 'Member Not Found '
            ]);
        } else {
            $member->update([
                'status' => 'hold'
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Client hold....'
            ]);
        }
    }


    public function update(Request $request, $code)
    {
        try {
            $member = User::where('ref_id', $code)->first();
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:191|unique:users,email,' . $member->id,
                'user_name' => 'required|string|unique:users,user_name,' . $member->id,
                'phone_number' => 'required|string|unique:users,phone_number,' . $member->id,
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ]);
            }

            if ($member == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Member Not Found '
                ]);
            } else {
                $currentPhoto = $member->picture;
                if ($request->picture != $currentPhoto) {
                    $name = time() . '.' . explode('/', explode(':', substr($request->picture, 0, strpos($request->picture, ';')))[1])[1];
                    \Image::make($request->picture)->save(public_path('img/profile/') . $name);
                    $request->merge(['picture' => $name]);
                    $userPhoto = public_path('img/profile/') . $currentPhoto;
                    if (file_exists($userPhoto)) {
                        @unlink($userPhoto);
                    }
                }
                if (!empty($request->password)) {
                    $request->merge(['password' => Hash::make($request['password'])]);
                }
                $member->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Updated Successfully :)'
                ]);
            }
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
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


    public function receiver_transaction(Request $request)
    {
//        error_log($request['code']);
        $validator = Validator::make($request->all(), [
            'code' => 'required|exists:transactions,code',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $input = $request->all();
        $transaction = Transaction::where('code', $input['code'])->where('status', '<>', 'paid')->first();
        if ($transaction) {
//            $exchange_rate = "https://free.currconv.com/api/v7/convert?q=USD_" . $transaction->currency_receiver_id . "&compact=ultra&apiKey=301cb83516aa3d45d387";
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL, $exchange_rate);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            $return = curl_exec($ch);
//            curl_close($ch);
//            $exchange_rate = json_decode($return, TRUE);
            if ($transaction->convert_price > 1)
                $wallet = (auth('api')->user()->wallet * $transaction->convert_price);
            else
                $wallet = (auth('api')->user()->wallet / $transaction->convert_price);

            if (auth('api')->user()->wallet > 0 && $wallet > floatval($input['total_money'])) {
                $receiverBeneficiary = Beneficiary::where('id_number', $input['code_receiver'])->first();
                error_log($receiverBeneficiary);
                $receiverBeneficiary->update([
                    'address' => $input['receiver_address'],
                    'phone_number' => $input['receiver_phone_number'],
                    'passport_number' => $input['receiver_passport_number'],
                    'birthday' => $input['receiver_birthday'],
                    'nationality' => $input['receiver_nationality'],
                    'gender' => $input['receiver_gender'],
                    'profession' => $input['receiver_profession'],
                    'other_info' => $input['receiver_other_info'],
                ]);
                $transaction->update([
                    'status' => 'paid',
                    'receiver_agent_id' => auth('api')->user()->ref_id,
                    'delivered_at' => Carbon::now(),
                ]);
                $last_wallet = Wallet::where('member_id', auth('api')->user()->ref_id)->orderBy('created_at', 'desc')->first();
                $last_wallet->update([
                    'calculate' => true
                ]);
                Wallet::create([
                    'amount_plus' => floatval($input['total_money']) / $transaction->convert_price,
                    'member_id' => auth('api')->user()->ref_id,
                    'amount' => ($last_wallet->amount + floatval($input['total_money']) / $transaction->convert_price),
                    'uuid' => uniqid()
                ]);
//                    auth('api')->user()->calculate_expense($last_wallet->amount, $result_sender);
                User::where('ref_id', auth('api')->user()->ref_id)->update([
                    'wallet' => ($last_wallet->amount + floatval($input['total_money']) / $transaction->convert_price)
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Transaction PAIDOUT'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'you dont have Money in your account'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'Transaction not Found'
            ]);
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        random_strings(8);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Member::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
//        $success['name'] =  $user->name;
        return response()->json(['success' => $success], 200);
    }

    public function updateCommission(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'commission' => 'required',
            'ref_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }
        $member = User::where('ref_id', $request['ref_id'])->first();
        if ($member == null) {
            return response()->json([
                'status' => false,
                'message' => 'Member Not Found '
            ]);
        } else {
            error_log($request['commission']);
            $member->update([
                'agent_commission' => $request['commission']
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Commission Has Been Updated'
            ]);
        }
    }

    public function info_member()
    {
        return response()->json([
            'status' => true,
            'member' => User::where('ref_id', auth('api')->user()->ref_id)->first(),
            'country' => Country::where('id', auth('api')->user()->country_id)->first()['name']
        ]);
    }

}
