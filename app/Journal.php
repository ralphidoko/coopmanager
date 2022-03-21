<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    //
    protected $fillable=[
        'id',
        'name',
        'type_id',
        'code',
        'allow_cancellation_entries'
    ];

    public function types()
    {
        return $this->belongsTo(JournalType::class,'type_id');
    }
}
