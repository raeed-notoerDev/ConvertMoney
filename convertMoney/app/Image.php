<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['uuid', 'path', 'transaction_id', 'name'];

    public function transfer()
    {
        return $this->belongsTo('App\Transaction');
    }
}
