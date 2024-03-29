<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    //relacion con usuarios, retorna el usuario al que pertenece la orden
    public function user()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    //Relacion muchos a muchos
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_details');
    }
    //Relacion muchos a muchos paquetes
    public function Packages()
    {
        return $this->belongsToMany('App\Models\Package', 'order_details');
    }

    //Relacion muchos a muchos membresias
    public function memberships()
    {
        return $this->belongsToMany('App\Models\Membership', 'order_details');
    }

    //Relacion con detalle de orden, retorna las ventas del producto
    public function sales(): HasMany
    {
        return $this->hasMany(Order_Details::class, 'order_id', 'id');
    }
}
