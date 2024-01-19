<div class="content">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">receipt</i>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <h4 class="card-title font-weight-bold">Registro de Ventas</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body row">
                            <div class="col-12">
                                <div class="row justify-content-between">
                                    <div class="col-12 col-md-8   align-self-md-center">
                                        <div class="input-group rounded ">
                                            <input id="input-search" type="search" class="form-control px-3" placeholder="Buscar por orden, email, etc..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                            @if ($search != '')
                                            <span class="input-group-text" style="cursor:pointer" wire:click="clearSearch()"><i class="material-icons mx-0 text-lg text-danger">close</i></span>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>


                            @if ($search != '')
                            <div class="col-12">
                                <small class="text-primary">{{ $orders->count() }} resultados obtenidos</small>
                            </div>
                            @if (isset($orders) && $orders->count() > 0)
                            <div class="table-responsive ">
                                <table class="table table-striped text-xs">
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
                                                <div class="d-flex">
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
                                                </div>

                                            </th>
                                            <th style="cursor:pointer" wire:click="setSort('amount')">
                                                <div class="d-flex">
                                                    @if($sortField=='amount')
                                                    @if($sortDirection=='asc')
                                                    <i class="fa-solid fa-arrow-down-a-z"></i>
                                                    @else
                                                    <i class="fa-solid fa-arrow-up-z-a"></i>
                                                    @endif
                                                    @else
                                                    <i class="fa-solid fa-sort mr-1"></i>
                                                    @endif
                                                    <span>Cantidad</span>
                                                </div>

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
                                                <div class="d-inline-flex p-0">
                                                    @if($sortField=='status')
                                                    @if($sortDirection=='asc')
                                                    <i class="fa-solid fa-arrow-down-a-z"></i>
                                                    @else
                                                    <i class="fa-solid fa-arrow-up-z-a"></i>
                                                    @endif
                                                    @else
                                                    <i class="fa-solid fa-sort mr-1"></i>
                                                    @endif
                                                    <span>Status</span>
                                                </div>

                                            </th>
                                            <th>
                                                Membresía
                                            </th>
                                            <th>email</th>
                                            <th>WhatsApp</th>
                                            <th>Facebook</th>
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
                                                @if($order->status == 'create')
                                                <a class="text-warning">
                                                    <i class="material-icons">pending_actions</i>Pendiente de pago
                                                </a>
                                                @elseif ($order->status == 'approved')
                                                <a class="text-success">
                                                    <i class="material-icons">check_circle</i>Aprobado
                                                </a>
                                                @elseif($order->status == 'pending')
                                                <a class="text-warning">
                                                    <i class="material-icons">pending</i>Deposito pendiente
                                                </a>
                                                @elseif($order->status == 'in_process')
                                                <a class="text-warning">
                                                    <i class="material-icons">watch_later</i>En proceso.
                                                </a>
                                                @elseif($order->status == 'cancelled')
                                                <a class="text-danger">
                                                    <i class="material-icons">cancel_presentation</i>Cancelado

                                                </a>
                                                @elseif($order->status == 'rejected')
                                                <a class="text-danger">
                                                    <i class="material-icons">cancel</i>Rechazado
                                                </a>
                                                @elseif($order->status == 'refunded')
                                                <a class="text-danger">
                                                    <i class="material-icons">settings_backup_restore</i>Reembolsado
                                                </a>
                                                @else
                                                <a class="text-danger">
                                                    <i class="material-icons">warning</i>
                                                </a>
                                                @endif
                                            </td>
                                            <td>

                                                @foreach($order->memberships as $membresia)
                                                <span class="badge badge-info d-block my-1">
                                                    {{ $membresia->title }}

                                                </span>
                                                @endforeach

                                            </td>
                                            <td>
                                                {{ $order->user->email }}
                                            </td>

                                            <td>
                                                {{ $order->user->whatsapp }}
                                            </td>
                                            <td>
                                                {{ $order->user->facebook }}
                                            </td>
                                            <td class="td-actions">
                                                <div class="btn-group m-0 d-flex" style="box-shadow: none !important">
                                                    <a class="btn btn-info btn-link" href="{{ route('sales.show', $order->id) }}">
                                                        <i class=" material-icons">visibility</i>
                                                    </a>
                                                    <a class="btn btn-success btn-link " href="{{ route('sales.edit', $order->id) }}">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <!-- <a class="btn btn-success btn-link text-primary" wire:click="updateStatus({{ $order->payment_id }})">
                                                    <i class=" material-icons">autorenew</i>
                                                </a>
                                                <a class="btn btn-success btn-link text-secondary" wire:click="resendOrder({{ $order->id }})">
                                                    <i class=" material-icons">mail</i>
                                                </a> -->
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">

                                        <i class="material-icons">equalizer</i>
                                    </div>
                                    <p class="card-category">Ventas del día</p>
                                    <h3 class="card-title"> ${{ number_format($salesDay,2) }} </h3>
                                </div>
                                <div class="card-footer p-0">
                                    <div class="stats">
                                        <input class="form-control" type="text" value="" placeholder="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">timeline</i>
                                    </div>
                                    <p class="card-category">Ventas del mes de {{$monthSelectName}} {{$yearSelect}}</p>
                                    <h3 class="card-title">${{ number_format($salesMonth,2) }} </h3>
                                </div>
                                <div class="card-footer p-0">
                                    <div class="stats ">
                                        <select class="form-control text-muted" wire:model="monthSelect">
                                            <option selected value="">Selecciona el mes...</option>
                                            <option value="01">Enero</option>
                                            <option value="02">Febrero</option>
                                            <option value="03">Marzo</option>
                                            <option value="04">April</option>
                                            <option value="05">Mayo</option>
                                            <option value="06">Junio</option>
                                            <option value="07">Julio</option>
                                            <option value="08">Agosto</option>
                                            <option value="09">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                        @if( $monthSelect != now()->format('m') )
                                        <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:change="$set('monthSelect', '{{now()->format('m')}}')">close</i>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">calendar_month</i>
                                    </div>
                                    <p class="card-category">Ventas del año</p>
                                    <h3 class="card-title">${{ number_format($salesYear,2) }} </h3>
                                </div>
                                <div class="card-footer p-0">
                                    <div class="stats">
                                        <select class="form-control" name="fop" wire:model="yearSelect">
                                            <option selected value="">Selecciona el año...</option>
                                            @for ($i = 2020; $i < 2030; $i++) <option value="{{$i}}"> {{$i}} </option>
                                                @endfor
                                        </select>

                                        @if( $yearSelect != now()->format('Y') )
                                        <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="$set('yearSelect', '{{now()->format('Y')}}')">close</i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">date_range</i>
                                    </div>
                                    <p class="card-category">Ventas por rango</p>
                                    <h3 class="card-title">${{ number_format($salesRange,2) }} </h3>
                                </div>
                                <div class="card-footer p-0">
                                    <div class="stats">
                                        <input class="form-control" type="text" name="datefilter" value="" placeholder="Seleccione rango..." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card ">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons"></i>
                                    </div>
                                    <h4 class="card-title">Detalle de ventas por día</h4>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive table-sales">
                                                <table class="table">
                                                    <thead>
                                                        <tr>

                                                            <th class="font-weight-bold">
                                                                Titulo
                                                            </th>
                                                            <th class="font-weight-bold">
                                                                Ventas
                                                            </th>
                                                            <th class="font-weight-bold">
                                                                Suma
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        @foreach($productsDay as $product)
                                                        <tr>

                                                            <td>
                                                                {{$product->title}}
                                                            </td>
                                                            <td>
                                                                {{$product->sales_count}}
                                                            </td>
                                                            <td class="text-end">
                                                                {{ number_format( $product->sales_sum_price,2)}}
                                                            </td>
                                                        </tr>

                                                        @endforeach

                                                        <tr class="font-weight-bold table-success">
                                                            <td>Suma de ventas de productos</td>
                                                            <td></td>
                                                            <td class="text-end font-weight-bold">{{ number_format( $sum_day_products,2)}} </td>
                                                        </tr>



                                                    </tbody>
                                                </table>
                                            </div>




                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card ">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">trending_up</i>
                                    </div>
                                    <h4 class="card-title">Global Sales Top 10 web</h4>
                                </div>
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive table-sales">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="font-weight-bold">
                                                                Imagen
                                                            </th>
                                                            <th class="font-weight-bold">
                                                                Titulo
                                                            </th>
                                                            <th class="font-weight-bold">
                                                                Ventas
                                                            </th>
                                                            <th class="font-weight-bold">
                                                                Suma ventas
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if( isset($topProducts) && $topProducts != null )

                                                        @foreach($topProducts as $product)
                                                        <tr>
                                                            <td class=" py-1">

                                                                <img src="{{ Storage::url($product->itemMain) }} " width="60">

                                                            </td>
                                                            <td>
                                                                {{$product->title}}
                                                            </td>
                                                            <td>
                                                                {{$product->sales_count}}
                                                            </td>
                                                            <td>
                                                                {{ number_format( $product->sales_sum_price,2)}}
                                                            </td>
                                                        </tr>

                                                        @endforeach

                                                        @endif



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>




            </div>
        </div>
    </div>
</div>