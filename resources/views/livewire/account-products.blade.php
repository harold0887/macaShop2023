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
                        <li class="breadcrumb-item active" aria-current="page">Productos</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                <h4 class="card-title h3"><strong>Mis productos</strong> </h4>
            </div>
            <div class="col-12">
                <div class="card mt-0" id="orders">

                    <div class="card-body  px-0">
                        @if (isset($purchases) && $purchases->count() > 0)


                        <div class="table-responsive px-0">
                            <table class="table table-hover table-shopping">
                                <thead>
                                    <tr>
                                        <th><b>Producto</b></th>
                                        <th class="text-center"><b>Acciones</b></th>
                     
                                   
                                    </tr>
                                </thead>
                                <tbody>

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




                                        @if ($purchase->status == 'approved')
                                        <td class="px-5">
                                            <div class="row justify-content-center">
                                                <div class="col-12 text-center">
                                                    <button class="btn btn-primary show-spinner" wire:click="finalDownload({{ $purchase->id }},{{ $purchase->order_id }})" wire:loading.attr="disabled">
                                                        <i class="material-icons" wire:loading.remove>download</i>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" disabled wire:loading></span>
                                                        Descargar
                                                    </button>
                                                </div>
                                                <div class="col-12 text-center ">
                                                    <span>o</span>
                                                </div>
                                                <div class="col-12 text-center">
                                                    <button class="btn  btn-primary btn-link show-spinner" wire:click="sendEmail({{ $purchase->id }},{{ $purchase->order_id }})">
                                                        <i class="material-icons" wire:loading.remove>email</i>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" disabled wire:loading></span>
                                                        Enviar a email
                                                    </button>
                                                </div>
                                            </div>




                                        </td>

                                        @else
                                        <td>
                                            <button class="btn text-primary  btn-primary btn-outline" disabled>
                                                <i class=" material-icons">file_download</i>
                                                Descarga no disponible
                                            </button>

                                        </td>

                                        @endif
                                       

                                      
                                        



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