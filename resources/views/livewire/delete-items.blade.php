<div class="form-row mt-lg-5 justify-content-center">
    <div class="col-12 text-center">
        <h4>Imagen actuales ({{$product->items->count()}})</h4>
    </div>

    @if($product->video)
    <div class="col-3 col-lg-1 text-center">
        <div class="fileinput-new thumbnail">
        <video class="rounded  w-100 " src="{{ Storage::url($product->video) }}" autoplay muted loop    ></video>
        </div>
        <button type="button" class="btn-link btn btn-danger" title="Eliminar" data-mdb-placement="top" wire:click="deleteVideo('{{$product->id}}')">
            <i class="material-icons my-auto mr-2 text-danger">close</i>
        </button>
    </div>
    @endif




    @foreach($product->items as $item)
    <div class="col-3 col-lg-1 text-center">
        <div class="fileinput-new thumbnail">
            <img class="w-100" src="{{ Storage::url($item->photo)  }}" alt="...">
        </div>
        <button type="button" class="btn-link btn btn-danger" title="Eliminar" data-mdb-placement="top" wire:click="delete('{{$item->id}}')">
            <i class="material-icons my-auto mr-2 text-danger">close</i>
        </button>
    </div>
    @endforeach





</div>