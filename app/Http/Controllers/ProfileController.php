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
namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }


    //actualizar foto de perfil
    public function update(ProfileRequest $request)
    {

        auth()->user()->update(
            $request->merge(['picture' => $request->photo ? $request->photo->store('profile', 'public') : null])
                ->except([$request->hasFile('photo') ? '' : 'picture'])
        );

        return back()->with('success', "Perfil actualizado con éxito");
    }

    //actualizar contraseña
    public function password(PasswordRequest $request)
    {


        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->with('success', "Contraseña actualizada con éxito");

    }
}
