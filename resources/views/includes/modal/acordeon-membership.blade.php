<div class="modal fade " id="staticBackdrop" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{isset($productModal)?$productModal->title:''}}</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            @if(isset($productModal))
            <div class="modal-body">
                <!-- Carousel wrapper -->
                <div id="carouselDarkVariant" class="carousel slide carousel-fade carousel-dark  " data-mdb-ride="carousel">
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        <button data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="0" class="active bg-primary" aria-current="true" aria-label="Slide 1"></button>

                        @foreach($productModal->items as $item)

                        <button class=" bg-primary" data-mdb-target="#carouselDarkVariant" data-mdb-slide-to="{{ $loop->index+1 }}" aria-label="Slide {{ $loop->index+2 }}"></button>
                        @endforeach


                    </div>

                    <!-- Inner -->
                    <div class="carousel-inner justify-content-center ">
                        <!-- Single item -->
                        <div class="carousel-item active  d-flex justify-content-center ">
                            <img class="rounded w-100 d-block d-xl-none border" src="{{ Storage::url($productModal->itemMain) }}" alt="" class="carousel-img">
                            <img class="rounded w-75 d-none d-xl-block border" src="{{ Storage::url($productModal->itemMain) }}" alt="" class="carousel-img">
                        </div>

                        @foreach($productModal->items as $item)
                        <div class="carousel-item   d-flex justify-content-center ">
                            <img class="rounded w-100 d-block d-xl-none border" src="{{ Storage::url($item->photo) }}" alt="" class="carousel-img">
                            <img class="rounded w-75 d-none d-xl-block border" src="{{ Storage::url($item->photo) }}" alt="" class="carousel-img">
                        </div>
                        @endforeach

                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="prev">
                        <span class="material-icons text-primary">arrow_back_ios</span>
                    </button>
                    <button class="carousel-control-next " type="button" data-mdb-target="#carouselDarkVariant" data-mdb-slide="next">
                        <span class="material-icons text-primary">arrow_forward_ios</span>
                    </button>
                </div>

            </div>
            <div class="px-2">
              <p class="small"> {{$productModal->information}} </p>
            </div>
            @endif
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>