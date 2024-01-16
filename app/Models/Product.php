<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
  use HasFactory;

  protected $guarded = [];



  //relacion con items, retorna las fotos del producto
  public function items()
  {
    return $this->hasMany(Item::class, 'products_id')->orderBy('created_at','desc');
  }

  //relacion con grado, retorna el grado al que pertenece
  public function grado()
  {
    return $this->belongsTo(Grade::class, 'grade');
  }

  //relacion con categoria, retorna el grado al que pertenece
  // public function categoria()
  // {
  //   return $this->belongsTo(Category::class, 'category');
  // }


  //Relacion muchos a muchos con paquete
  public function package()
  {
    return $this->belongsToMany('App\Models\Package')->orderBy('name','desc');
  }

  //Relacion muchos a muchos con membresias
  public function membresias()
  {
    return $this->belongsToMany('App\Models\Membership');
  }


  //Relacion muchos a muchos con membresias
  public function categorias()
  {
    return $this->belongsToMany('App\Models\Category');
  }



  //relacion con comentarios, retorna los comentarios de un producto
  public function comentarios()
  {
    return $this->hasMany(Comment::class)->orderBy('created_at','desc');

  }


  //relacion con grados, retorna los grados de un producto
  public function grados()
  {
    return $this->hasMany(Grade::class);
  }

   //relacion con descargas, retorna las descargas de un producto
  public function descargas()
  {
    return $this->hasMany(Descarga::class,'id_product');
  }

  //Relacion muchos a muchos con membresias
  public function orders()
  {
    return $this->hasMany('App\Models\Order_Details');
  }

   //Relacion con ventas, retorna las ventas del producto
   public function sales(): HasMany
   {
       return $this->hasMany(Order_Details::class, 'product_id', 'id');
   }

   
}
