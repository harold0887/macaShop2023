@extends('layouts.app',[
'title'=>'Ventas',
'navbarClass'=>'navbar-transparent',
'activePage'=>'sales',
])
@section('content')
<div class="content pt-0">
<div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-shopping">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="2"><b>Producto</b></th>
                            <th class="th-description"><b>Precio</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($purchases) && $purchases->count() > 0)
                        @foreach ($purchases as $purchase)
                        <tr>
                            <td>
                                <div class="img-container ">
                                    <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                </div>
                            </td>
                            <td class="td-name">
                                <span>{{ $purchase->title }} </span>
                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                            </td>
                            <td>{{ $purchase->price }} </td>
                        </tr>
                        @endforeach
                        @endif
                        @if (isset($packages) && $packages->count() > 0)
                        @foreach ($packages as $package)
                        <tr>
                            <td>
                                <div class="img-container ">
                                    <img src="{{ Storage::url($package->itemMain) }}" alt="...">
                                </div>
                            </td>
                            <td class="td-name">
                                <span>{{ $package->title }} </span>
                                <br><small>Paquete</small>
                            </td>
                            <td>{{ $package->price }} </td>

                        </tr>
                        @endforeach
                        @endif
                        @if (isset($memberships) && $memberships->count() > 0)
                        @foreach ($memberships as $membership)
                        <tr>
                            <td>
                                <div class="img-container ">
                                    <img src="{{ Storage::url($membership->itemMain) }}" alt="...">
                                </div>
                            </td>
                            <td class="td-name">
                                <span>{{ $membership->title }} </span>
                                <br><small>Membresia</small>
                            </td>
                            <td>{{ $membership->price }} </td>

                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
@include('includes.alert-error')