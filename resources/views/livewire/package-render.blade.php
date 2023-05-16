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
                        <a class="nav-link " href=" {{route('shop.index')}}"><i class="material-icons p-0">shopping_bag</i>Tienda</a>
                    </li>
                    <li class="nav-item " role="presentation">
                        <a class="nav-link active" href=" {{route('paquete')}}" style="position:relative"><i class="material-icons p-0">library_add</i>Paquetes
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


        <div class="row  justify-content-center ">


            <div class="col-12 col-lg-9">


                <!--row Packages-->
                <div class="row  justify-content-center px-2 mt-2">
                    @if (isset($packages) && $packages->count() > 0)

                    @foreach ($packages as $package)


                    <div class="col-6 col-md-4 col-lg-3 mb-4 " style="position: relative; padding:5px !important">
                        <div class="card card-primary  card-product">
                            <div class="card-header  card-header-image mb-4 d-flex justify-content-center text-center" data-header-animation="true">
                                <a href=" {{route('paquete.show',$package->slug)}} ">

                                    <img class="img" src="{{ Storage::url($package->itemMain) }} ">


                                </a>
                            </div>
                            <div class="card-body px-2 pb-0 ">
                                <div class="card-actions text-center pt-4">
                                    <div class="d-flex justify-content-center">
                                        @if(!\Cart::get($package->id))
                                        <button class=" btn   btn-primary btn-round  px-2 w-full " wire:click="addCart('{{ $package->id }}','Package')">
                                            <i class="material-icons">shopping_cart</i>
                                            <span>Agregar al carrito</span>
                                        </button>
                                        @else
                                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-round">
                                            <i class="material-icons">visibility</i>
                                            <span>Ver en el carrito</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                                <h3 class="card-title pt-3  text-base ">

                                    <a href=""><strong>{{ $package->title }}</strong></a>
                                    @role('admin')
                                    <a class="btn btn-success btn-link p-0" href="{{ route('package.edit', $package->id) }}" target="_blank">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    @endrole

                                </h3>
                                <div class="card-description mt-4 ">






                                    <a href="{{route('paquete.show',$package->slug)}} " class="btn   btn-link text-info text-xs">
                                        Más informacion
                                    </a>



                                </div>
                            </div>
                            <div class="card-footer ">
                                @if ($package->price_with_discount < $package->price)
                                    <div class=" stats">
                                        <p style="text-decoration: line-through !important">$ {{ $package->price }}</p>
                                    </div>
                                    <div class="price">
                                        <p class="item-price text-primary ">$ {{ $package->price_with_discount }}</p>
                                    </div>
                                    @else
                                    <div class=" stats ">
                                    </div>
                                    <div class="price ">
                                        <p class="item-price text-primary ">$ {{ $package->price_with_discount }}</p>
                                    </div>
                                    @endif
                            </div>
                        </div>
                    </div>



                    @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        {{ $packages->links() }}
                    </div>
                    @else
                    <div class="col-12 col-lg-8 text-center">
                        <video class="rounded  w-75 " src="{{asset('img/oops.mp4')}}" autoplay muted loop style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);"></video>
                    </div>


                    @endif


                </div>
                <!--end row Packages-->

            </div>

            <div class="col-11 col-lg-3 order-first order-lg-last  px-2  rounded ">

                @if ($search != '' )
                <div class="membership-sticky bg-white rounded">
                    <h4 class="h6 font-bold  text-center mt-2">
                        Busqueda actual ({{$packages->total()}} resultados)
                    </h4>
                    <div class="d-flex mt-3">
                        <span class="text-base mr-2 h6">{{$search}} </span>
                        <i class="close fas fa-times text-danger" style="cursor:pointer" wire:click="clearSearch()"></i>
                    </div>
                </div>
                @endif


















            </div>



        </div>
        @include('includes.borders')
    </div>
</div>