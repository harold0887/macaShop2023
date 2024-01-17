<div class="content pt-0">
    @include('includes.spinner')
    @include('includes.alert-error')
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
                                <h4 class="card-title font-weight-bold">Usuarios ({{$users->total()}} registros)</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12">
                            <div class="row justify-content-between">
                                <div class="col-12 col-md-8   align-self-md-center">
                                    <div class="input-group rounded ">
                                        <input id="input-search" type="search" class="form-control px-3" placeholder=" Buscar por titulo..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                        @if ($search != '')
                                        <span class="input-group-text" style="cursor:pointer" wire:click="clearSearch()"><i class="material-icons mx-0 text-lg text-danger">close</i></span>
                                        @endif
                                    </div>
                                </div>


                            </div>
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
                                            Registro
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('whatsapp')">
                                            @if($sortField=='whatsapp')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            WhatsApp
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('facebook')">
                                            @if($sortField=='facebook')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Facebook
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('sales_count')">
                                            @if($sortField=='sales_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Ventas
                                        </th>
                                        <th style="cursor:pointer">
                                            Membresías
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('roles_count')">
                                            @if($sortField=='roles_count')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Rol
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('ips_count')">
                                            @if($sortField=='ips_count')
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
                                    @foreach ($users as $user)
                                    <tr class=" {{ $user->status == 0 ? 'table-danger ' : '' }}">
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{date_format($user->created_at, 'd-M-Y')}}</td>
                                        <td>{{$user->whatsapp}}</td>
                                        <td>{{$user->facebook}}</td>
                                        <td>
                                            {{$user->sales_count}}
                                        </td>
                                        <td>
                                            @foreach($user->orders as $order)
                                            @if($order->status=='approved')
                                            @foreach($order->memberships as $memberships)
                                            <span class="badge badge-info d-block my-1">
                                                {{$memberships->title}}
                                            </span>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($user->roles as $role)
                                            @if($role->name =="admin")
                                            <span class="badge badge-info  my-1">
                                                {{ $role->name }}
                                            </span>
                                            @endif
                                            @endforeach


                                        </td>
                                        <td>{{$user->ips->count()}}</td>


                                        <td>

                                            <div class="togglebutton" wire:change="changeStatus({{ $user->id }}, '{{ $user->status }}')">
                                                <label>
                                                    <input type="checkbox" {{ $user->status == 1 ? 'checked ' : '' }} name="status">
                                                    <span class="toggle"></span>
                                                </label>
                                            </div>



                                        </td>
                                        <td class="td-actions">
                                            <div class="btn-group shadow-none">
                                                @if ($user->id != Auth::user()->id && $user->role != 'super-admin')
                                                <a class="btn btn-success btn-link" href="{{ route('users.edit', $user->id) }}">
                                                    <i class="material-icons">edit</i>
                                                </a>

                                                <form id="create-sales-admin" method="POST" action="{{ route('orderp.create',$user->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info btn-link mx-2">
                                                        <i class="material-icons">add</i>
                                                    </button>
                                                </form>
                                                <a class="btn btn-success btn-link text-danger " onclick="confirmDeleteUser('{{ $user->id }}', '{{ $user->email }}')">
                                                    <i class="material-icons ">close</i>
                                                </a>

                                                @endif
                                            </div>

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
            <script>
                //Confirmar eliminar producto
                function confirmDeleteUser($id, $name) {




                    //var respuesta = confirm("Realmente desea eliminar: " + $name)


                    swal({
                        title: "Realmente desea eliminar a: " + $name,
                        //type: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, eliminar!",
                    }).then((result) => {
                        if (result.value) {
                            Livewire.emit('deleteUser', $id);

                        } else {
                            Swal.fire('El usuario está seguro :)', '', 'info')
                        }
                    });


                    // if (respuesta == true) {
                    //     Livewire.emit('delete', $id);
                    // } else {

                    //     swal("¡Buen trabajo!", "Tu archivo está seguro :)", "cancel");
                    // }
                }
            </script>


            @push('js')

            <script>
                $(function() {
                    //activar modal al enviar, se cierra al retornar controlador
                    $(
                        "#create-sales-admin"
                    ).submit(() => {
                        $("#modal-spinner").modal("show");
                    });
                });
            </script>
            @endpush

        </div>
    </div>
</div>