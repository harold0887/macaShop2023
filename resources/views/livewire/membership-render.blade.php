<div class="container-fluid  p-0 ">
    @include('includes.modal.cart-modal')
    <div class="content-main  rounded">
        @include('includes.borders')
        @if (isset($memberships) && $memberships->count() > 0)
        <div class="row mt-3">

            <div class="col-12">
                <div class="mx-auto text-justify px-2 font-serif text-xs text-neutral-700  md:text-lg md:leading-tight ">
                    Estás a un paso de acceder a más de 50 materiales en cada una de nuestras membresías!!!
                    <strong class="border-b-2 border-primary">Membresía preescolar</strong> y
                    <strong class="border-b-2 border-primary">Membresía primaria</strong>, se
                    convertirán en tu
                    <strong class="border-b-2 border-primary">
                        mejor aliado.
                    </strong>
                </div>
            </div>
        </div>
        <div class="row  mt-3">
            <div class="col-6 col-lg-3 d-flex   align-items-center  py-0">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg  ">Material de REFUERZO. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Ev. Diagnostica. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Banner’s. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Material visual para el aula. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Juegos didácticos. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Agenda personalizada. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Diario de la educadora. </span>
            </div>
            <div class="col-6 col-lg-3 d-flex   align-items-center py-0 my-0 ">
                <i class="material-icons my-auto mr-2 text- sm:text-2x1 md:text-3xl  lg:text-4xl text-success ">task_alt</i>
                <span class="text-xs sm:text-lg md:text-lg  lg:text-lg p-0 ">Y MUCHO MÁS!!!📚. </span>
            </div>
        </div>

        <div class="row justify-content-center">




            @foreach ($memberships as $membership)
            <div class="col-11 col-md-4 col-lg-3 mb-4 {{($membership->discount_percentage > 0) ? 'order-first order-lg-0' : '' }}" style="position: relative">

                <div class=" shadow  card card-primary card-product {{($membership->discount_percentage > 0) ? 'border  border-primary ' : 'border' }}" style=" overflow: hidden;">
                    @if ($membership->discount_percentage > 0)
                    <div class="price-label bg-primary animate__animated  animate__flash animate__repeat-3	 animate__slow "><span>Oferta</span></div>
                    @endif

                    <div class="card-header card-header-image mt-2" data-header-animation="false">
                        <img class="img" src="{{ Storage::url($membership->itemMain) }} ">
                    </div>
                    <div class="card-body ">
                        <div class="text-center">
                            @if (!\Cart::get($membership->id))
                            <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $membership->id }}','{{ $membership->model }}' )" wire:loading.attr="disabled">
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

                        <div class="card-description ">
                            <div class="row ">
                                <div class="col-12" style="height:170px">
                                    <h3 class="text-primary-light text-uppercase mt-0">{{$membership->vigencia}} </h3>

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

                                <p class="text-muted text-start mt-2" style="height:90px">
                                    {{ Str::limit($membership->information, $limit = 220, $end = '...') }}
                                </p>

                            </div>

                        </div>

                    </div>
                    <div class="card-footer justify-content-center">
                        <a href=" {{route('membership.show',$membership->id)}} " class="btn   btn-link text-info">
                            Más informacion
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="col-12 text-center text-lg">
                <span class="text-danger">Importante:</span>
                <span class=" text-muted"> La membresía no incluyen todo el material didáctico de la TIENDA.</span>
            </div>
        </div>

        @else
        <div class="col-12 mb-4 text-center h4 text-muted my-5 py-5" style="position: relative">
            <span>Por ahora no hay membresias disponibles. Regresa pronto.</span>
        </div>
        @endif
        @include('includes.borders')
    </div>
</div>