@extends('layouts.app',[
'title'=>'Mis paquetes',
'navbarClass'=>'navbar-transparent',
'activePage'=>'packages',
'menuParent'=>'orders',
])
@section('content')


<div class="container-fluid  p-0 ">

    <div class="content-main ">

        @include('includes.borders')
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customer.orders')}}">Mis compras</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Paquetes</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <h4 class="card-title h3"><strong>Mis paquetes</strong> </h4>
            </div>
            <div class="col-12">
                <div class="card mt-0">

                    <div class="card-body  px-0">
                        @if (isset($packages) && $packages->count() > 0)
                        <div class="table-responsive px-0">
                            <table class="table table-hover table-shopping">
                                <thead>
                                    <tr>
                                        <th><b>Acciones</b></th>
                                        <th><b>Nombre del paquete</b></th>
                                        <th><b>Fecha de compra</b></th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($packages as $package)
                                    <tr>
                                        <td>
                                            <a href="{{ route('customer.packages-show',['order' => $package->order_id,'id'=>$package->package_id]) }}" class=" text-white btn  btn-primary rounded">
                                                <span>Ver detalle</span>
                                            </a>
                                        </td>

                                        <td>{{ $package->title }}</td>
                                        <td>
                                            {{date_format($package->created_at, 'd-M-Y')}}
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="col-12">
                            <span class="h4 text-muted">Visite la <a href=" {{route('paquete')}} ">tienda</a> para comprar su primer paquete de materiales didácticos. <span>
                        </div>
                      
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('includes.borders')
    </div>
</div>








@endsection