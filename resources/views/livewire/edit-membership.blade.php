<div class="row ">

    <div class="col-12 col-lg-6 shadow rounded">
        <h4 class="title  text-center text-muted">Documentos incluidos en el paquete</h4>
        @foreach($membership->products as $item)
        <div class="row justify-content-center">
            <div class="col-7 col-md-3">
                <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
            </div>
            <div class="col-12 col-md-9 align-self-center text-center text-lg-left">
                <p>
                    <b class="text-sm sm:text-1x1  ">{{ $item->title }}</b>
                    <br>
                </p>
            </div>

        </div>
        @endforeach



    </div>
    <div class="col-12 col-lg-6 shadow rounded">
        <h4 class="title  text-center text-muted">Agregar documentos al paquete</h4>
        @foreach($products as $products)

        <div class="row pt-2">

            <div class="col-12 col-lg-8 align-self-center text-center text-lg-left">
                <p>
                    <b class="text-sm sm:text-1x1 ">{{ $products->title }}</b>
                    <br>
                </p>
            </div>
            <div class="col-6 col-lg-2 text-center ">
                <button class="btn p-1  btn-success p-0" wire:click="addToPackage('{{ $products->id }}')">
                    <i class="material-icons">add</i>
                    Agergar
                </button>
            </div>
            <div class="col-6 col-lg-2 text-center ">
                @foreach($membership->products as $item)

                @if($item->id == $products->id )
                <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeToPackage('{{ $products->id }}')">
                    <i class="material-icons">close</i>
                    Quitar
                </button>

                @endif

                @endforeach
            </div>
        </div>

        @endforeach

    </div>
</div>