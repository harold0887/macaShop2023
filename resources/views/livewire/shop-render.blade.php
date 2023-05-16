<div class="container-fluid  p-0 ">
    @include('includes.modal.cart-modal')
    @include('includes.spinner-livewire')
    <div class="content-main  rounded">
        @include('includes.borders')
        <div class="row pt-2 justify-content-center">

            <div class="col-10 col-md-8 pr-0">
                <form class="form-group">
                    <div class="input-group rounded">
                        <input id="input-search" type="search" class="form-control px-3" placeholder=" Buscar por titulo..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                    </div>
                </form>
            </div>
            <div class="col-2 col-lg-1 p-0">
                <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                    <i class="material-icons " style="color:#c09aed">search</i>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Tabs navs -->
                <ul class="nav nav-pills border-bottom justify-content-center mb-3" id="ex-with-icons" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href=" {{route('shop.index')}}"><i class="material-icons p-0">shopping_bag</i>Tienda</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" href=" {{route('paquete')}}" style="position:relative"><i class="material-icons p-0">library_add</i>Paquetes
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-info mt-1">
                                Nuevo
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        </a>
                    </li>
                </ul>
                <!-- Tabs navs -->
            </div>

        </div>



        <div class="row justify-content-center ">
            <div class="col-12 col-lg-9">
                <!--row products-->
                <div class="row  justify-content-center px-2 mt-2">
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
                            <div class="card-body px-2 pb-0 ">
                                <div class="card-actions text-center pt-4">
                                    <div class="d-flex justify-content-center">
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
                                <div class="card-description mt-4 ">

                                    @foreach($product->membresias as $membresia)
                                    <div class="text-left">
                                        <i class="material-icons my-auto mr-1 text-xs text-success">check</i>
                                        <span class="text-xs text-muted">Disponible en membresía {{$membresia->title}} </span>
                                    </div>
                                    @endforeach




                                    <a href=" {{ route('shop.show', $product->slug) }} " class="btn   btn-link text-info text-xs">
                                        Más informacion
                                    </a>

                                    <div class="text-left">
                                        @foreach($product->categorias as $categoria)
                                        <span class="badge badge-sm badge-success mr-1" style="cursor:pointer" wire:click="setCategory('{{ $categoria->id }}')">{{$categoria->name}}</span>
                                        @endforeach
                                    </div>

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
                                    <div class=" stats ">
                                    </div>
                                    <div class="price ">
                                        <p class="item-price text-primary ">$ {{ $product->price_with_discount }}</p>
                                    </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="col-12 col-lg-8 text-center">
                        <video class="rounded  w-75 " src="{{asset('img/oops.mp4')}}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                    </div>


                    @endif


                </div>
                <!--end row Products-->









            </div>


            <div class="col-11 col-lg-3  order-first order-lg-last">
                <div class="row px-1">
                    <div class="col-12 shadow  rounded py-2">
                        <div class="d-flex d-block d-lg-none " id="sidebarCollapse1">
                            <span class=" font-bold text-primary" id="text-filter">Mostrar filtros</span>
                            <i id="icon-filter" class="material-icons text-primary">add </i>
                        </div>


                        <div class=" bg-white rounded ">
                            @if ($search != '' || $categoriesSelect != null ||$gradeSelect != null)
                            <h4 class="h6 font-bold  text-center mt-2">
                                Busqueda actual ({{$products->total()}} resultados)
                            </h4>
                            @endif



                            @if ($search != '')
                            <div class="d-flex mt-3">
                                <span class="text-base mr-2 h6">{{$search}} </span>
                                <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearSearch()"></i>
                            </div>
                            @endif

                            @if ($categoriesSelect != null)
                            <div class="d-flex mt-3">
                                <span class="text-base mr-2 h6">Categoria(s) </span>
                                <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearCategories()"></i>
                            </div>


                            @if (isset($categories) && $categories->count() > 0)
                            @foreach ($categories as $category)
                            @foreach($categoriesSelect as $cat)
                            @if($category->id == $cat)
                            <span class="badge badge-sm badge-secondary mr-1">{{$category->name}}</span>
                            @endif
                            @endforeach
                            @endforeach
                            @endif
                            @endif

                            @if ($gradeSelect != null)
                            <div class="d-flex mt-3">
                                <span class="text-base mr-2 h6">Grado(s) </span>
                                <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearGrade()"></i>
                            </div>

                            @if (isset($degrees) && $degrees->count() > 0)
                            @foreach ($degrees as $grade)
                            @foreach($gradeSelect as $gra)
                            @if($grade->id == $gra)
                            <span class="badge badge-sm badge-secondary mr-1">{{$grade->name}}</span>
                            @endif
                            @endforeach
                            @endforeach
                            @endif
                            @endif



                            <div id="sidebar11" class="d-none d-lg-block">
                                <h4 class="h6 font-bold text-primary text-center mt-2">
                                    Filtrar por:
                                </h4>
                                <div class="accordion " id="acordionCategory">
                                    <div class="accordion-item" style="border: solid 1px white !important">
                                        <h2 class="accordion-header " id="headingOne">
                                            <button class="accordion-button  py-0 px-2" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="material-icons my-auto mr-2 text-info">category</i><span class="text-muted">Categoria</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse " aria-labelledby="headingOne" data-mdb-parent="#acordionCategory">
                                            <div class="accordion-body px-2">

                                                @if (isset($categories) && $categories->count() > 0)
                                                @foreach ($categories as $category)
                                                <div class="form-check pt-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" value="{{ $category->id}}" wire:model="categoriesSelect"> {{ $category->name}}


                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="accordion " id="acordeonGrade">

                                    <div class="accordion-item" style="border: solid 1px white !important">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button  py-0 px-2" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                <i class="material-icons my-auto mr-2 text-info">grain</i> <span class="text-muted">Grado</span>
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse   " aria-labelledby="headingTwo" data-mdb-parent="#acordeonGrade">
                                            <div class="accordion-body px-2">
                                                @if (isset($degrees) && $degrees->count() > 0)
                                                @foreach ($degrees as $grade)
                                                <div class="form-check pt-2">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" value="{{ $grade->id}}" wire:model="gradeSelect">
                                                        {{$grade->name}}
                                                        <span class="form-check-sign">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                @endforeach
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>




                        </div>
                    </div>
                    <div class="col-12 shadow  rounded py-2 mt-5 d-none d-lg-block">
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








            </div>
        </div>
        @include('includes.borders')
    </div>
</div>