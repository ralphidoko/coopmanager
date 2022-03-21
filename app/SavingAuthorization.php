<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SavingAuthorization extends Model
{
    //

    public $incrementing = true;

//    protected static function boot()
//    {
//        parent::boot();
//        static::creating(function($model){
//            $model->id = Str::uuid();
//        });
//    }

    protected $fillable = [
        'user_id',
        'current_amount',
        'desired_amount',
        'start_date',
        'auth_type',
        'auth_text',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
}
