<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_Details extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_details';


    //Relacion muchos a muchos con productos
    // public function products()
    // {
    //     return $this->belongsToMany('App\Models\Product')
    //         ->orderBy('title', 'asc');
    // }


    //recupera la orden a la que pertenece
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
