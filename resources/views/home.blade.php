@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'home',
'title' =>"Inicio",
'pageBackground' => asset("material").'/img/login.jpg',
'navbarClass'=>'text-primary',
'background'=>'#eee !important'
])

@section('content')

@include('includes.cart-1')


<div class="container-fluid  p-0 ">

    <div class="content-main ">

        @include('includes.borders')
        <div class="d-block d-lg-none">
            <div class="row">

                <div class="col-2 pt-2">
                    <img src=" {{ asset('./img/logo2.png') }} " alt="" width="120">

                </div>
                <div class="col-10 ">
                    <div class="row">
                        <div class="col-6 text-right px-0">
                            <a href="{{route('shop.index')}}" class="btn  btn-round " style="background-color: #52cfdd;">
                                Tienda
                            </a>
                        </div>
                        <div class="col-6 text-left px-0">
                            <a href="{{ route('free') }}" class="btn btn-round" style="background-color: #fcc552;">
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

        <div class="d-none d-lg-block">
            <div class="row pt-2 justify-content-center ">


                <div class="col-10 col-md-8 pr-0">
                    <form class="form-group">
                        <div class="input-group rounded">
                            <input id="input-search-home1" type="search" class="form-control px-3  " placeholder=" Buscar por título..." style="border-radius: 18px !important">

                        </div>
                    </form>

                </div>
                <div class="col-2 col-lg-1 p-0">
                    <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                        <i class="material-icons " style="color:#c09aed">search</i>
                    </button>
                </div>
            </div>
        </div>




        <div class="row ">
            <div class="col-12 rounded  px-0">
                <div class="">
                    @if(isset($newsDesktop) && $newsDesktop->items->count() >0)
                    <div id="carouselDesktop" class="carousel slide carousel-fade" data-mdb-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($newsDesktop->items as $item)
                            <button class=" bg-primary @if ($loop->first) active  @endif" data-mdb-target="#carouselDesktop" data-mdb-slide-to="{{ $loop->index }}" aria-label="Slide {{ $loop->index+1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($newsDesktop->items as $item)
                            <div class="carousel-item   @if ($loop->first) active  @endif  ">
                                <img class=" w-100 d-block shadow" src="{{ Storage::url($item->photo) }}" alt="">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>


            </div>
        </div>
        <div class="row justify-content-between mt-3 px-2">

            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('shop.index')}}">
                    <div class="rounded" style=" background-color:#FF2D82;">
                        <video class="rounded  w-100 " src="{{asset('img//tienda.mp4')}}" autoplay muted loop></video>

                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('membership')}}">
                    <div class="rounded" style=" background-color:#FCC552">

                        <video class="rounded  w-100 " src="{{asset('img//preescolar.mp4')}}" autoplay muted loop></video>
                    </div>
                </a>


            </div>
            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('membership')}}">
                    <div class="rounded" style=" background-color:#52CFDD">
                        <video class="rounded  w-100 " src="{{asset('img//primaria.mp4')}}" autoplay muted loop></video>
                    </div>
                </a>



            </div>
            <div class="col-6 col-md-3 p-1 text-center">
                <a href="{{route('free')}}">
                    <div class="rounded" style=" background-color:#A578DA">
                        <video class="rounded  w-100 " src="{{asset('img//gratis.mp4')}}" autoplay muted loop></video>
                    </div>
                </a>


            </div>

        </div>


        <livewire:novedades />
      


        <div class="row mt-3">
            <div class="col-12">
                <h1 class=" lg:pt-12 md:text-3xl  text-center  text-2xl">La mejor opción para <span style="color:#A578DA" class="fw-bold">personas que enseñan desde el corazón.</span></h1>
                <p class="text-center mx-2 text-justify">¿Buscas material didáctico o material para decorar el aula? en
                    <span style="color:#A578DA">Material didáctico MaCa
                        <i class="material-icons animate__animated  animate__pulse animate__infinite 	infinite	 animate__slow  text-sm">favorite</i>
                    </span> tenemos algo para ti.
                </p>
                <div class="row mt-5">
                    <div class="col-12 col-lg-6 pl-5 pr-4 align-self-center ">
                        <div class="row ">
                            <div class="col-auto">
                                <div class=" rounded p-3" style="background: linear-gradient(140deg,rgba(146,205,250,.5),rgba(215,215,255,.4) 95%);">
                                    <span style="color:#A578DA" class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite	 animate__slow ">
                                        kid_star
                                    </span>
                                </div>

                            </div>
                            <div class="col">
                                <p class="fw-bold my-0">Contenido de gran calidad</p>
                                <p class="text-justify">Descarga materiales didácticos con el mejor diseño e imágenes de gran calidad que llamarán la atención de los peques.</p>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-auto">
                                <div class=" rounded p-3" style="background: linear-gradient(140deg,rgba(146,205,250,.5),rgba(215,215,255,.4) 95%);">
                                    <span style="color:#A578DA" class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite	 animate__slow ">
                                        card_membership
                                    </span>
                                </div>

                            </div>
                            <div class="col">
                                <p class="fw-bold my-0">Acceso a nuestras membresías</p>
                                <p class="text-justify">¡Disfruta más de 100 materiales en cada una de nuestras membresías! 
                                    <strong style="color:#A578DA">Membresía preescolar</strong> y
                                    <strong style="color:#A578DA">Membresía primaria</strong>, se
                                    convertirán en tu
                                    <strong style="color:#A578DA">
                                        mejor aliado.
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <div class=" rounded p-3" style="background: linear-gradient(140deg,rgba(146,205,250,.5),rgba(215,215,255,.4) 95%);">
                                    <span style="color:#A578DA" class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite	 animate__slow ">
                                        search
                                    </span>


                                </div>

                            </div>
                            <div class="col">
                                <p class="fw-bold my-0">Recursos actualizados</p>
                                <p class="text-justify">Mejoramos constantemente para ofrecerte un catálogo actualizado de nuestros materiales didácticos.</p>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-auto">
                                <div class=" rounded p-3" style="background: linear-gradient(140deg,rgba(146,205,250,.5),rgba(215,215,255,.4) 95%);">
                                    <span style="color:#A578DA" class="material-symbols-outlined animate__animated  animate__pulse animate__infinite 	infinite	 animate__slow">
                                        check_circle
                                    </span>
                                </div>

                            </div>
                            <div class="col">
                                <p class="fw-bold my-0">Descarga inmediata</p>
                                <p class="text-justify">Los recursos comprados se pueden descargar inmediatamente desde su cuenta.</p>
                            </div>
                        </div>




                    </div>
                    <div class="col-12 col-lg-6">
                        <img class="w-100 " style="border-radius: 20px 120px 20px 120px !important" alt="" src="https://img.freepik.com/foto-gratis/retrato-hermosa-maestra-preescolar-hispana-ensenando-sus-alumnos-salon-clases_662251-1614.jpg?w=1380&t=st=1705795985~exp=1705796585~hmac=5bd052840f45312171440aadbf6814ba6ec6d022f54660d8412d0611faae77b1">
                    </div>
                </div>
            </div>







        </div>

        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="pt-5  md:text-3xl  text-center  text-2xl ">
                        ¿Aún no estás convencid@?
                    </h2>

                    <p style="color:#4d4d4d" class="mx-2">
                        Mira lo que lo que piensan los clientes de nuestros materiales didácticos.

                    </p>

                </div>
            </div>
        </div>


        <div>
            <div id="comments-slick" class="coments-autoplay " style="display: show">
                @if (isset($comments) && $comments->count() > 0)
                @foreach ($comments as $comment)
                <div class="px-5 px-lg-2  pb-5">
                    <div class="card card-testimonial " @if( $loop->index%2 != 0) style="border: solid 2px #A578DA; border-radius: 5px 5px 70px 5px !important" @else style="border: solid 2px #52CFDD; border-radius: 5px 5px 70px 5px !important" @endif ">

                        <div class="card-body ">
                            <h5 class="card-description" style="height: 100px;">
                                {{Str::limit($comment->comment,200)}}
                            </h5>
                        </div>
                        <div class="card-footer">

                            <h4 class="card-title fw-bold" style="color: #A578DA">
                                @php
                                $name = explode(" ", $comment->user->name);
                                echo $name[0];
                                @endphp

                            </h4>
                            <!-- <div class="card-avatar" @if( $loop->index%2 != 0) style="border: solid 2px #A578DA" @else style="border: solid 2px #52CFDD" @endif ">
                                @if ($comment->user->picture)
                                <img class="img" src="{{Storage::url($comment->user->picture)}}">
                                @else
                                <img class="img" src="{{ asset('material') }}/img/placeholder.jpg" alt="...">
                                @endif

                            </div> -->

                        </div>
                    </div>
                </div>

                @endforeach
                @endif
            </div>
        </div>




        @include('includes.borders')












    </div>
</div>






@endsection

@push('js')
<script>
    $("#input-search-home,#input-search-home1").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{route('search.products')}}",
                dataType: 'json',
                data: {
                    term: request.term
                },
                success: function(data) {
                    response(data)
                },

            })
        },
        select: function(event, ui) {
            window.location.href = "https://materialdidacticomaca.com/tienda/productos/" + ui.item.value
        }
    })
</script>



@endpush