<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable =[
        'full_name',
        'uuid',
        'phone_number',
        'passport_number',
        'id_number',
        'address',
        'birthday',
        'nationality',
        'gender',
        'profession',
    ];
}
