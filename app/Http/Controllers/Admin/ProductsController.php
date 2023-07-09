<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Grade;
use App\Models\Product;
use App\Models\Category;
use App\Models\Membership;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }


    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->get();
        $degrees = Grade::orderBy('name', 'ASC')
            ->select('name', 'id')
            ->get();
        $memberships = Membership::orderBy('title', 'ASC')
            ->select('title', 'id','vigencia')
            ->where('status', true)
            ->get();
        return view('admin.products.create', compact('categories', 'memberships', 'degrees'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'unique:products'],
            'document' => 'required|mimes:pdf,ppt,pptx',
            'itemMain' => 'required|image',
            'price' => 'required',
            'discount' => 'required',
            'grade' => 'required',
            'information' => 'required',
            'items.*' => 'required|image',
        ]);




        $price = number_format((float)request('price'), 2, '.', '');
        $percentage = request('discount');
        $price_with_discount = $price - (($price / 100) * $percentage);


        try {


            $nuevoProducto = Product::create([
                'title' => request('title'),
                'price' => $price,
                'price_with_discount' => $price_with_discount,
                'information' => request('information'),
                'grade' => request('grade'),
                'itemMain' => $request->itemMain ? $request->itemMain->store('portadas', 'public') : null,
                'document' => $request->document ? $request->document->store('documents', 'public') : null,
                'video' => $request->video ? $request->video->store('videos', 'public') : null,
                'name' => request()->file('document')->getClientOriginalName(),
                'slug' => Str::slug(request('title'), '-'),
                'format' => request()->file('document')->getClientOriginalExtension(),
                'discount_percentage' => $percentage,
                'status' => true
            ]);

            $nuevoProducto->membresias()->sync(request('memberships'));

            $nuevoProducto->categorias()->sync(request('categories'));

            foreach (request('items') as $item) {
                Item::create([
                    'photo' => $item->store('items', 'public'),
                    'products_id' => $nuevoProducto->id
                ]);
            }




            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {

            return back()->with('error', 'Error al guardar el registro - ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }


    public function edit($id)
    {
        $categories = Category::orderBy('name')
            ->select('name', 'id')
            ->get();
        $degrees = Grade::orderBy('name')
            ->select('name', 'id')
            ->get();
        $memberships = Membership::orderBy('title')
            ->select('title', 'id','vigencia')
            ->where('status', true)
            ->get();
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product', 'categories', 'degrees', 'memberships'));
    }

    public function update(Request $request, $id)
    {


        $request->validate([
            'title' => ['required'],
            'price' => 'required',
            'discount' => 'required',
            'grade' => 'required',
            'information' => 'required',
            'items.*' => 'image',
            'disponible' => 'required|date',

        ]);

        //dd($request);

        $product = Product::findOrFail($id);
        $newDocument = request()->file('document');
        $newItemMain = request()->file('itemMain');
        $newVideo = request()->file('video');

        $price = number_format((float)request('price'), 2, '.', '');
      
        

        if (isset($newItemMain)) {
            File::delete(storage_path("/app/public/{$product->itemMain}"));
            $itemMain = $newItemMain->store('portadas', 'public');
        } else {
            $itemMain = $product->itemMain;
        }
        if (isset($newDocument)) {
            File::delete(storage_path("/app/public/{$product->document}"));
            $document = $newDocument->store('documents', 'public');
            $name = $newDocument->getClientOriginalName();
            $ext = $newDocument->getClientOriginalExtension();
        } else {
            $document = $product->document;
            $name = $product->name;
            $ext = $product->format;
        }

        if (isset($newVideo)) {
            if ($product->video) {
                File::delete(storage_path("/app/public/{$product->video}"));
            }

            $video = $newVideo->store('videos', 'public');
        } else {

            $video = $product->video;
        }



        try {
            Product::findOrFail($id)->update([
                'title' => request('title'),
                'price' => $price,
                'price_with_discount' => request('discount'),
                'information' => request('information'),
                'grade' => request('grade'),
                'itemMain' => $itemMain,
                'document' => $document,
                'video' => $video,
                'name' => $name,
                'slug' => Str::slug(request('title'), '-'),
                'format' => $ext,
            
                'fecha_membresia' => request('disponible'),
            ]);

            $product->membresias()->sync(request('memberships'));

            $product->categorias()->sync(request('categories'));


            if (request('items') != null) {

                foreach (request('items') as $item) {
                    Item::create([
                        'photo' => $item->store('items', 'public'),
                        'products_id' => $product->id
                    ]);
                }
            }


            return back()->with('success', 'El registro se actualizó de manera correcta');
        } catch (QueryException $e) {

            return back()->with('error', 'Error al actualizar el registro - ' . $e->getMessage());
        }
    }
}
