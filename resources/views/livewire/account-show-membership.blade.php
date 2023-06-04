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
                                        <th class="text-center"><b>Acciones</b></th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($membership->products as $purchase)



                                    <tr>

                                        <td>
                                            <div class="img-container ">
                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                            </div>
                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                            <!-- <br><small class="italic text-muted">{{ $purchase->price }} MXN </small> -->
                                        </td>
                                        <td class="px-5">
                                            <div class="row justify-content-center">
                                                @if($purchase->fecha_membresia <= now()) <div class="col-12 text-center">
                                                    <button class="btn btn-primary show-spinner" wire:click="finalDownload({{ $purchase->id }})" wire:loading.attr="disabled">
                                                        <i class="material-icons" wire:loading.remove>download</i>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" disabled wire:loading></span>
                                                        Descargar
                                                    </button>
                                            </div>
                                            <div class="col-12 text-center ">
                                                <span>o</span>
                                            </div>
                                            <div class="col-12 text-center">
                                                <button class="btn  btn-primary btn-link show-spinner" wire:click="sendEmail({{ $purchase->id }})">
                                                    <i class="material-icons" wire:loading.remove>email</i>
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" disabled wire:loading></span>
                                                    Enviar a email
                                                </button>
                                            </div>
                                            @else


                                            <div class="col-12 text-center">
                                                <button class="btn  btn-primary btn-link show-spinner" disabled>

                                                    Disponible {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                </button>
                                            </div>

                                            @endif
                        </div>




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