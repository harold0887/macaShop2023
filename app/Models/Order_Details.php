<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Details extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_details';


     //Relacion muchos a muchos con productos
     public function products()
     {
         return $this->belongsToMany('App\Models\Product')
         ->orderBy('title','asc');
     }



     
}
