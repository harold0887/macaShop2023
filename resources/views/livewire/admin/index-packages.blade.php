<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">

            @include('includes.spinner-livewire')

            <div class="col-12 ">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">library_add</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Paquetes ({{$packages->total()}} registros).</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            @if ($search != '')
                            <div class="d-flex mt-2">
                                <span class="text-base">Borrar filtros </span>
                                <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearSearch()">close</i>
                            </div>
                            @endif
                        </div>
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

                        <div class="col-12 col-md-3">
                            <a class="btn btn-primary btn-block " href="{{ route('package.create') }}">
                                <i class="material-icons">add_circle</i>
                                <span>Nuevo Paquete</span>
                            </a>
                        </div>
                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $packages->count() }} resultados obtenidos</small>

                            @endif
                        </div>

                        @if (isset($packages) && $packages->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th style="cursor:pointer" wire:click="setSort('name')">
                                            @if($sortField=='name')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            Nombre
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('price')">
                                            @if($sortField=='price')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Precio
                                        </th>
                                        <th>Materiales del paquete</th>
                                        <th style="cursor:pointer" wire:click="setSort('status')">
                                            @if($sortField=='status')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            Status


                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $product)
                                    <tr class="{{ $product->percentage >0 ?'text-danger':'' }}">

                                        <td>{{ $product->title }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->products->count() }}</td>
                                        <td>
                                            <div class="togglebutton" wire:click="changeStatusPackage({{ $product->id }}, '{{ $product->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $product->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>


                                        <td class="td-actions">

                                            <a href="{{ route('package.edit', $product->id) }}">
                                                <button type="button" rel="tooltip" class="btn btn-success btn-link d-inline" data-original-title="" title="">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                            </a>
                                            <button type="submit" class="btn btn-danger btn-link d-inline" onclick="confirmDelete('{{$product->id}}', '{{$product->title }}')">
                                                <i class="material-icons">close</i>
                                            </button>



                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="col-12">
                            <p class="alert alert-warning">⚠️ ¡Ooooups! No se encontraron resultados.</p>
                        </div>
                        @endif

                    </div>
                </div>
            </div>



        </div>
    </div>

    <script>
        function confirmDelete($id, $name) {
            var respuesta = confirm("Realmente desea eliminar: " + $name)
            if (respuesta == true) {
                Livewire.emit('deletePackage', $id);
            } else {
                demo.showSwal('cancel');
            }
        }
    </script>
</div>