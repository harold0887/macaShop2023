<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }



    public function edit($id)
    {
        $roles = DB::table('roles')
            ->select('name', 'id')
            ->get();

        $user = User::leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'roles.name as role')
            ->findOrFail($id);



        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {


        $request->validate([
            'roles' => ['required'],
        ]);






        if (Auth::id() == $user->id) {
            return back()->with('error', 'No pudes modificar tu propia cuenta');
        }
        try {

            $user->syncRoles(request('roles'));

            $user->update([
                'facebook' => request('facebook'),
                'whatsapp' => request('whatsapp'),
            ]);


            return back()->with('success', 'El registro se actualizo de manera correcta');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al modificar al usuario - ' . $e->getMessage());
        }
    }
}
