    @extends('layouts.app',[
    'title'=>'Productos',
    'navbarClass'=>'navbar-transparent',
    'activePage'=>'products',

    ])
    @section('content')
    <div class="content  pt-0">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">

                    <h1 class="rounded text-center text-primary text-xl sm:text-2x1 md:text-3xl  lg:text-3xl font-weight-bold mb-4" style="color:#e91e63;box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(233, 30, 99, 0.4);">{{ $product->title }}</h1>
                </div>
            </div>
            <div class="row">
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
                <div class="col-12 col-lg-4 ">
                    <div class="row @if(!$product->video) mt-3 mt-lg-0 @endif">
                        <div class="col-7 col-lg-12 px-2 ">
                            @include('includes.acordion')
                        </div>
                        <div class="col-5 col-lg-12 text-center">
                            <h2 class="font-weight-bold text-muted ">
                                <small class=" text-mindle align-top ">$</small>{{ $product->price_with_discount }}<small class="text-md"></small>
                            </h2>
                            <a href="{{ route('products.edit', $product->id) }}">
                                <button class=" btn btn-primary btn-round " id="btn-cart-product">
                                    <span class="material-icons">edit</span>
                                    <span>Editar</span>
                                </button>
                            </a>
                        </div>


                    </div>



                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2>Lista de compras</h2>
                </div>
                <div class="col-12">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>

                                    <th>
                                        Order ID
                                    </th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product->orders as $order)
                                <tr>
                                    <td>{{ $order->order_id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>





                </div>
            </div>

























        </div>

    </div>




    @endsection