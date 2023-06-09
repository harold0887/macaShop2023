<div class="container-fluid  p-0 ">

    <div class="content-main ">
        @include('includes.spinner-livewire')
        @include('includes.borders')
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('customer.orders')}}">Mis compras</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orden: {{ $order->id }} </li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-rose">

                        <h4 class="card-title h3"><strong>Número de compra: {{ $order->id }}</strong> </h4>
                        <h4></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-secondary mb-5">Estatus de pago:
                                    @if ($order->status == 'approved')
                                    <a class="text-success">
                                        <i class="material-icons">check_circle</i> Aprobado
                                    </a>
                                    @elseif($order->status == 'pending')
                                    <a class="text-warning">
                                        <i class="material-icons">pending</i> Pendiente
                                    </a>
                                    @elseif($order->status == 'in_process')
                                    <a class="text-warning">
                                        <i class="material-icons">watch_later</i> En proceso
                                    </a>
                                    @elseif($order->status == 'cancel')
                                    <a class="text-danger">
                                        <i class="material-icons">cancel</i>Cancelado
                                    </a>
                                    @elseif($order->status == 'refund')
                                    <a class="text-danger">
                                        <i class="material-icons">settings_backup_restore</i>Reembolso
                                    </a>
                                    @else
                                    <a>
                                        <i class="material-icons">warning</i>{{ $order->status }}
                                    </a>
                                    @endif
                                </p>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-shopping">
                                    <thead>
                                        <tr>
                                            <th><b>Producto</b></th>
                                            <th class="pl-5"><b>Acciones</b></th>


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
                                                <span class="h5">{{ $purchase->title }} </span>
                                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                <br><small class="italic text-muted">{{ $purchase->price }} MXN </small>
                                            </td>


                                            <td>
                                                <div class="col-12   align-self-center">
                                                    @if ($order->status == 'approved')

                                                    <div wire:loading.remove>
                                                        <button class="btn btn-outline-info btn-round" wire:click="finalDownload({{ $purchase->id }},{{ $purchase->order_id }})" wire:loading.attr="disabled">
                                                            <i class="material-icons">download</i> Descargar
                                                        </button>
                                                        <button class="btn btn-outline-primary btn-round btn-link " wire:click="sendEmail({{ $purchase->id }},{{ $purchase->order_id }})">
                                                            Enviar a email
                                                        </button>

                                                    </div>
                                                    <button class="btn btn-outline-primary btn-round " disabled wire:loading wire:target="sendEmail">
                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                        enviando...
                                                    </button>

                                                    <button class="btn btn-outline-info btn-round " disabled wire:loading wire:target="finalDownload">
                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                        Descargando...
                                                    </button>
                                                    @else

                                                    <button class="btn btn-outline-primary btn-round" disabled>
                                                        <i class=" material-icons">file_download</i>
                                                        No disponible
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>



                                        </tr>
                                        @endforeach
                                        @endif

                                        @if (isset($packages) && $packages->count() > 0)
                                        @foreach ($packages as $package)
                                        <tr>
                                            <td>
                                                <div class="img-container ">
                                                    <img src="{{ Storage::url($package->itemMain) }}" alt="{{ $package->title }}">
                                                </div>
                                                <span class="h5">{{ $package->title }} </span>
                                                <br><small>Membresía </small>
                                                <br><small class="italic text-muted">{{ $package->price }} MXN </small>
                                            </td>
                                            <td>
                                                <div class="col-12   align-self-center">
                                                    @if ($order->status == 'approved')
                                                    <a href="{{ route('customer.packages-show',['order' => $order->id,'id'=>$package->id]) }}" class="btn btn-outline-primary btn-round ">
                                                        Ver materiales
                                                    </a>
                                                    @else
                                                    <button class="btn btn-outline-primary btn-round" disabled>
                                                        <i class="material-icons">visibility_off</i> Ver materiales
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif

                                        @if (isset($memberships) && $memberships->count() > 0)
                                        @foreach ($memberships as $membership)

                                        <tr>
                                            <td>
                                                <div class="img-container ">
                                                    <img src="{{ Storage::url($membership->itemMain) }}" alt="{{ $membership->title }}">
                                                </div>
                                                <span class="h5">{{ $membership->title }} </span>
                                                <br><small>Membresía </small>
                                                <br><small class="italic text-muted">{{ $membership->price }} MXN </small>
                                            </td>



                                            <td>
                                                <div class="col-12 ">
                                                    @if ($order->status == 'approved')
                                                    @if ($membership->expiration > now())
                                                    <a href="{{ route('customer.membership-show', ['order' => $order->id,'id'=>$membership->id]) }}" class="btn btn-outline-primary btn-round">
                                                        Ver materiales
                                                    </a>
                                                    @else
                                                    <button class="btn btn-outline-danger btn-round" disabled>
                                                        <i class="material-icons">visibility_off</i> La membresía ha expirado
                                                    </button>
                                                    @endif
                                                    @else
                                                    <button class="btn btn-outline-primary btn-round" disabled>
                                                        <i class="material-icons">visibility_off</i> Ver materiales
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        @include('includes.borders')
    </div>
</div>