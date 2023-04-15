@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'home',
'title' =>"Inicio",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary'
])

@section('content')

@include('includes.cart-1')

<div class="container d-flex justify-content-center  p-0">

    <div class="content-main ">
        <div class="d-block d-lg-none">
            <div class="row ">

                <div class="col-2">
                    <img src=" {{ asset('./img/logo2.png') }} " alt="" width="100">

                </div>
                <div class="col-10 ">
                    <div class="row">
                        <div class="col-6 text-right px-0">
                            <a href="{{route('shop.index')}}" class="btn  btn-round " style="background-color: #52cfdd;">
                                Tienda
                            </a>
                        </div>
                        <div class="col-6 text-left px-0">
                            <a href="" class="btn btn-round" style="background-color: #fcc552;">
                                Gratiutos
                            </a>
                        </div>

                    </div>
                    <div class="row justify-content-center">
                        <div class="col-9 text-center">
                            <a href=" {{ route('membership') }}" class="btn  btn-round w-100 ml-2" style="background-color: #a578da;">
                                Membresia VIP
                            </a>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div class="row justify-content-center pr-2">

            <div class="col-10 col-lg-11 pr-0">
                <form class="form-group">
                    <div class="input-group rounded">
                        <input id="input-search" type="search" class="form-control px-3" placeholder="Buscar título, categoria, grado, etc...">
                    </div>
                </form>
            </div>
            <div class="col-2 col-lg-1 ">
                <button type="submit" class="btn bg-transparent  btn-round btn-just-icon" style="border:solid 1px #c09aed">
                    <i class="material-icons " style="color:#c09aed">search</i>
                </button>
            </div>


        </div>


        <div class="row mt-3">
            <div class="col-12">
                <!-- Button trigger modal-->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAbandonedCart">Launch
                    modal</button>

            </div>
            <div class="col-12 rounded">
                <div id="carousel-home" class="carousel slide carousel-fade d-none d-md-block" data-mdb-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-mdb-target="#carouselHome" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{asset('img/slide/slide1.png')}}" class="d-none d-md-block w-100 rounded" alt="...">
                        </div>
                    </div>
                </div>

                <div id="carousel-mobile" class="carousel slide carousel-fade d-block d-md-none" data-mdb-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-mdb-target="#carouselHome" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>

                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{asset('img/slide/slide1-mobile.jpeg')}}" class="d-block d-md-none w-100 rounded" alt="...">
                        </div>
                    </div>
                </div>

            </div>
        </div>






        <div class="row justify-content-center  justify-content-md-center   justify-content-lg-between mt-3">


            <div class="col-12  col-md-6 col-lg-6  px-5 ">
                <a style="color: inherit" href="">
                    <div class="row ">
                        <div class="col-12 col-sm-5 align-self-end">
                            <img src="{{asset('img/slide/membresia2.png')}}" class="w-100 d-none d-sm-block" alt="...">
                        </div>
                        <div class="col-12 col-sm-7  border rounded">
                            <div class="row rounded">
                                <div class="col-12 text-center rounded-top bg-primary-light pt-2">

                                    <h1 class="text-white   text-4xl sm:text-4x1 md:text-4xl  lg:text-4xl   " style="font-family: 'Fredericka the Great'">MEMBRESÍA</h1>
                                    <h1 class="text-white text-5xl sm:text-5x1 md:text-6xl  lg:text-6xl" style="font-family: 'Indie Flower'">Primaria</h1>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h3 class="text-primary-light">SEMESTRAL</h3>
                                            <h1 class="font-weight-bold ">
                                                <small class=" text-mindle align-top ">$</small>320.00<small class="text-md"></small>
                                            </h1>
                                            <small class="text-muted">VIGENCIA DE JULIO A DIECIEMBRE 2023
                                            </small>
                                        </div>
                                        <div class="col-12 text-center">
                                            <h3 class="text-primary-light">ANUAL</h3>

                                            <h1 class="font-weight-bold ">
                                                <small class=" text-mindle align-top ">$</small>590.00<small class="text-md"></small>
                                            </h1>


                                            <small class="text-muted">VIGENCIA DE JULIO A JUNIO 2023-2024

                                            </small>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button class="btn   btn-rose btn-round ">Más informacion</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </a>
            </div>
            <div class="col-12  col-md-6 col-lg-6  px-5 pt-3 pt-lg-0">
                <a style="color: inherit" href="">
                    <div class="row  rouded">
                        <div class="col-12 col-sm-7 rounded border  ">
                            <div class="row rounded">
                                <div class="col-12 text-center rounded-top bg-rose-light pt-2">

                                    <h1 class="text-white   text-4xl sm:text-4x1 md:text-4xl  lg:text-4xl   " style="font-family: 'Fredericka the Great'">MEMBRESÍA</h1>
                                    <h1 class="text-white text-5xl sm:text-5x1 md:text-6xl  lg:text-6xl" style="font-family: 'Indie Flower'">Preescolar</h1>

                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h3 class="text-rose-light">SEMESTRAL</h3>
                                            <h1 class="font-weight-bold ">
                                                <small class=" text-mindle align-top ">$</small>320.00<small class="text-md"></small>
                                            </h1>
                                            <small class="text-muted">VIGENCIA DE JULIO A DIECIEMBRE 2023
                                            </small>
                                        </div>
                                        <div class="col-12 text-center">
                                            <h3 class="text-rose-light">ANUAL</h3>

                                            <h1 class="font-weight-bold ">
                                                <small class=" text-mindle align-top ">$</small>590.00<small class="text-md"></small>
                                            </h1>


                                            <small class="text-muted">VIGENCIA DE JULIO A JUNIO 2023-2024

                                            </small>
                                        </div>
                                        <div class="col-12 text-center ">
                                            <button class="btn   btn-rose btn-round ">Más informacion</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5 align-self-end">
                            <img src="{{asset('img/slide/membresia1.png')}}" class="w-100 d-none d-sm-block" alt="...">
                        </div>
                    </div>


                </a>
            </div>




        </div>













    </div>
</div>






@endsection