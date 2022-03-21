<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    protected $fillable=[
        'id',
        'name',
        'fees_amount',
    ];
}
