<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'amount',
        'amount_minis',
        'amount_plus',
        'member_id',
        'uuid',
        'calculate',
    ];

    public function user()
    {
        return $this->belongsTo('App\User','member_id');
    }
}
