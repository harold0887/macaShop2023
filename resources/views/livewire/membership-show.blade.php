<div class="container-fluid  p-0 ">

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
                    <div class="col-12 mt-2 border-top ">
                        <h2 class="my-0 title text-center text-primary text-sm sm:text-2x1 md:text-2xl  lg:text-2xl mt-2">
                        Consulta la lista de materiales didácticos incluidos en la membresía  {{ $membership->title }}
                        </h2>
                    </div>
                    <div class="col-12">
                        <!--Accordion wrapper-->
                        <div class="accordion md-accordion accordion-4" id="accordionEx2" role="tablist" aria-multiselectable="true">

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal lighten-4" role="tab" id="heading10">
                                    <a class="collapsed " data-toggle="collapse" data-parent="#accordionEx2" href="#collapse10" aria-expanded="false" aria-controls="collapse10">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/agosto.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            Agosto 2023
                                        </h4>
                                    </a>
                                </div>



                                <!-- Card body -->
                                <div id="collapse10" class="collapse" role="tabpanel" aria-labelledby="heading10" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="table-responsive px-0">
                                            <table class="table table-hover table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th><b>Producto</b></th>
                                                        <th><b>Disponible</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($membership->products as $purchase)

                                                    @if(Str::substr($purchase->fecha_membresia, 0,7) =="2023-07" )
                                                    <tr>
                                                        <td>
                                                            <div class="img-container ">
                                                                @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                @endif
                                                            </div>
                                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                        </td>
                                                        <td>
                                                            @if(now() >= $purchase->fecha_membresia)
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                Descarga inmediata
                                                            </button>
                                                            @else
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal lighten-3" role="tab" id="heading11">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse11" aria-expanded="false" aria-controls="collapse11">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/septiembre.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            Septiembre 2023
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse11" class="collapse" role="tabpanel" aria-labelledby="heading11" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="table-responsive px-0">
                                            <table class="table table-hover table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th><b>Producto</b></th>
                                                        <th><b>Disponible</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($membership->products as $purchase)

                                                    @if(Str::substr($purchase->fecha_membresia, 0,7) =="2023-09" )
                                                    <tr>
                                                        <td>
                                                            <div class="img-container ">
                                                                @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                @endif
                                                            </div>
                                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                        </td>
                                                        <td>
                                                            @if(now() >= $purchase->fecha_membresia)
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                Descarga inmediata
                                                            </button>
                                                            @else
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal lighten-2" role="tab" id="heading12">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse12" aria-expanded="false" aria-controls="collapse12">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/octubre.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            Octubre 2023
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse12" class="collapse" role="tabpanel" aria-labelledby="heading12" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="table-responsive px-0">
                                            <table class="table table-hover table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th><b>Producto</b></th>
                                                        <th><b>Disponible</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($membership->products as $purchase)

                                                    @if(Str::substr($purchase->fecha_membresia, 0,7) =="2023-10" )
                                                    <tr>
                                                        <td>
                                                            <div class="img-container ">
                                                                @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                @endif
                                                            </div>
                                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                        </td>
                                                        <td>
                                                            @if(now() >= $purchase->fecha_membresia)
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                Descarga inmediata
                                                            </button>
                                                            @else
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal lighten-1" role="tab" id="heading13">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse13" aria-expanded="true" aria-controls="collapse13">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/noviembre.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            Noviembre 2023
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse13" class="collapse" role="tabpanel" aria-labelledby="heading13" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="table-responsive px-0">
                                            <table class="table table-hover table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th><b>Producto</b></th>
                                                        <th><b>Disponible</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($membership->products as $purchase)

                                                    @if(Str::substr($purchase->fecha_membresia, 0,7) =="2023-11" )
                                                    <tr>
                                                        <td>
                                                            <div class="img-container ">
                                                                @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                @endif
                                                            </div>
                                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                        </td>
                                                        <td>
                                                            @if(now() >= $purchase->fecha_membresia)
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                Descarga inmediata
                                                            </button>
                                                            @else
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading14">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse14" aria-expanded="false" aria-controls="collapse14">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/diciembre.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            Diciembre 2023
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse14" class="collapse" role="tabpanel" aria-labelledby="heading14" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="table-responsive px-0">
                                            <table class="table table-hover table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th><b>Producto</b></th>
                                                        <th><b>Disponible</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($membership->products as $purchase)

                                                    @if(Str::substr($purchase->fecha_membresia, 0,7) =="2023-12" )
                                                    <tr>
                                                        <td>
                                                            <div class="img-container ">
                                                                @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                @endif
                                                            </div>
                                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                        </td>
                                                        <td>
                                                            @if(now() >= $purchase->fecha_membresia)
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                Descarga inmediata
                                                            </button>
                                                            @else
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading15">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse15" aria-expanded="false" aria-controls="collapse15">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/enero.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            Enero 2024
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse15" class="collapse" role="tabpanel" aria-labelledby="heading15" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="table-responsive px-0">
                                            <table class="table table-hover table-shopping">
                                                <thead>
                                                    <tr>
                                                        <th><b>Producto</b></th>
                                                        <th><b>Disponible</b></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($membership->products as $purchase)

                                                    @if(Str::substr($purchase->fecha_membresia, 0,7) =="2024-01" )
                                                    <tr>
                                                        <td>
                                                            <div class="img-container ">
                                                                @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                @endif
                                                            </div>
                                                            <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                            <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                        </td>
                                                        <td>
                                                            @if(now() >= $purchase->fecha_membresia)
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                Descarga inmediata
                                                            </button>
                                                            @else
                                                            <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                            </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading16">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse16" aria-expanded="false" aria-controls="collapse16">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/febrero.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            febrero 2024
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse16" class="collapse" role="tabpanel" aria-labelledby="heading16" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="card-body rgba-teal-strong white-text">
                                            <div class="table-responsive px-0">
                                                <table class="table table-hover table-shopping">
                                                    <thead>
                                                        <tr>
                                                            <th><b>Producto</b></th>
                                                            <th><b>Disponible</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($membership->products as $purchase)

                                                        @if(Str::substr($purchase->fecha_membresia, 0,7) =="2024-02" )
                                                        <tr>
                                                            <td>
                                                                <div class="img-container ">
                                                                    @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                    <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                    @endif
                                                                </div>
                                                                <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                            </td>
                                                            <td>
                                                                @if(now() >= $purchase->fecha_membresia)
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    Descarga inmediata
                                                                </button>
                                                                @else
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                                </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading17">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse17" aria-expanded="false" aria-controls="collapse17">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/marzo.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            marzo 2024
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse17" class="collapse" role="tabpanel" aria-labelledby="heading17" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="card-body rgba-teal-strong white-text">
                                            <div class="table-responsive px-0">
                                                <table class="table table-hover table-shopping">
                                                    <thead>
                                                        <tr>
                                                            <th><b>Producto</b></th>
                                                            <th><b>Disponible</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($membership->products as $purchase)

                                                        @if(Str::substr($purchase->fecha_membresia, 0,7) =="2024-03" )
                                                        <tr>
                                                            <td>
                                                                <div class="img-container ">
                                                                    @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                    <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                    @endif
                                                                </div>
                                                                <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                            </td>
                                                            <td>
                                                                @if(now() >= $purchase->fecha_membresia)
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    Descarga inmediata
                                                                </button>
                                                                @else
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                                </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading18">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse18" aria-expanded="false" aria-controls="collapse18">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/abril.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            abril 2024
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse18" class="collapse" role="tabpanel" aria-labelledby="heading18" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="card-body rgba-teal-strong white-text">
                                            <div class="table-responsive px-0">
                                                <table class="table table-hover table-shopping">
                                                    <thead>
                                                        <tr>
                                                            <th><b>Producto</b></th>
                                                            <th><b>Disponible</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($membership->products as $purchase)

                                                        @if(Str::substr($purchase->fecha_membresia, 0,7) =="2024-04" )
                                                        <tr>
                                                            <td>
                                                                <div class="img-container ">
                                                                    @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                    <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                    @endif
                                                                </div>
                                                                <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                            </td>
                                                            <td>
                                                                @if(now() >= $purchase->fecha_membresia)
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    Descarga inmediata
                                                                </button>
                                                                @else
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                                </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->

                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading19">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse19" aria-expanded="false" aria-controls="collapse19">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/mayo.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            mayo 2024
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse19" class="collapse" role="tabpanel" aria-labelledby="heading19" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="card-body rgba-teal-strong white-text">
                                            <div class="table-responsive px-0">
                                                <table class="table table-hover table-shopping">
                                                    <thead>
                                                        <tr>
                                                            <th><b>Producto</b></th>
                                                            <th><b>Disponible</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($membership->products as $purchase)

                                                        @if(Str::substr($purchase->fecha_membresia, 0,7) =="2024-05" )
                                                        <tr>
                                                            <td>
                                                                <div class="img-container ">
                                                                    @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                    <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                    @endif
                                                                </div>
                                                                <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                            </td>
                                                            <td>
                                                                @if(now() >= $purchase->fecha_membresia)
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    Descarga inmediata
                                                                </button>
                                                                @else
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                                </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->
                            <!-- Accordion card -->
                            <div class="card">

                                <!-- Card header -->
                                <div class="card-header z-depth-1 teal" role="tab" id="heading21">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx2" href="#collapse21" aria-expanded="false" aria-controls="collapse21">
                                        <div class="col-12 text-center">
                                            <img src=" {{ asset('./img/meses/junio.png') }} " alt="" width="70">
                                        </div>
                                        <h4 class="mb-0 black-text text-center font-weight-bold text-uppercase text-info">
                                            junio 2024
                                        </h4>
                                    </a>
                                </div>

                                <!-- Card body -->
                                <div id="collapse21" class="collapse" role="tabpanel" aria-labelledby="heading21" data-parent="#accordionEx2">
                                    <div class="card-body rgba-teal-strong white-text">
                                        <div class="card-body rgba-teal-strong white-text">
                                            <div class="table-responsive px-0">
                                                <table class="table table-hover table-shopping">
                                                    <thead>
                                                        <tr>
                                                            <th><b>Producto</b></th>
                                                            <th><b>Disponible</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($membership->products as $purchase)

                                                        @if(Str::substr($purchase->fecha_membresia, 0,7) =="2024-06" )
                                                        <tr>
                                                            <td>
                                                                <div class="img-container ">
                                                                    @if ($purchase->itemMain && Storage::exists('public/'.$purchase->itemMain))
                                                                    <img src="{{ Storage::url($purchase->itemMain) }}" alt="...">
                                                                    @endif
                                                                </div>
                                                                <span class="h5"><small>{{ $purchase->title }} </small></span>
                                                                <br><small>Archivo en formato {{ $purchase->format }} </small>
                                                            </td>
                                                            <td>
                                                                @if(now() >= $purchase->fecha_membresia)
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    Descarga inmediata
                                                                </button>
                                                                @else
                                                                <button class="btn  btn-primary btn-link show-spinner  px-0" disabled>
                                                                    {{date_format(new DateTime($purchase->fecha_membresia), 'd-M-Y')}}
                                                                </button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Accordion card -->











                        </div>
                        <!--/.Accordion wrapper-->

                    </div>










                    <!-- <div class="col-12 text-center mt-5 text-muted">
                        <h1 class="mb-5">Membresía en preventa</h1>
                        <h2>👉🏻Material disponible a partir del 21 de julio del 2023.🫶🏻</h2>
                        <h4>🌈Por que ustedes lo pidieron muchos de NUESTROS RECURSOS serán EDITABLES para que puedan ajustarlo a sus necesidades!!!!🌟🫶🏻</h4>

                    </div> -->

                </div>

            </div>









        </div>
        @include('includes.borders')
    </div>
</div>