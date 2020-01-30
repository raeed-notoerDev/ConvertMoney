<?php

namespace App\Http\Controllers\API;

use App\Beneficiary;
use App\Country;
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

    public function filter_transactions_client(Request $request)
    {
        try {
            $query = DB::table('users')
                ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                ->select('transactions.*');
            if ($request['date_from'] !== 'all') {
                $query->where('transactions.created_at', '>=', $request['date_from']);
            }
            if ($request['date_to'] !== 'all') {
                $query->where('transactions.created_at', '<=', $request['date_to']);
            }
            if ($request['status'] !== 'all') {
                $query->where('transactions.status', $request['status']);
            }
            $query->where('agent_id_sender', auth('api')->user()->ref_id)->orWhere('agent_id_receiver', auth('api')->user()->ref_id);
            return response()->json($this->list_transaction($query->get()));

        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function filter_transactions(Request $request)
    {
        try {
            $query = DB::table('users')
                ->join('transactions', 'users.ref_id', '=', 'transactions.agent_id_sender')
                ->join('countries', 'transactions.receiver_country_id', '=', 'countries.name')
                ->select('transactions.*');
            if ($request['date_from'] !== 'all') {
                $query->where('transactions.created_at', '>=', $request['date_from']);
            }
            if ($request['date_to'] !== 'all') {
                $query->where('transactions.created_at', '<=', $request['date_to']);
            }
            if ($request['status'] !== 'all') {
                $query->where('transactions.status', $request['status']);
            }
            if ($request['agent'] !== 'all') {
                $query->where('agent_id_sender', $request['agent'])->orWhere('agent_id_receiver', $request['agent']);
            }
            return response()->json($this->list_transaction($query->get()));

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
                'city_destination' => $transactions[$i]->receiver_country_id,
                'status' => $transactions[$i]->status,
                'date' => $transactions[$i]->created_at,
                'convert_price' => $transactions[$i]->convert_price,
            ]);
        }
        return $myArray;
    }
}
