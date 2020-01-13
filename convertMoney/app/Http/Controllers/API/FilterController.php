<?php

namespace App\Http\Controllers\API;

use App\Beneficiary;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class FilterController extends Controller
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

    public function filter_transactions(Request $request)
    {
        try {
            if ($request['date_from'] !== 'all') {
                if ($request['date_to'] !== 'all') {
                    if ($request['status'] !== 'all') {
                        if ($request['agent'] !== 'all') {
                            $transactions = DB::table('users')
                                ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                                ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                                ->select('transactions.*')
                                ->where('transactions.created_at', '>=', $request['date_from'])
                                ->where('transactions.created_at', '<=', $request['date_to'])
                                ->where('transactions.status', $request['status'])
                                ->where('transactions.agent_id_sender', $request['agent'])
                                ->where('transactions.agent_id_receiver', $request['agent'])
                                ->get();
                            return response()->json($this->list_transaction($transactions));
                        }
                        $transactions = DB::table('users')
                            ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                            ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                            ->select('transactions.*')
                            ->where('transactions.created_at', '>=', $request['date_from'])
                            ->where('transactions.created_at', '<=', $request['date_to'])
                            ->where('transactions.agent_id_sender', $request['agent'])
                            ->where('transactions.agent_id_receiver', $request['agent'])
                            ->get();
                        return response()->json($this->list_transaction($transactions));

                    }
                    if ($request['agent'] !== 'all') {
                        $transactions = DB::table('users')
                            ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                            ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                            ->select('transactions.*')
                            ->where('transactions.created_at', '>=', $request['date_from'])
                            ->where('transactions.created_at', '<=', $request['date_to'])
                            ->where('transactions.agent_id_sender', $request['agent'])
                            ->where('transactions.agent_id_receiver', $request['agent'])
                            ->get();
                        return response()->json($this->list_transaction($transactions));
                    }
                    $transactions = DB::table('users')
                        ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                        ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                        ->select('transactions.*')
                        ->where('transactions.created_at', '>=', $request['date_from'])
                        ->where('transactions.created_at', '<=', $request['date_to'])
                        ->get();
                    return response()->json($this->list_transaction($transactions));
                }
                $transactions = DB::table('users')
                    ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                    ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                    ->select('transactions.*')
                    ->where('transactions.created_at', '>=', $request['date_from'])
                    ->get();
                return response()->json($this->list_transaction($transactions));

            }
            elseif ($request['date_to'] !== 'all') {
                if ($request['status'] !== 'all') {
                    if ($request['agent'] !== 'all') {
                        $transactions = DB::table('users')
                            ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                            ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                            ->select('transactions.*')
                            ->where('transactions.created_at', '<=', $request['date_to'])
                            ->where('transactions.status', $request['status'])
                            ->where('transactions.agent_id_sender', $request['agent'])
                            ->where('transactions.agent_id_receiver', $request['agent'])
                            ->get();
                        return response()->json($this->list_transaction($transactions));
                    }
                    $transactions = DB::table('users')
                        ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                        ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                        ->select('transactions.*')
                        ->where('transactions.created_at', '<=', $request['date_to'])
                        ->where('transactions.status', $request['status'])
                        ->get();
                    return response()->json($this->list_transaction($transactions));
                }
                $transactions = DB::table('users')
                    ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                    ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                    ->select('transactions.*')
                    ->where('transactions.created_at', '<=', $request['date_to'])
                    ->get();
                return response()->json($this->list_transaction($transactions));
            }
            elseif ($request['status'] !== 'all') {
                if ($request['agent'] !== 'all') {
                    $transactions = DB::table('users')
                        ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                        ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                        ->select('transactions.*')
                        ->where('transactions.status', $request['status'])
                        ->where('transactions.agent_id_sender', $request['agent'])
                        ->where('transactions.agent_id_receiver', $request['agent'])
                        ->get();
                    return response()->json($this->list_transaction($transactions));
                }
                $transactions = DB::table('users')
                    ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                    ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                    ->select('transactions.*')
                    ->where('transactions.status', $request['status'])
                    ->get();
                return response()->json($this->list_transaction($transactions));
            }
            elseif ($request['agent'] !== 'all') {
                $transactions = DB::table('users')
                    ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                    ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                    ->select('transactions.*')
                    ->where('transactions.agent_id_sender', $request['agent'])
                    ->where('transactions.agent_id_receiver', $request['agent'])
                    ->get();
                return response()->json($this->list_transaction($transactions));
            }
            $transactions = DB::table('users')
                ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                ->select('transactions.*', 'countries.*')
                ->get();
            return response()->json($this->list_transaction($transactions));

        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    function list_transaction($transactions)
    {
        $myArray = [];
        for ($i = 0; $i < $transactions->count(); $i++) {
            array_push($myArray, (object)[
                'code' => $transactions[$i]->code,
                'total_money' => $transactions[$i]->total_money,
                'sender_consumer_name' => Beneficiary::where('id_number', $transactions[$i]->sender_beneficiary_id)->first()['full_name'],
                'receiver_consumer_name' => Beneficiary::where('id_number', $transactions[$i]->receiver_beneficiary_id)->first()['full_name'],
                'tax' => $transactions[$i]->tax,
                'commission' => $transactions[$i]->commission,
                'currency_sender_id' => $transactions[$i]->currency_sender_id,
                'currency_receiver_id' => $transactions[$i]->currency_receiver_id,
                'agent_sender' => User::where('ref_id', $transactions[$i]->agent_id_sender)->first()['first_name'] . '   ' . User::where('ref_id', $transactions[$i]->agent_id_sender)->first()['last_name'],
                'agent_receiver' => User::where('ref_id', $transactions[$i]->agent_id_receiver)->first()['first_name'] . '   ' . User::where('ref_id', $transactions[$i]->agent_id_receiver)->first()['last_name'],
                'city_destination' => $transactions[$i]->name,
                'status' => $transactions[$i]->status,
                'date' => $transactions[$i]->created_at,
                'convert_price' => $transactions[$i]->convert_price,
            ]);
        }
        return $myArray;
    }
}
