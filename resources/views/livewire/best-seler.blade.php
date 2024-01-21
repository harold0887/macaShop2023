<div class="row mt-3" style="background: linear-gradient(140deg,rgba(146,205,250,.5),rgba(215,215,255,.4) 95%);">

    <div class="col-12">
        <div class="row justify-content-center">
            <div class="col-auto  px-0">
                <div style="width: 80px !important;" class="  ">
                    @include('includes.svg.prueba')
                </div>
            </div>
            <div class="col-auto r d-flex align-items-center px-0">
                <h1 class=" text-center   text-2xl  lg:text-4xl   font-bold " style="font-family: 'Advent Pro';color:#A578DA">
                    Los más vendidos
                </h1>
            </div>
            <div class="col-12">
                <p class="text-center">¡Descubre nuestros materiales didácticos más vendidos! </p>
            </div>
        </div>

    </div>




    <div class="novedades-autoplay">
        @if (isset($products) && $products->count() > 0)
        @foreach ($products as $product)
        <div class="px-1">
            <div class="card card-primary card-product ">
                <div class="card-header card-header-image  mb-5" data-header-animation="false">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        @if($product->video)
                        <video class="rounded  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                        @else
                        <img class="img" src="{{ Storage::url($product->itemMain) }} ">
                        @endif
                    </a>
                </div>
                <div class="card-body  px-1">
                    <div class="card-actions text-center ">
                        <div class="mt-2">
                            @if(!\Cart::get($product->id))
                            <button class=" btn   btn-primary btn-round  px-2 w-full " wire:click="addCart('{{ $product->id }}','Product')" wire:loading.attr="disabled">
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
                    </div>
                    <h3 class="card-title pt-3  text-base ">

                        <a href="{{ route('shop.show', $product->slug) }}"><strong>{{ $product->title }}</strong></a>
                        @role('admin')
                        <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}" target="_blank">
                            <i class="material-icons">edit</i>
                        </a>
                        @endrole

                    </h3>
                    @foreach($product->membresias as $membresia)
                    <div class="text-center ">
                        <a href="{{route('membership.show',$membresia->id)}}">
                            <span class="badge badge-sm badge-info m small px-1 mx-0" style="cursor:pointer">
                                Gratis en la membresía {{$membresia->title}}
                            </span>
                        </a>
                    </div>
                    @endforeach
                    <!-- <div class="card-description d-none d-lg-block">
                        {{ Str::limit($product->information, $limit = 50, $end = '...') }}
                    </div> -->
                </div>
                <div class="card-footer">
                    @if($product->price_with_discount < $product->price)
                        <div class="stats">
                            <p style="text-decoration: line-through !important">$ {{ $product->price }}</p>
                        </div>
                        <div class="price">
                            <p class="item-price text-primary">$ {{ $product->price_with_discount }}</p>
                        </div>
                        @else
                        <div class="stats">
                        </div>
                        <div class="price">
                            <p class="item-price text-primary ">$ {{ $product->price_with_discount }}</p>
                        </div>
                        @endif
                </div>
            </div>
        </div>
        @endforeach
        @endif



    </div>
</div>