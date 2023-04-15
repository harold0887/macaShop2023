<div class="container-fluid px-2 px-lg-4">
@include('includes.spinner-livewire')
    <div class="content-main">

        <div class="row justify-content-center pt-3">

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
                                    <a class="btn btn-success btn-link p-0" href="{{ route('products.edit', $product->id) }}">
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
                                @if ($product->price_with_discount < $product->price)
                                    <div class=" stats">
                                        <p class="item-discount text-secondary">$ {{ $product->price }}</p>
                                    </div>
                                    <div class="price">
                                        <p class="item-price text-primary ">$ {{ $product->price_with_discount }}</p>
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
                    <div class="col-12  text-center">
                        <img class=" w-100" src="{{ asset('img/oops.png') }} " alt="oops.png" />
                    </div>
                    @endif
                </div>

            </div>


            <div class="col-11 col-lg-3 order-first order-lg-last  px-2 bg-white rounded ">


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
                        <div id="collapseOne" class="accordion-collapse collapse d-hide d-lg-block" aria-labelledby="headingOne" data-mdb-parent="#acordionCategory">
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
                                <i class="material-icons my-auto mr-2 text-info">library_add</i> <span class="text-muted">Grado</span>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse d-hide d-lg-block " aria-labelledby="headingTwo" data-mdb-parent="#acordeonGrade">
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
</div>