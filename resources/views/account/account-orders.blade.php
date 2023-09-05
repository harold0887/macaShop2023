@extends('layouts.app',[
'title'=>'Mis compras',
'navbarClass'=>'navbar-transparent',
'activePage'=>'orders',
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
                        <li class="breadcrumb-item"><a href="{{route('profile.edit')}}">Cuenta</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mis compras</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <h4 class="card-title h3"><strong>Mis compras</strong> </h4>
            </div>
            <div class="col-12">
                <div class="card mt-0" id="orders">

                    <div class="card-body  px-0">
                        @if (isset($orders) && $orders->count() > 0)
                        <div class="table-responsive px-0">
                            <table class="table table-hover table-shopping">
                                <thead>
                                    <tr>
                                        <th><b>Acciones</b></th>
                                        <th><b>Estatus de pago</b></th>
                                        <th><b># Compra</b></th>
                                        <th><b>Fecha</b></th>
                                        <th><b>Cantidad</b></th>
                                        <th><b>Pago</b></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('order.show', $order->id) }}" class=" text-white btn  btn-primary rounded">
                                                <span>Ver detalle</span>
                                            </a>
                                        </td>
                                        <td>
                                            @if($order->status == 'create')
                                            <span class="d-block d-flex text-warning"><i class="material-icons">pending_actions</i>Pendiente de pago.</span>
                                            @elseif ($order->status == 'approved')
                                            <span class="d-block d-flex text-success"><i class="material-icons">check_circle</i>Aprobado</span>

                                            @elseif($order->status == 'pending')
                                            <span class="d-block d-flex text-warning"><i class="material-icons">pending</i> Pendiente de confirmación.</span>

                                            @elseif($order->status == 'in_process')
                                            <span class="d-block d-flex text-warning"><i class="material-icons">watch_later</i> En proceso</span>

                                            @elseif($order->status == 'cancel')
                                            <span class="d-block d-flex text-danger"><i class="material-icons">cancel</i>Cancelado</span>

                                            @elseif($order->status == 'refund')
                                            <span class="d-block d-flex text-danger"><i class="material-icons">settings_backup_restore</i>Reembolso</span>

                                            @else
                                            <span class="d-block d-flex text-danger"><i class="material-icons">warning</i>{{ $order->status }}</span>

                                            @endif
                                        </td>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            {{date_format($order->created_at, 'd-M-Y H:i')}}
                                        </td>
                                        <td>{{ $order->amount }}</td>
                                        <td>{{ $order->payment_type }}</td>


                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="col-12">
                            <span class="h4 text-muted">Aún no ha realizado ninguna compra, visite la <a href=" {{route('paquete')}} ">tienda</a> para comprar su primer producto. <span>
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