<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'transaction_id',
        'message',
        'sender_id',
        'receiver_id',
        'delivered'
    ];
}
