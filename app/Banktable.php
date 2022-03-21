<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banktable extends Model
{
    //
    protected $fillable = [
        'id',
        'bank_name',
        'bank_type',
    ];

}
