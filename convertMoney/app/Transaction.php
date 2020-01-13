<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code',
        'total_money',
        'sender_beneficiary_id',
        'receiver_beneficiary_id',
        'commission',
        'receiver_country_id',
        'currency_receiver_id',
        'currency_sender_id',
        'status',
        'convert_price',
        'agent_id_sender',
        'destination_country_id',
        'photos',
    ];

    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
