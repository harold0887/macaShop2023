<?php
/*

=========================================================
* Argon Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/
namespace App;


use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
 
    
    protected $fillable = [
        'name', 'email', 'password', 'picture' ,'role_id','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

   
    public function profilePicture()
    {
        if ($this->picture) {
            return "/storage/{$this->picture}";
        }

        return 'http://i.pravatar.cc/200';
    }

   //relacion con comentarios, retorna los comentarios de un usuario
   public function comentarios()
   {
     return $this->hasMany('App\Models\Comment');
   }


    //relacion con ordenes, retorna las ordenes de un usuario
    public function orders()
    {
      return $this->hasMany('App\Models\Order');
    }
   
}
