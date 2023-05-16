<div class="container-fluid  p-0 ">
    @include('includes.modal.cart-modal')
    <div class="content-main  rounded">
        @include('includes.borders')
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item"><a href="{{route('paquete')}}">Paquetes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $package->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center  ">
            <div class="col-11 col-md-4 col-lg-3   ">

                <div class=" mt-0 card card-primary card-product {{($package->price_with_discount < $package->price) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                    @if ($package->price_with_discount < $package->price)
                        <div class="price-label bg-primary "><span>Descuento</span></div>
                        @endif
                        <div class="card-header card-header-image mt-2" data-header-animation="false">
                            <img class="img" src="{{ Storage::url($package->itemMain) }} ">
                        </div>
                        <div class="card-body">
                        <div class="text-center">
                                @if (!\Cart::get($package->id))
                                <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $package->id }}','{{ $package->model }}' )">
                                    <i class="material-icons">shopping_cart</i>
                                    <span>Agregar al carrito</span>
                                </button>
                                @else
                                <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round">
                                    <i class="material-icons">shopping_cart</i>
                                    <span>Ver en el carrito</span>
                                </a>
                                @endif
                            </div>
                            <h3 class="card-title text-center text-dark">
                                {{ $package->title }}
                            </h3>
                            <div class="card-description">
                                <div class="row">
                                    <div class="col-12" style="height:170px">
                                        <h3 class="text-primary text-uppercase font-weight-bold">{{$package->vigencia}} </h3>
                                        @if ($package->price_with_discount < $package->price)
                                            <div class=" text-2xl text-gray-500 mt-3" style="height: 50px;">
                                                Antes: <span style="text-decoration:line-through;">${{ round($package->price) }}</span>
                                            </div>
                                            @else
                                            <div class=" text-2xl text-gray-500 mt-3" style="height: 50px;">
                                                <span style="text-decoration:line-through;"></span>
                                            </div>
                                            @endif
                                            <h1 class="font-weight-bold text-black">
                                                <small class=" text-mindle align-top ">$</small>{{ round($package->price_with_discount) }}.00
                                            </h1>
                                    </div>

                                    <div class="col-12 text-center">

                                        <span class="text-black">Este paquete incluye  {{ $package->products->count() }} cuadernillos

                                        </span>
                                    </div>


                                    <p class="text-muted text-start mt-5"> {{ $package->information }}</p>

                                </div>

                            </div>
                            <div class="card-footer justify-content-center">
                              
                            </div>


                        </div>

                </div>






            </div>




            <div class="col-11 col-md-8 col-lg-9 ">
                <div class="row">

                    <h2 class="mt-0 title  text-center text-primary text-lg sm:text-2x1 md:text-2xl  lg:text-2xl">
                        Materiales didácticos incluidos en el {{ $package->title }}
                    </h2>








                    @foreach($package->products as $product)
                    <div class="col-6 col-md-4 col-lg-4 mb-4" style="position: relative; padding:5px !important">
                        <div class=" card card-primary  card-product">
                            <div class="card-header  card-header-image " data-header-animation="true">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img class="img" src="{{ Storage::url($product->itemMain) }} ">
                                </a>
                            </div>
                            <div class="card-body  px-0">

                                <h3 class="card-title">
                                    <a href="{{ route('shop.show', $product->slug) }}" class="card-title text-center text-dark text-xs">{{ $product->title }}</a>
                                    @role('admin')
                                    <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    @endrole
                                </h3>
                                @if($product->fecha_membresia>now())
                                <div class="d-flex  mt-2">
                                    <i class="material-icons my-auto mr-1 text-sm text-secondary">check</i>
                                    <span class="text-sm text-muted">Disponible el {{date_format(new DateTime($product->fecha_membresia),'d-M-y')}} </span>
                                </div>

                                @else
                                <div class="d-flex  mt-2">
                                    <i class="material-icons my-auto mr-1 text-sm text-success">check</i>
                                    <span class="text-sm text-muted">Descarga inmediata. </span>
                                </div>
                                @endif
                            </div>




                            <div class="card-footer justify-content-center">
                                <div class="row">


                                    <div class="col-12 text-center mt-2">
                                        @if($product->fecha_membresia>now())
                                        <button class=" btn   btn-sm btn-outline-secondary btn-round" disabled>

                                            <span>Proximamente</span>
                                        </button>
                                        @else
                                        <button class=" btn   btn-sm btn-outline-info btn-round" disabled>
                                            <i class="material-icons">check</i>
                                            <span>Disponible</span>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                    @endforeach




                </div>

            </div>









        </div>
        @include('includes.borders')
    </div>
</div>