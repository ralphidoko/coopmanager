<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Application extends Model
{

    public $incrementing = true;

    /*protected static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->id = Str::uuid();
        });
    }*/

    protected $fillable = [
        'user_id',
        'status',
        'type'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
