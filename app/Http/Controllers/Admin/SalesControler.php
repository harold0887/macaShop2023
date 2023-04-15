<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class SalesControler extends Controller
{

    public function index()
    {
        return view('admin.sales.index');
    }


    public function create()
    {
        $users = User::all();
        return view('admin.sales.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required',
            'price' => 'required',
            'type' => 'required',
            'user' => 'required',
        ]);

        //obtener al comprador
        $customer = User::findOrFail(request('user'));
        try {

            Order::create([
                'customer_id' => $customer->id,
                'amount' => request('price'),
                'status' => 'approved',
                'payment_type' => request('type'),
                'payment_id' => request('order'),
                'order_id' => request('order')
            ]);
            return back()->with('success', 'Registro exitoso');
        } catch (QueryException $e) {
            return back()->with('error', 'Error al guardar el registro - ' .  $e->getMessage());
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
