<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

     //Relacion muchos a muchos con productos
     public function products()
     {
         return $this->belongsToMany('App\Models\Product')
         ->orderBy('title','asc');
     }
}
