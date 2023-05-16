<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">

            @include('includes.spinner-livewire')
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h4 class="card-title font-weight-bold">Usuarios ({{$users->total()}} registros).</h4>
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
                            <small class="text-primary">{{ $users->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($users) && $users->count() > 0)
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
                                        <th style="cursor:pointer" wire:click="setSort('email')">

                                            @if($sortField=='email')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Correo electronico
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('created_at')">
                                            @if($sortField=='created_at')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Miembro desde
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('role')">
                                            Rol
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('status')">Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr class=" {{ $user->status == 0 ? 'table-danger ' : '' }}">
                                    <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{date_format($user->created_at, 'd-M-Y')}}</td>
                                        <td>

                                            @foreach($user->roles as $role)
                                            @if($role->name =="admin")
                                            <span class="badge badge-info  my-1">
                                                {{ $role->name }}
                                            </span>
                                           
                                            @endif
                                            @endforeach


                                        </td>
                                        <td>
                                            <div class="togglebutton" wire:click="changeStatus({{ $user->id }}, '{{ $user->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $user->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>



                                        </td>
                                        <td class="td-actions">
                                            @if ($user->id != Auth::user()->id && $user->role != 'super-admin')
                                            <a class="btn btn-success btn-link" href="{{ route('users.edit', $user->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $users->links() }}
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
</div>