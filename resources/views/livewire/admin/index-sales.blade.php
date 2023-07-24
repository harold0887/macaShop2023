<div class="content pt-0 px-0">
    @include('includes.spinner-livewire')
    <div class="container-fluid">

        <div class="row">


            <div class="col-12  px-1">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Ventas ({{$orders->total()}} registros).</h4>
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
                                    <input id="input-search" type="search" class="form-control px-3" placeholder="Buscar por orden, email, etc..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                </div>
                            </form>
                        </div>
                        <div class="col-2 col-lg-1 p-0">
                            <button type="submit" class="btn bg-transparent   btn-round btn-just-icon p-0" style="border:solid 1px #c09aed">
                                <i class="material-icons " style="color:#c09aed">search</i>
                            </button>
                        </div>

                        <div class="col-12 col-md-3">
                            <a class="btn btn-primary btn-block" href="{{ route('sales.create') }}">
                                <i class="material-icons">add_circle</i>
                                <span>Nueva venta</span>
                            </a>
                        </div>
                        <div class="col-12">
                            @if ($search != '')
                            <small class="text-primary">{{ $orders->count() }} resultados obtenidos</small>

                            @endif
                        </div>
                        @if (isset($orders) && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr  >
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

                                            Id
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('payment_id')">
                                            @if($sortField=='payment_id')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif

                                            Id MP
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
                                            Fecha
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('amount')">
                                            @if($sortField=='amount')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Cantidad
                                        </th>
                                        <th style="cursor:pointer" wire:click="setSort('payment_type')">
                                            @if($sortField=='payment_type')
                                            @if($sortDirection=='asc')
                                            <i class="fa-solid fa-arrow-down-a-z"></i>
                                            @else
                                            <i class="fa-solid fa-arrow-up-z-a"></i>
                                            @endif
                                            @else
                                            <i class="fa-solid fa-sort mr-1"></i>
                                            @endif
                                            Pago
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
                                            Estatus de pago
                                        </th>
                                        
                                        <th>email</th>
                                        <th>Contacto</th>
                                        
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr class=" {{$order->active==0
                                         ? 'table-danger':''}} ">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->payment_id }}</td>
                                        <td>{{date_format($order->created_at, 'd-M-Y H:i')}}</td>
                                        <td>{{ $order->amount }}</td>
                                        <td>{{ $order->payment_type }}</td>
                                        <td>
                                            @if ($order->status == 'approved')
                                            <a class="text-success">
                                                <i class="material-icons">check_circle</i> Aprobado
                                            </a>
                                            @elseif($order->status == 'pending')
                                            <a class="text-warning">
                                                <i class="material-icons">pending</i> Pendiente
                                            </a>
                                            @elseif($order->status == 'in_process')
                                            <a class="text-warning">
                                                <i class="material-icons">watch_later</i> En proceso
                                            </a>
                                            @elseif($order->status == 'cancel')
                                            <a class="text-danger">
                                                <i class="material-icons">cancel</i>Cancelado
                                            </a>
                                            @elseif($order->status == 'refund')
                                            <a class="text-danger">
                                                <i class="material-icons">settings_backup_restore</i>Reembolso
                                            </a>
                                            @else
                                            <a>
                                                <i class="material-icons">warning</i>{{ $order->status }}
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $order->user->email }}
                                        </td>
                                        <td>
                                            {{ $order->contacto }}
                                        </td>
                                        <td class="td-actions">
                                            <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                                <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}">
                                                    <i class=" material-icons">visibility</i>
                                                </a>
                                                <a class="btn btn-success btn-link " href="{{ route('sales.edit', $order->id) }}">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a class="btn btn-success btn-link text-primary" wire:click="updateStatus({{ $order->payment_id }})">
                                                    <i class=" material-icons">autorenew</i>
                                                </a>
                                                <a class="btn btn-success btn-link text-secondary" wire:click="resendOrder({{ $order->id }})">
                                                    <i class=" material-icons">mail</i>
                                                </a>
                                                <form method="post" action="{{ route('sales.destroy', $order->id) }} ">
                                                    <input type="text" hidden value="{{$order->id}}">
                                                    <button class=" btn btn-danger btn-link btn-icon btn-sm confirm-delete">
                                                        @csrf
                                                        @method('DELETE')
                                                        <i class="material-icons ">close</i>
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            {{ $orders->links() }}
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
@include('includes.alert-error')