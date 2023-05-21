<div class="container-fluid  p-0 ">
    @include('includes.modal.cart-modal')
    <div class="content-main  rounded">
        @include('includes.borders')
        <div class="row">
            <div class="col-12 ">
                <nav aria-label="breadcrumb ">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{route('membership')}}">Membresía VIP</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $membership->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center  ">
            <div class="col-11 col-md-4 col-lg-3  ">
                <div class="membership-sticky" data-mdb-sticky-boundary="true">
                    <div class=" mt-0 card card-primary card-product {{($membership->discount_percentage > 0) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                        @if ($membership->discount_percentage > 0)
                        <div class="price-label bg-primary "><span>Oferta</span></div>
                        @endif
                        <div class="card-header card-header-image mt-2" data-header-animation="false">
                            <img class="img" src="{{ Storage::url($membership->itemMain) }} ">
                        </div>
                        <div class="card-body ">
                            <div class="text-center">
                                @if (!\Cart::get($membership->id))
                                <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $membership->id }}','{{ $membership->model }}' )">
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
                            <h3 class="card-title text-center text-dark mt-2">
                                {{ $membership->title }}
                            </h3>
                            <div class="card-description">
                                <div class="row">
                                    <div class="col-12" style="height:170px">
                                        <h3 class="text-primary text-uppercase font-weight-bold  mt-0">{{$membership->vigencia}} </h3>
                                        @if ($membership->discount_percentage > 0)
                                        <div class=" text-2xl text-gray-500 mt-3" style="height: 30px;">
                                            Antes: <span style="text-decoration:line-through;">${{ round($membership->price) }}</span>
                                        </div>
                                        @else
                                        <div class=" text-2xl text-gray-500 mt-3" style="height: 30px;">
                                            <span style="text-decoration:line-through;"></span>
                                        </div>
                                        @endif
                                        <h1 class="font-weight-bold text-black">
                                            <small class=" text-mindle align-top ">$</small>{{ round($membership->price_with_discount) }}.00
                                        </h1>
                                    </div>
                                    <div class="col-12 text-center">

                                        <small class="text-black">VIGENCIA <span>

                                                @if(date_format(new DateTime($membership->start),'M')=='Jan')
                                                ENERO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Feb')
                                                FEBRERO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Mar')
                                                MARZO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Apr')
                                                ABRIL
                                                @elseif(date_format(new DateTime($membership->start),'M')=='May')
                                                MAYO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Jun')
                                                JUNIO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Jul')
                                                JULIO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Aug')
                                                AGOSTO
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Sep')
                                                SEPTIEMBRE
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Oct')
                                                OCTUBRE
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Nov')
                                                NOVIEMBRE
                                                @elseif(date_format(new DateTime($membership->start),'M')=='Dec')
                                                DICIEMBRE
                                                @endif

                                                {{date_format(new DateTime($membership->start),'Y')}}


                                            </span> A
                                            <span>
                                                @if(date_format(new DateTime($membership->expiration),'M')=='Jan')
                                                ENERO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Feb')
                                                FEBRERO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Mar')
                                                MARZO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Apr')
                                                ABRIL
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='May')
                                                MAYO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Jun')
                                                JUNIO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Jul')
                                                JULIO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Aug')
                                                AGOSTO
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Sep')
                                                SEPTIEMBRE
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Oct')
                                                OCTUBRE
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Nov')
                                                NOVIEMBRE
                                                @elseif(date_format(new DateTime($membership->expiration),'M')=='Dec')
                                                DICIEMBRE
                                                @endif
                                            </span>



                                            {{date_format(new DateTime($membership->expiration),'Y')}}
                                        </small>
                                    </div>

                                    <p class="text-muted text-start mt-2"> {{ $membership->information }}</p>

                                </div>






                            </div>
                            <div class=" justify-content-center border-top text-xxs">
                                <span class="text-danger">Importante:</span>
                                <span class=" text-muted"> La membresía no incluye todo el material didáctico de la TIENDA.</span>
                            </div>


                        </div>

                    </div>


                </div>




            </div>





            <div class="col-11 col-md-8 col-lg-9     ">
                <div class="row">


                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 col-lg-3 d-flex   align-items-center  py-0">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm  ">Material de REFUERZO. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Ev. Diagnostica. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Banner’s. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Material visual para el aula. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Juegos didácticos. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Agenda personalizada. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Diario de la educadora. </span>
                            </div>
                            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                                <span class="text-xs sm:text-lg md:text-lg  lg:text-sm p-0 ">Y MUCHO MÁS!!!. </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2 border-top">
                        <h2 class="my-0 title text-center text-primary text-lg sm:text-2x1 md:text-2xl  lg:text-2xl">
                            Materiales didácticos incluidos en la membresía {{ $membership->title }}
                        </h2>
                    </div>








                    @foreach($membership->products as $product)
                    <div class="col-6 col-md-4 col-lg-3 mb-4" style="position: relative; padding:5px !important">
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


                    <div class="col-12 text-center mt-5 text-muted">
                        <h1 class="mb-5">Membresía en preventa</h1>
                    <h2>👉🏻Material disponible a partir del 21 de julio del 2023.🫶🏻</h2>
                        <h4>🌈Por que ustedes lo pidieron muchos de NUESTROS RECURSOS serán EDITABLES para que puedan ajustarlo a sus necesidades!!!!🌟🫶🏻</h4>
                        
                    </div>

                </div>

            </div>









        </div>
        @include('includes.borders')
    </div>
</div>