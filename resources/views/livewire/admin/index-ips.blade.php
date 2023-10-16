<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">

            @include('includes.spinner-livewire')
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">circles_ext</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h4 class="card-title font-weight-bold">IPS ({{$ips->total()}} registros).</h4>
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
                                    <input id="input-search" type="search" class="form-control px-3" placeholder=" Buascar por nombre o email..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                </div>
                            </form>
                        </div>
                        <div class="col-2 col-lg-1 p-0">
                            <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                                <i class="material-icons " style="color:#c09aed">search</i>
                            </button>
                        </div>


                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $ips->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        <div class="col-12">
                            <small class="text-muted">{{ $lock->count() }} ips bloqueadas, </small>
                        </div>
                        @if (isset($ips) && $ips->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="cursor:pointer" wire:click="setSort('id')">
                                            @if($sortField=='id')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            ID
                                        </th>

                                        <th style="cursor:pointer" wire:click="setSort('ip')">
                                            @if($sortField=='ip')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            IP
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('tipo')">
                                            @if($sortField=='tipo')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Tipo
                                        </th>
                                        <th style="cursor:pointer">
                                            Nombre
                                        </th>
                                        <th style="cursor:pointer">
                                            Email
                                        </th>
                                        <th style="cursor:pointer">
                                            user id
                                        </th>
                                        <th style="cursor:pointer">
                                            Fecha
                                        </th>
                                        <th style="cursor:pointer">
                                            Status User
                                        </th>
                                        <th style="cursor:pointer">
                                            Status IP
                                        </th>
                                        <th style="cursor:pointer">
                                            Acciones </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ips as $ip)
                                    <tr>
                                        <td>{{ $ip->id }}</td>
                                        <td>{{ $ip->ip }}</td>
                                        <td>{{ $ip->tipo }}</td>
                                        <td>{{ $ip->user->name }}</td>
                                        <td>{{ $ip->user->email }}</td>
                                        <td>{{ $ip->user->id }}</td>
                                        <td>{{date_format($ip->created_at, 'd-M-Y h:m')}}</td>
                                        <td>
                                            <div class="togglebutton" wire:click="changeStatus({{ $ip->user->id }}, '{{ $ip->user->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $ip->user->status == 1 ? 'checked ' : '' }}>
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>


                                        </td>
                                        <td>
                                            @php
                                            $exist=0
                                            @endphp

                                            @foreach($lock as $iplock)

                                            @if($iplock->ip == $ip->ip)
                                            @php
                                            $exist=$exist+1
                                            @endphp
                                            @endif
                                            @endforeach



                                            @if($exist >0)
                                            <button class="btn p-1 btn-outline-danger  p-0 w-100" wire:click="UnBannedIP('{{ $ip->ip }}')">
                                                <i class="material-icons">close</i>
                                                desbloquear
                                            </button>

                                            @else
                                            <button type="submit" class="btn p-1  btn-outline-success p-0  w-100" wire:click="bannedIP('{{ $ip->ip }}')">
                                                <i class="material-icons">add</i>
                                                Bloquear
                                            </button>

                                            @endif





                                        </td>
                                        <td class="td-actions text-center">

                                            <a class="btn btn-success btn-link text-danger " onclick="confirmDeleteIP('{{ $ip->id }}', '{{ $ip->ip }}')">
                                                <i class="material-icons ">close</i>
                                            </a>
                                        </td>





                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $ips->links() }}
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
        function confirmDeleteIP($id, $name) {




            //var respuesta = confirm("Realmente desea eliminar: " + $name)


            swal({
                title: "Realmente desea eliminar la IP: " + $name,
                //type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!",
            }).then((result) => {
                if (result.value) {
                    Livewire.emit('deleteIP', $id);
                } else {
                    Swal.fire('La IP está segura :)', '', 'info')
                }
            });
        }
    </script>
</div>