<?php

namespace App\Http\Controllers\Admin;

use App\Models\Membership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class MembershipController extends Controller
{

    public function index()
    {
        return view('admin.membership.index');
    }

    public function create()
    {
        return view('admin.membership.create');
    }


    public function store(Request $request)
    {



        $request->validate([
            'title' => 'required',
            'start' => 'required|date|before:expiration',
            'expiration' => 'required|date|after:start',
            'itemMain' => 'required|image',
            'price' => 'required',
            'discount' => 'required',
            'information' => 'required',
            'vigencia' => 'required',
        ]);




        $price = number_format((float)request('price'), 2, '.', '');
        $percentage = request('discount');
        $price_with_discount = $price - (($price / 100) * $percentage);
        try {
            Membership::create([
                'title' => request('title'),
                'price' => $price,
                'price_with_discount' => $price_with_discount,
                'itemMain' => $request->itemMain ? $request->itemMain->store('portadas', 'public') : null,
                'start' => request('start'),
                'expiration' => request('expiration'),
                'status' => true,
                'discount_percentage' => $percentage,
                'information' => request('information'),
                'vigencia' => request('vigencia'),
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {


            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $membership = Membership::findOrFail($id);
        return view('admin.membership.edit', compact('membership'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'start' => 'required|date|before:expiration',
            'expiration' => 'required|date|after:start',
            'price' => 'required',
            'discount' => 'required',
            'information' => 'required',
            'vigencia' => 'required',
        ]);

        $membership = Membership::findOrFail($id);
        try {
            $newItemMain = request()->file('itemMain');

            if (isset($newItemMain)) {
                File::delete(storage_path("/app/public/{$membership->itemMain}"));
                $itemMain = request()->file('itemMain')->store('portadas', 'public');
            } else {
                $itemMain = $membership->itemMain;
            }


            $price = number_format((float)request('price'), 2, '.', '');
            $percentage = request('discount');
            $price_with_discount = $price - (($price / 100) * $percentage);


            Membership::findOrFail($id)->update([
                'title' => request('title'),
                'price' => $price,
                'price_with_discount' => $price_with_discount,
                'itemMain' => $itemMain,
                'start' => request('start'),
                'expiration' => request('expiration'),
                'status' => true,
                'discount_percentage' => $percentage,
                'information' => request('information'),
                'vigencia' => request('vigencia'),
            ]);
            return back()->with('success', 'El registro se actualizó de manera correcta');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al actualizar el registro - ' . $e->getMessage());
        }
    }
}
