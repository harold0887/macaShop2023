<div class="container-fluid  p-0 ">
    @include('includes.modal.login-modal')

    <div class="content-main">
        @include('includes.borders')
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Carrito de compras</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center p-3">

            @if (\Cart::getContent()->count() > 0)
            <div class="col-10 col-lg-6">

                <span class="h3">
                    Mi carrito
                </span>
                <p class="pb-3 text-sm lg:text-lg">
                    Revise su pedido y luego continúe con el pago.
                </p>
                @foreach (\Cart::getContent() as $item)

                <div class="row">
                    <div class="col-md-3 my-1">
                        <img src="{{ Storage::url($item->associatedModel->itemMain) }} " class="img-thumbnail">
                    </div>
                    <div class="col-12 col-md-6 ">
                        <p>
                            @if ($item->associatedModel->model == 'Product')
                            <a href="{{ route('shop.show', $item->associatedModel->slug) }}" class="text-dark">
                                <b style="font-size: 1em">{{ $item->name }}</b>
                            </a>
                            <br>
                            <span class="text-muted ">Formato digital: {{ $item->associatedModel->format }}
                            </span>
                            @elseif($item->associatedModel->model == 'Membership')
                            <b style="font-size: 1.2em">Membresia {{ $item->name }}</b>
                            <br>
                            <span class="text-muted">
                                Vigencia:


                                <span>
                                    @if(date_format(new DateTime($item->expiration),'M')=='Jan')
                                    Enero
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Feb')
                                    Febrero
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Mar')
                                    Marzo
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Apr')
                                    Abril
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='May')
                                    Mayo
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Jun')
                                    Junio
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Jul')
                                    Julio
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Aug')
                                    Agosto
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Sep')
                                    Septiembre
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Oct')
                                    Octubre
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Nov')
                                    Noviembre
                                    @elseif(date_format(new DateTime($item->expiration),'M')=='Dec')
                                    Diciembres
                                    @endif
                                </span>

                                {{date_format(new DateTime($item->expiration),'Y')}}
                            </span>
                            @elseif($item->associatedModel->model == 'Package')

                            <b style="font-size: 1.2em">{{ $item->name }}</b>
                            <span class="text-muted">
                                {{$item->products}}

                            </span>

                            @endif
                            <br>

                            <span class="text-muted">Precio: ${{ number_format($item->price,2) }} MXN </span> <br>
                            <span class="text-muted">Cantidad: {{ $item->quantity }} </span> <br>


                        </p>
                    </div>
                    <div class="col-md-3 text-center ">
                        <button type="submit" class="btn  btn-link p-0" wire:click="remove('{{ $item->id }}','{{ $item->associatedModel->title }}')" wire:loading.attr="disabled">
                            <i class="material-icons">close</i>
                            Eliminar
                        </button>
                    </div>
                </div>
                <hr class="text-muted border border-primary">
                @endforeach
            </div>
            <div class="col-3 pt-3">

            </div>
            <div class="col-12 col-lg-3 ">

                <div class="row membership-sticky bg-white rounded shadow ">
                    <div class="col-12    text-center">
                        <span class=" h3">Resumen de la orden</span>
                    </div>
                    <div class="col-7  py-4 text-muted">Subtotal {{ \Cart::getTotalQuantity() }} artículo(s): </div>
                    <div class="col-5 py-4 text-end text-muted">${{ \Cart::getTotal() }} MXN</div>
                    <div class="col-12">
                        <hr class="text-muted">
                    </div>
                    <div class="col-6  font-weight-bold h3">Total: </div>
                    <div class="col-6  font-weight-bold text-end h3">${{ \Cart::getTotal() }} MXN</div>
                    <div class="col-12 text-center">


                        @auth
                        <form action="{{ route('shop.createOrder') }}" method="POST" style="cursor:pointer" id="create-product-admin">
                            @csrf
                            <button class="btn btn-lg   btn-primary btn-round  w-100">
                                Finalizar orden
                            </button>
                        </form>
                        @else
                        <button class="btn btn-lg   btn-primary btn-round  w-100" wire:click="loginMessage()" style="cursor:pointer">
                            Finalizar orden
                        </button>
                        @endauth
                    </div>
                    <span class="text-center text-muted">
                        Los recursos comprados se pueden descargar inmediatamente desde su cuenta*
                    </span>
                </div>


            </div>
            @else
            <div class="col-12 col-lg-5 text-center ">
                <img src="{{ asset('img/cart.png') }} " class="text-center  w-100">
                <a href="{{ route('shop.index') }}" class="btn btn-primary h5">Ver tienda</a>
            </div>


            @endif

            <div class="col-12 text-end">
                <small class="text-xxs text-muted">*Algunos recursos pueden solicitar activación vía WhatsApp. </small>
            </div>
        </div>

        @include('includes.borders')

    </div>
</div>