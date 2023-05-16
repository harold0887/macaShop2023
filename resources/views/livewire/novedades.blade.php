<div class="row mt-5" style="background-color: #a578da;
background-image: linear-gradient(180deg, #a578da 0%, #a578da 33%, #ffffff 66%, #ffffff 100%);

">
    @include('includes.modal.cart-modal')
    <h1 class=" text-center  text-2xl  lg:text-4xl   font-bold text-white  py-2 " style="font-family: 'Advent Pro'">
        Conoce nuestras novedades
    </h1>

    <div class="novedades-autoplay">
        @if (isset($products) && $products->count() > 0)
        @foreach ($products as $product)
        <div class="px-2">
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
                <div class="card-body">
                    <div class="card-actions text-center">
                        <div class="mt-2">
                            @if(!\Cart::get($product->id))
                            <button class=" btn   btn-primary btn-round  px-2 w-full " wire:click="addCart('{{ $product->id }}','Product')">
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
                    <div class="card-description d-none d-lg-block">
                        {{ Str::limit($product->information, $limit = 50, $end = '...') }}
                    </div>
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