@extends('layouts.app',[
'title'=>'Mis membresías',
'navbarClass'=>'navbar-transparent',
'activePage'=>'memberships',
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
                        <li class="breadcrumb-item active" aria-current="page">Membresías</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <h4 class="card-title h3"><strong>Mis membresías</strong> </h4>
            </div>
            <div class="col-12">
                <div class="card mt-0">

                    <div class="card-body  px-0">
                        @if (isset($memberships) && $memberships->count() > 0)
                        <div class="table-responsive px-0">
                            <table class="table table-hover table-shopping">
                                <thead>
                                    <tr>
                                        <th><b>Acciones</b></th>
                                        <th><b>Nombre</b></th>
                                        <th><b>Estatus</b></th>
                                        <th><b>Expiracion</b></th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($memberships as $membership)
                                    <tr>

                                        <td>
                                            @if ($membership->expiration > now())
                                            <a href="{{ route('customer.membership-show', ['order' => $membership->order_id,'id'=>$membership->membership_id]) }}" class=" text-white btn  btn-primary rounded">
                                                <span>Ver detalle</span>
                                            </a>
                                            @else
                                            <button class="text-white btn  btn-primary rounded" disabled>
                                                <span>Ver detalle</span>
                                            </button>

                                            @endif

                                        </td>

                                        <td>{{ $membership->title }}</td>

                                        @if ($membership->expiration > now())
                                        <td>
                                            <span class="d-flex d-block text-success"><i class="material-icons">check_circle</i> Vigente</span>

                                        </td>

                                        @else
                                        <td>
                                            <span class="d-flex d-block text-danger"><i class="material-icons">cancel</i>Expirada</span>

                                        </td>

                                        @endif
                                        <td>
                                            {{date_format(new DateTime($membership->expiration),'d-M-Y')}}
                                        </td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="col-12">
                            <span class="h4 text-muted">Visite la <a href=" {{route('membership')}} ">tienda</a> para comprar su primera membresía. <span>
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