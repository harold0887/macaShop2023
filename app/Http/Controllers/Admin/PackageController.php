<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;

class PackageController extends Controller
{

    public function index()
    {
        return view('admin.package.index');
    }


    public function create()
    {
        return view('admin.package.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
            'itemMain' => 'required|image',
            'discount' => 'required',
        ]);


        $price = number_format((float)request('price'), 2, '.', '');
        $percentage = request('discount');
        $price_with_discount = $price - (($price / 100) * $percentage);

        try {
            Package::create([
                'title' => request('title'),
                'price' => request('price'),
                'itemMain' => $request->itemMain ? $request->itemMain->store('portadas', 'public') : null,
                'status' => true,
                'price_with_discount' => request('price'),
                'discount_percentage' => $percentage,
                'price_with_discount' => $price_with_discount,
                //'codeSend' => 'Package'
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el paquete - ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.package.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'price' => 'required',
        ]);

        $package = Package::findOrFail($id);
        $newItemMain = request()->file('itemMain');
        if (isset($newItemMain)) {
            File::delete(storage_path("/app/public/{$package->itemMain}"));
            $itemMain = $newItemMain->store('portadas', 'public');
        } else {
            $itemMain = $package->itemMain;
        }
        try {
            Package::findOrFail($id)->update([
                'title' => request('title'),
                'itemMain' => $itemMain,
                'price' => request('price')
            ]);
            return back()->with('success', 'El paquete se actualizo de manera correcta');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al actualizar el paquete - ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        //
    }
}
