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
                        <li class="breadcrumb-item"><a href="{{route('customer.memberships')}}">Membresias</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$membership->title}}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6">
                <h4 class="card-title h3"><strong>{{$membership->title}}</strong> </h4>
            </div>
            <div class="col-12 col-md-6   d-flex align-items-end justify-content-md-end ">
                <div class="form-row ">

                    <div class="form-group col-12 ">

                        <label class="ms-0 h4">Ordenar por:</label>
                        <select class="form-control h4">
                            <option wire:click="setSort('created_at', 'asc')" {{$sortDirection=='asc' && $sortField=='created_at' ? 'selected' :''}}>Fecha (A-Z)</option>
                            <option wire:click="setSort('created_at', 'desc')" {{$sortDirection=='desc' && $sortField=='created_at' ? 'selected' :''}}>Fecha (Z-A)</option>
                            <option wire:click="setSort('title', 'asc')" {{$sortDirection=='asc' && $sortField=='title' ? 'selected' :''}}>Nombre (A-Z)</option>
                            <option wire:click="setSort('title', 'desc')" {{$sortDirection=='desc' && $sortField=='title' ? 'selected' :''}}>Nombre (Z-A)</option>
                            <option wire:click="setSort('numero', 'asc')" {{$sortDirection=='asc' && $sortField=='numero' ? 'selected' :''}}>Número (A-Z) - Predeterminado</option>
                            <option wire:click="setSort('numero', 'desc')" {{$sortDirection=='desc' && $sortField=='numero' ? 'selected' :''}}>Número (Z-A)</option>

                        </select>
                    </div>

                </div>


            </div>

            @if($order->active == 0)

            <div class="col-12">
                <small>Esta membresía requiere activación.</small>
                <br>
                <small>
                    Da clic en el logo de WhatsApp para enviar un mensaje y solicitar la activación.
                </small>
                <br>
                <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20membres%C3%ADa%20{{$membership->title}}%20-%20compra%20web: {{ $order->id }} - {{auth()->user()->email}} " target="_blank">
                    <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                </a>
            </div>

            @else

            <div class="col-12">
                <div class="card mt-0" id="orders">

                    <div class="card-body  px-0">
                        @if (isset($membership) && $membership->count() > 0)


                        <div class="table-responsive px-0">
                            <table class="table table-hover table-shopping">
                                <thead>
                                    <tr>
                                        <th><b>Producto</b></th>
                                        <th class="pl-5"><b>Acciones</b></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $purchase)
                                    <tr>

                                        <td>
                                            <div class="img-container ">
                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                            </div>
                                            <span class="h5" data-mdb-toggle="modal"><small>{{ $purchase->numero}}_{{$purchase->title }} </small></span>
                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                            <!-- <br><small class="italic text-muted">{{ $purchase->price }} MXN </small> -->
                                        </td>
                                        <td>



                                            @if(now() >= $purchase->fecha_membresia)
                                            <div class="col-12 ">

                                                @if($purchase->folio == 1 && $order->active == 0 )
                                                <small>Este documento requiere activación.</small>
                                                <br>
                                                <small>
                                                    Da clic en el logo de WhatsApp para enviar un mensaje y solicitar la activación.
                                                </small>
                                                <br>
                                                <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $order->id }}" target="_blank">
                                                    <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                </a>


                                                @else
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
                                                @endif
                                            </div>
                                            @else
                                            <div class="col-12 ">
                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                    Disponible próximamente
                                                </button>
                                            </div>

                                            @endif







                                        </td>

                                    </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>

                        @else
                        <div class="col-12">
                            <span class="h4 text-muted">Aún no ha realizado ninguna compra, visite la <a href=" {{route('shop')}} ">tienda</a> para comprar su primer producto. <span>
                        </div>


                        @endif

                    </div>
                </div>
            </div>


            @endif











        </div>
        @include('includes.borders')
    </div>
</div>