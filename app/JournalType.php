<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalType extends Model
{
    //
    //
    protected $fillable=[
        'id',
        'name',
    ];
    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

}
