<div class="novedades-autoplay">
    <div class="px-2">
        <div class="card card-primary card-product ">
            <div class="card-header card-header-image   text-center   " data-header-animation="false" style="position:relative">

                <video class="rounded" src="{{asset('video/cuaderno1.mp4')}}" autoplay muted loop style="width:100%"></video>

            </div>
            <div class="card-body">
                <div class="card-actions text-center" style="position:relative">
                    <div class="mt-5">

                        <button class=" btn btn-primary btn-round">
                            <i class="material-icons">shopping_cart</i>
                            <span>Añadir al carrito</span>
                        </button>


                    </div>
                </div>
                <h3 class="card-title">

                    <a href="">Cuaderno 2</a>

                </h3>
                <div class="card-description">
                    Cuaderno 1 de prueba
                </div>
            </div>
            <div class="card-footer">



                <div class=" stats ">
                </div>
                <div class="price ">
                    <p class="item-price text-primary ">$ 80 pesos
                    </p>
                </div>

            </div>
        </div>
    </div>


    @if (isset($products) && $products->count() > 0)
    @foreach ($products as $product)
    <div class="px-2">
        <div class="card card-primary card-product ">
            <div class="card-header card-header-image  mb-5" data-header-animation="false">
                <a href="">
                    <img class="img" src="{{ Storage::url($product->itemMain) }} ">
                </a>
            </div>
            <div class="card-body">
                <div class="card-actions text-center">
                    <div class="mt-2">

                        <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $product->id }}','Product')">
                            <i class="material-icons">shopping_cart</i>
                            <span>Añadir al carrito</span>
                        </button>


                    </div>
                </div>
                <h3 class="card-title">

                    <a href="">{{ $product->title }}</a>

                </h3>
                <div class="card-description">
                    {{ Str::limit($product->information, $limit = 50, $end = '...') }}
                </div>
            </div>
            <div class="card-footer">
                @if ($product->price_with_discount < $product->price)
                    <div class=" stats">
                        <p class="item-discount text-secondary">$ {{ $product->price }}</p>
                    </div>
                    <div class="price">
                        <p class="item-price text-primary ">$ {{ $product->price_with_discount }}
                        </p>
                    </div>
                    @else
                    <div class=" stats ">
                    </div>
                    <div class="price ">
                        <p class="item-price text-primary ">$ {{ $product->price_with_discount }}
                        </p>
                    </div>
                    @endif
            </div>
        </div>
    </div>
    @endforeach
    @endif



</div>