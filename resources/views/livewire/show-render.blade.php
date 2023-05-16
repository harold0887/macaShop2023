<div class="container-fluid  p-0 ">
    @include('includes.spinner-livewire')
    @include('includes.modal.cart-modal')
    <div class="content-main ">
        @include('includes.borders')
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0 text-xs lg:text-base">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Tienda</a></li>
                        <li class="breadcrumb-item"><a href="{{route('shop.index')}}">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h1 class="rounded text-center text-primary text-xl sm:text-2x1 md:text-3xl  lg:text-3xl font-weight-bold mb-4">{{ $product->title }}</h1>
            </div>
        </div>
        <div class="row px-3">
            <div class="col-12 col-lg-8">
                <div class="row justify-content-center">
                    @if($product->video)
                    <div class="col-5 d-flex justify-content-center  px-2 px-lg-5 pb-5">
                        <video class="rounded  w-100 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                    </div>
                    @endif
                    <div class="@if($product->video) col-7 @else col-10 col-lg-9 @endif">
                        @include('includes.carrusel')
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 shadow rounded  mt-3 mt-lg-0" style=" overflow:hidden !important;">
                @if ($product->price > $product->price_with_discount )
                <div class="price-label bg-primary "><span>Oferta</span></div>
                @endif

                <div class="row justify-content-center  @if(!$product->video) mt-3 mt-lg-0 @endif">


                    @if($product->status==true)
                    <div class="col-lg-12 text-center   d-flex align-items-top justify-content-center mt-3 ">
                        @if ($product->price > $product->price_with_discount )
                        <span class=" text-muted text-sm sm:text-sm md:text-sm  lg:text-lg  mr-3" style="text-decoration:line-through;">${{ $product->price }}</span>
                        <span class="font-weight-bold text-muted text-2xl sm:text-3x1 md:text-3xl  lg:text-4xl  mr-3">${{ $product->price_with_discount }} </span>
                        @else
                        <span class="font-weight-bold text-muted text-2xl sm:text-3x1 md:text-3xl  lg:text-4xl  mr-3">${{ $product->price_with_discount }} </span>
                        @endif


                    </div>

                    <div class="col-12 text-center p-0 mt-3">
                        @if($product->price==0)

                        <button class="btn  btn-primary btn-round mt-2" wire:click="downloadFree('{{ $product->id }}')">
                            <i class="material-icons">download</i>
                            <span>Descargar</span>
                        </button>

                        @else
                        @if(!\Cart::get($product->id))
                        <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $product->id }}','Product')">
                            <i class="material-icons">shopping_cart</i>
                            <span>Agregar al carrito</span>
                        </button>
                        @else
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round">
                            <i class="material-icons">shopping_cart</i>
                            <span>Ver en el carrito</span>
                        </a>
                        @endif
                        @endif
                    </div>

                    @endif
                    <div class="col-11 col-lg-12 px-2 ">
                        @include('includes.acordion')
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 col-lg-8 order-last order-lg-first">
                <div class="form-row justify-center">
                    <div class="col-12 text-center">
                        <h2 class=" blog-subtitle font-serif lg:text-2xl  md:text-3xl md:font-bold  text-2xl  text-primary ">
                            Escribe sobre tu experiencia
                        </h2>
                        <small class="text-justify ">Hágales saber a otros educadores cómo usó este recurso y qué les gustó o no les
                            gustó a usted o a sus alumnos.</small>
                    </div>
                    <div class="col-12 text-center">
                        <form wire:submit.prevent="addComment">
                            <div class="form-row justify-center">
                                <div class="form-group col-md-12">
                                    <textarea type="text" class="form-control bg-white border  rounded @error('newComment')border-danger @enderror px-3" rows="4" wire:model.defer="newComment">

                                    </textarea>
                                </div>
                                @error('newComment')
                                <small class="text-danger"> {{ $message }} </small>
                                @enderror
                            </div>
                            @auth
                            <button class=" btn btn-round btn-outline-primary" type="submit">
                                <span>Enviar comentario</span>
                            </button>

                            @else
                            <span>Regístrate o Inicia sesión para dejar un comentario.</span>

                            @endauth
                        </form>
                    </div>
                </div>
                <div class="row justify-center">
                    <div class="col-12 ">

                        <h6 class="mb-3">
                            {{$product->comentarios->count()}} Comentarios
                        </h6>



                        <div class="px-2">
                            <div class="card card-testimonial ">
                                <div class="card-body  py-1">
                                    @if ($product->comentarios->count() > 0)
                                    @foreach ($product->comentarios as $item)

                                    <div class="row    @if (!$loop->last) mb-3 @endif">
                                        <div class="col-auto  px-2">
                                            <div class="avatar-sm justify-content-left border ">
                                                @if(isset($item->user->picture))
                                                <img class=" border-gray m-0  w-100 avatar-sm" src="{{Storage::url($item->user->picture)}}" alt="...">

                                                @else
                                                <img class=" border-gray m-0  w-100 avatar-sm" src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col  text-left  p-0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6 class="card-category  m-0">
                                                        @php
                                                        $name = explode(" ", $item->user->name);
                                                        echo $name[0];
                                                        @endphp
                                                    </h6>
                                                    <p class=" text-muted small m-0">
                                                        {{ $item->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="card-description  m-0 text-xs lg:text-sm text-gray-600 italic">
                                                        {{$item->comment}}
                                                    </p>

                                                </div>
                                            </div>

                                        </div>

                                        <hr class="m-0 p-0" style="border:solid 1px #9c27b0">
                                    </div>
                                    @endforeach

                                    @else
                                    <small class="text-justify">
                                        <span class="font-weight-bold">
                                            Aún no hay comentarios,
                                        </span>
                                        <span>
                                            ¿quieres ser el primero en dejar uno? ¡Tu opinión nos interesa!
                                        </span>
                                    </small>
                                    @endif

                                </div>

                            </div>
                        </div>



                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-4 text-center order-first order-lg-last">
                <div class="row">
                    <div class="col-12">

                        <h2 class="blog-subtitle font-serif lg:text-2xl  md:text-3xl md:font-bold text-center text-2xl  text-primary">
                            Artículos relacionados
                        </h2>
                    </div>
                    <div class="col-12">

                        <section class="relacionados1">
                            @if (isset($articles) && $articles->count() > 0)
                            @foreach ($articles as $article)
                            <div class="px-2">
                                <div class="card card-product ">
                                    <div class="card-header card-header-image mt-3 mb-5" data-header-animation="true">
                                        <a href="{{ route('shop.show', $article->slug) }}">
                                            <img class="img" src="{{ Storage::url($article->itemMain) }} ">
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="card-actions text-center">
                                            <div class="mt-2">
                                                @if (!\Cart::get($article->id))
                                                <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $article->id }}','Product')">
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
                                            <a href="{{ route('shop.show', $article->slug) }}"><strong>{{ $article->title }}</strong></a>
                                        </h3>
                                        <div class="card-description">
                                            {{ Str::limit($article->information, $limit = 100, $end = '...') }}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        @if ($article->price_with_discount < $article->price)
                                            <div class=" stats">
                                                <p class="item-discount text-secondary" style="text-decoration:line-through;">$ {{ $article->price }}</p>
                                            </div>
                                            <div class="price">
                                                <p class="item-price text-primary ">$ {{ $article->price_with_discount }}
                                                </p>
                                            </div>
                                            @else
                                            <div class=" stats ">
                                            </div>
                                            <div class="price ">
                                                <p class="item-price text-primary ">$ {{ $article->price_with_discount }}
                                                </p>
                                            </div>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </section>


                    </div>
                </div>




            </div>
        </div>
        @include('includes.borders')
    </div>
</div>