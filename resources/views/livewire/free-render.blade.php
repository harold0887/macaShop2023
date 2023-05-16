<div class="container-fluid  p-0 ">
    @include('includes.modal.login-modal')
    @include('includes.modal.cart-modal')
    @include('includes.spinner-livewire')
    <div class="content-main rounded">
        @include('includes.borders')

        <div class="row justify-content-center">

            <div class="col-12 col-lg-9">
                <!--row products-->
                <div class="row  justify-center px-3 mt-2">

                    @if (isset($products) && $products->count() > 0)
                    @foreach ($products as $product)
                    <div class="col-6 col-md-4 col-lg-3 mb-4 " style="position: relative; padding:5px !important">
                        <div class="card card-primary  card-product">
                            <div class="card-header  card-header-image mb-4 d-flex justify-content-center text-center" data-header-animation="true">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    @if($product->video)
                                    <video class="rounded  w-75 " src="{{ Storage::url($product->video) }}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                                    @else
                                    <img class="img" src="{{ Storage::url($product->itemMain) }} ">
                                    @endif

                                </a>
                            </div>
                            <div class="card-body px-2">
                                <div class="card-actions text-center pt-4">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn  btn-primary btn-round mt-2" wire:click="downloadFree('{{ $product->id }}')">
                                            <i class="material-icons">download</i>
                                            <span>Descargar</span>
                                        </button>
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
                                <div class="card-description mt-4">

                                    @foreach($product->membresias as $membresia)
                                    <div class="text-left">
                                        <i class="material-icons my-auto mr-1 text-xs text-success">check</i>
                                        <span class="text-xs text-muted">Disponible en membresía {{$membresia->title}} </span>
                                    </div>
                                    @endforeach




                                    <a href=" {{ route('shop.show', $product->slug) }} " class="btn   btn-link text-info text-xs">
                                        Más informacion
                                    </a>

                                </div>
                            </div>
                            <div class="card-footer">

                                <div class=" stats">
                                    <p class="item-discount text-secondary">Material gratuito</p>
                                </div>
                                <div class="price">
                                    <p class="item-price text-primary ">$ {{ $product->price_with_discount }}</p>
                                </div>



                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="col-12 col-lg-8 text-right">
                        <video class="rounded  w-75 " src="{{asset('img/oops.mp4')}}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                    </div>
                    @endif
                </div>

            </div>


            <div class="col-11 col-lg-3 order-first order-lg-last  ">
                @if(isset($membership) && $membership->count()>0)
                <div class="row membership-sticky bg-white rounded">
                    <div class="col-12">
                        <div class=" animate__animated  animate__shakeX animate__repeat-3	 animate__slow  mt-0 card card-primary card-product {{($membership->discount_percentage > 0) ? 'border  border-primary' : 'border' }}" style=" overflow: hidden;">
                            @if ($membership->discount_percentage > 0)
                            <div class="price-label1 bg-white  "><span>prueba</span></div>
                            <div class="price-label bg-primary animate__animated  animate__flash animate__infinite 	infinite	 animate__slow "><span>Oferta</span></div>
                            @endif
                            <div class="card-header card-header-image mt-2" data-header-animation="false">
                                <img class="img" src="{{ Storage::url($membership->itemMain) }} ">
                            </div>
                            <div class="card-body mt-3">
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
                                <h3 class="card-title text-center text-dark">
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

                                        <p class="text-muted text-start mt-2" style="height:90px">
                                            {{ Str::limit($membership->information, $limit = 150, $end = '...') }}
                                        </p>

                                    </div>






                                </div>
                                <div class="card-footer justify-content-center border-top">
                                    <a href=" {{route('membership.show',$membership->id)}} " class="btn   btn-link text-info">
                                        Más informacion
                                    </a>
                                </div>


                            </div>

                        </div>



                    </div>
                </div>
                @endif


            </div>
        </div>
        @include('includes.borders')
    </div>
</div>