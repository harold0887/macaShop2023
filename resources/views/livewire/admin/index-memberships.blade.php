<div class="content pt-0">
    @include('includes.spinner-livewire')
    <div class="container-fluid">

        <div class="row ">



            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">card_membership</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Membresias ({{$memberships->total()}} registros).</h4>
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
                                    <input id="input-search" type="search" class="form-control px-3" placeholder=" Buscar por nombre..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                </div>
                            </form>
                        </div>
                        <div class="col-2 col-lg-1 p-0">
                            <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                                <i class="material-icons " style="color:#c09aed">search</i>
                            </button>
                        </div>


                        <div class="col-12 col-md-3 text-right">
                            <a class="btn btn-primary btn-block" href="{{ route('memberships.create') }}">
                                <i class="material-icons">add_circle</i>
                                <span>Nueva membresia</span>
                            </a>
                        </div>
                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $memberships->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($memberships) && $memberships->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th style="cursor:pointer" wire:click="setSort('title')">
                                            @if($sortField=='title')
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
                                        <th style="cursor:pointer" wire:click="setSort('discount_percentage')">
                                            @if($sortField=='discount_percentage')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            descuento
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('price_with_discount')">
                                            @if($sortField=='price_with_discount')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif


                                            Precio final
                                        </th>
                                        <th>Materiales</th>
                                        <th style="cursor:pointer" wire:click="setSort('start')">
                                            @if($sortField=='start')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Inicio
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('expiration')">
                                            @if($sortField=='expiration')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Fin
                                        </th>
                                        <th>Vigencia</th>
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
                                            Estatus
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('main')">
                                            @if($sortField=='main')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Ofreta
                                        </th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($memberships as $membership)
                                    <tr class="{{ $membership->status == 0 ? 'text-danger' : '' }}">

                                        <td>{{ $membership->title }}</td>
                                        <td>{{ $membership->price }}</td>
                                        <td>{{ $membership->discount_percentage }}%</td>
                                        <td>{{ $membership->price_with_discount }}</td>
                                        <td>{{ $membership->products->count() }}</td>
                                        <td>{{date_format(new DateTime($membership->start),'d-M-Y')}} </td>
                                        <td>{{date_format(new DateTime($membership->expiration),'d-M-Y')}} </td>
                                        <td>{{ $membership->vigencia }}</td>
                                        <td>
                                            <div class="togglebutton" wire:click="changeStatus({{ $membership->id }}, '{{ $membership->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $membership->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="togglebutton" wire:click="changeMain({{ $membership->id }}, '{{ $membership->main }}')">
                                                <label>
                                                    <input type="checkbox" {{ $membership->main == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="td-actions">
                                            <a class="btn btn-success btn-link" href="{{ route('memberships.edit', $membership->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a class="btn btn-success btn-link text-danger" onclick="confirmDelete('{{ $membership->id }}', '{{ $membership->title }}')">
                                                <i class="material-icons ">close</i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $memberships->links() }}
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
        //Confirmar eliminar producto
        function confirmDelete($id, $name) {
            var respuesta = confirm("Realmente desea eliminar: " + $name)
            if (respuesta == true) {

                Livewire.emit('delete', $id);
            } else {
                swal("¡cancel!", 'Tu archivo está seguro :)', "error");
            }
        }
    </script>
</div>