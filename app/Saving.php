<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array[] $array)
 */
class Saving extends Model
{
    //
    protected $fillable = [
        'id',
        'user_id',
        'amount_saved',
        'month',
        'description',
        'amount_withdrawn',
        'status',
        'ippis_no'
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
}
