<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    use HasFactory;
    protected $guarded = [];
    //relacion con usuarios, retorna el usuario al que pertenece la orden
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
