<?php

namespace App\Http\Controllers\API;

use App\Chat;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class ChatController extends Controller
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
            $validator = Validator::make($request->all(), [
                'message' => 'required',
                'receiver_id' => 'required',
                'transaction_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            Chat::create([
                'transaction_id' => $request['transaction_id'],
                'message' => $request['message'],
                'receiver_id' => $request['receiver_id'],
                'sender_id' => auth('api')->user()->ref_id,
                'delivered' => false
            ]);
            return response()->json([
                'status' => true
            ]);
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

    public function showMessage($code)
    {
        $messages = Chat::where('transaction_id', $code)->get();
//        $messages_receiver = Chat::where('transaction_id', $code)->where('receiver_id', auth('api')->user()->ref_id)->get();
        return response()->json([
            'list_messages' => $this->list_messages($messages),
            'ref_id' => auth('api')->user()->ref_id,
            'receiver_id' => Chat::where('transaction_id', $code)->where('receiver_id', '<>', auth('api')->user()->ref_id)->first()['receiver_id']
        ]);
    }

    function list_messages($messages_sender)
    {
        $myArray = [];
        for ($i = 0; $i < $messages_sender->count(); $i++) {
            array_push($myArray, (object)[
                'id' => $messages_sender[$i]->id,
                'date' => $messages_sender[$i]->created_at,
                'message' => $messages_sender[$i]->message,
                'sender_id' => $messages_sender[$i]->sender_id,
                'receiver_id' => $messages_sender[$i]->receiver_id
            ]);
        }
        return $myArray;
    }
}
