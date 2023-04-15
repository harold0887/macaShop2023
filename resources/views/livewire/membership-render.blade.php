<div class="container p-0">
@include('includes.modal.cart-modal')
    <div class="content-main ">
        <div class="row justify-content-center">
            @if (isset($memberships) && $memberships->count() > 0)
            @foreach ($memberships as $membership)
            <div class="col-11 col-md-4 col-lg-4 mb-4 {{($membership->discount_percentage > 0) ? 'order-first order-lg-0' : '' }}" style="position: relative">

                <div class=" card card-primary card-product {{($membership->discount_percentage > 0) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                    @if ($membership->discount_percentage > 0)
                    <div class="price-label bg-primary "><span>Descuento</span></div>
                    @endif

                    <!-- <div class="card-header card-header-image mt-2" data-header-animation="false">
                        <img class="img" src="{{ Storage::url($membership->itemMain) }} ">
                    </div> -->
                    <div class="card-body mt-3">
                        <h3 class="card-title text-center text-dark">
                            {{ $membership->title }}
                        </h3>

                        <div class="card-description">
                            <div class="row">
                                <div class="col-12" style="height:200px">
                                    <h3 class="text-primary text-uppercase font-weight-bold">{{$membership->vigencia}} </h3>
                                    @if ($membership->discount_percentage > 0)
                                    <div class=" text-2xl text-gray-500 mt-3" style="height: 50px;">
                                        Antes: <span style="text-decoration:line-through;">${{ round($membership->price) }}</span>
                                    </div>
                                    @else
                                    <div class=" text-2xl text-gray-500 mt-3" style="height: 50px;">
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

                                <p class="text-muted text-start mt-5" style="height:100px"> {{ $membership->information }}</p>
                                <a href=" {{route('membership.show',$membership->id)}} " class="btn   btn-link text-info">
                                    Más informacion
                                </a>
                            </div>






                        </div>

                    </div>
                    <div class="card-footer justify-content-center">
                        @if (!\Cart::get($membership->id))
                        <button class=" btn btn-primary btn-round" wire:click="addCart('{{ $membership->id }}','{{ $membership->model }}' )">
                            <i class="material-icons">shopping_cart</i>
                            <span>Añadir al carrito</span>
                        </button>
                        @else
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round">
                            <i class="material-icons">shopping_cart</i>
                            <span>Ver en el carrito</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-11 mb-4 text-center h4 text-muted" style="position: relative">
                <span>Por ahora no hay membresias disponibles. Regresa pronto.</span>
            </div>
            @endif


        </div>
    </div>
</div>