<div class="accordion " id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header " id="headingOne">
            <button class="accordion-button  py-0 px-2" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <i class="material-icons my-auto mr-2 text-info">info</i>Informacion
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-mdb-parent="#accordionExample">
            <div class="accordion-body px-2">

                <div class="d-flex ">

                    <span class="text-sm lh-lg">{{ $product->information }} </span>
                </div>
                @foreach($product->membresias as $membresia)
                <a href="{{route('membership.show',$membresia->id)}}">
                    <span class="badge badge-sm badge-info m small px-1 mx-0" style="cursor:pointer">
                        Gratis en la membresía {{$membresia->title}}
                    </span>
                </a>
                @endforeach

            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed py-0 px-2" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <i class="material-icons my-auto mr-2 text-success">done</i> Detalles
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-mdb-parent="#accordionExample">
            <div class="accordion-body px-2">
                <div class="d-flex  mt-2 ">
                    <i class="material-icons my-auto mr-2 text-xs">done</i>
                    <span class="text-xs">Descarga inmediata. </span>
                </div>
                <div class="d-flex  mt-2 ">
                    <i class="material-icons my-auto mr-2 text-xs">done</i>
                    <span class="text-xs">Este es un archivo digital. </span>
                </div>
                <div class="d-flex  mt-2">
                    <i class="material-icons my-auto mr-2 text-xs">done</i>
                    <span class="text-xs">Recibirá un archivo en formato {{ $product->format }}. </span>
                </div>


            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed py-0 px-2" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="material-icons my-auto mr-2 text-warning">close</i> Restricciones
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-mdb-parent="#accordionExample">
            <div class="accordion-body px-2">
                <div class="d-flex mt-2">
                    <i class="material-icons my-auto mr-2 text-xs ">close</i>
                    <span class="text-xs">Editar o alterar alguna parte del documento. </span>
                </div>
                <div class="d-flex mt-2">
                    <i class="material-icons my-auto mr-2 text-xs">close</i>
                    <span class="text-xs">Revender el documento. </span>
                </div>
                <div class="d-flex mt-2">
                    <i class="material-icons my-auto mr-2 text-xs">close</i>
                    <span class="text-xs">Compartir el archivo en algún sitio web. </span>
                </div>
                <div class="d-flex mt-2">
                    <i class="material-icons my-auto mr-2 text-xs">close</i>
                    <span class="text-xs">Compartir el archivo en algúna red social o WhatsApp. </span>
                </div>
                <div class="d-flex mt-2">
                    <i class="material-icons my-auto mr-2 text-xs">close</i>
                    <span class="text-xs">No se aceptan devoluciones. </span>
                </div>


            </div>
        </div>
    </div>
</div>