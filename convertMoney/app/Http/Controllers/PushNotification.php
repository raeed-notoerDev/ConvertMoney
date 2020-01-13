<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotification extends Controller
{
    public function clientReceiveMessage()
    {
        return $this->sendPushToClient('$user_id', '$money' . ' ' . trans('api.push.added_money_to_wallet'));
    }

    public function adminReceiveMessage()
    {
        return $this->sendPushToAdmin('$user_id', '$money' . ' ' . trans('api.push.added_money_to_wallet'));
    }

    function WalletMoney($user_id, $money)
    {

        return $this->sendPushToClient($user_id, $money . ' ' . trans('api.push.added_money_to_wallet'));
    }

    public
    function ChargedWalletMoney($user_id, $money)
    {

        return $this->sendPushToClient($user_id, $money . ' ' . trans('api.push.charged_from_wallet'));
    }

    function sendPushToAdmin($admin_id, $push_message)
    {

    }

    function sendPushToClient($client_id, $push_message)
    {

    }
}
