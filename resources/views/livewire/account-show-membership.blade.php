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
            <div class="col-12">
                <h4 class="card-title h3"><strong>{{$membership->title}}</strong> </h4>
            </div>
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
                                    @foreach ($membership->products as $purchase)
                                    <tr>

                                        <td>
                                            <div class="img-container ">
                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                            </div>
                                            <span class="h5" data-mdb-toggle="modal"><small>{{ $purchase->title }} </small></span>
                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                            <!-- <br><small class="italic text-muted">{{ $purchase->price }} MXN </small> -->
                                        </td>
                                        <td>



                                            @if(now() >= $purchase->fecha_membresia)
                                            <div class="col-12 ">

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
                                            </div>
                                            @else
                                            <div class="col-12 ">
                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>

                                                    Disponible {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
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





        </div>
        @include('includes.borders')
    </div>
</div>