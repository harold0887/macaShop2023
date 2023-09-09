<div class="content pt-0">
    @include('includes.spinner-livewire')
    <div class="container-fluid">

        <div class="row ">


            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 px-0">
                                <h4 class="card-title font-weight-bold">Editar orden {{ $order->id }} - {{ number_format($order->amount,2) }} MXN.</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="col-12 col-md-6">
                            <h4 class="title h3 text-center">Total de la orden: {{ number_format($suma,2) }} MXN</h4>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 col-md-9">
                                    <div class="form-row ">
                                        <div class="form-group col-12 ">
                                            <label class="bmd-label-floating">Contacto</label>
                                            <input type="text" class="form-control" wire:model="contacto">
                                        </div>
                                        <div class="form-group col-12 ">
                                            <label class="bmd-label-floating">Id Mercado Pago</label>
                                            <input type="text" class="form-control" wire:model="mercadoPago">
                                        </div>


                                        <div class="form-group col-12 ">
                                            <select class="form-control" name="fop" wire:model="status">
                                                <option value="">Selecciona un estatus...</option>
                                                <option value="approved">approved</option>
                                                <option value="pending">pending</option>
                                                <option value="in_process">in_process</option>
                                                <option value="cancel">cancel</option>
                                                <option value="refunded">refund</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-12 ">
                                            <div class="togglebutton">
                                                <label>
                                                    <span class="text-muted">WhatsApp:
                                                        <input type="checkbox" wire:click="activeOrder()" {{ $order->active == 1 ? 'checked ' : '' }}>
                                                        <span class="toggle"></span>
                                                    </span>
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto  d-flex">
                                    <button class="btn btn-info btn-link text-success" wire:click='save'>
                                        <i class=" material-icons ">save</i>
                                    </button>
                                </div>
                            </div>
                        </div>



                        <div class="form-row">
                            <div class="col-12 col-md-6 rounded shadow pl-4 border">
                                <div class="col">
                                    <h4 class="title h3 text-center">Agregar membresías a la orden </h4>
                                </div>
                                @foreach($memberships as $membership)
                                <div class="row pt-2">
                                    <div class="col-6 align-self-center">
                                        <p>
                                            <b style="font-size: 1.2em">{{ $membership->title }}</b>
                                            <br>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12 col-md-6 text-center ">
                                                <button class="btn p-1  btn-success p-0" wire:click="addMembership('{{ $membership->id }}')">
                                                    <i class="material-icons">add</i>
                                                    Agergar
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-6 text-center ">
                                                @foreach($MembershipsIcluded as $item)
                                                @if($item->id == $membership->id )
                                                <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeMembership('{{ $membership->id }}')">
                                                    <i class="material-icons">close</i>
                                                    Remover
                                                </button>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @endforeach
                                <hr class="bg-danger my-4">
                                <div class="row">

                                    <div class="col-12">
                                        <h4 class="title h3 text-center">Agregar documentos a la orden </h4>
                                    </div>

                                    <div class="col-8">
                                        <input type="search" class="form-control px-3 w-full" placeholder="Buscar título..." wire:model.debounce.500ms='search' style="border-radius: 30px !important">
                                    </div>
                                    <div class="col-4 text-end">
                                        @if ($search != '')
                                        <div class="d-flex mt-2">
                                            <span class="text-base">Borrar filtros </span>
                                            <i class="material-icons my-auto ml-2 text-base text-danger" style="cursor:pointer" wire:click="clearSearch()">close</i>
                                        </div>
                                        @endif
                                    </div>

                                </div>

                                @foreach($products as $products)
                                <div class="row pt-2">
                                    <div class="col-6 align-self-center {{$products->status==0? 'text-danger':''}}
                                    ">
                                        <p>
                                            <b style="font-size: 1.2em  ">{{ $products->title }}</b>
                                            <br>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12 col-md-6 text-center ">
                                                <button class="btn p-1  btn-success p-0" wire:click="addProduct('{{ $products->id }}')">
                                                    <i class="material-icons">add</i>
                                                    Agregar
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-6 text-center ">
                                                @foreach($productsIncluded as $item)
                                                @if($item->id == $products->id )
                                                <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removeProduct('{{ $products->id }}')">
                                                    <i class="material-icons">close</i>
                                                    Remover
                                                </button>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                @endforeach

                                <hr class="bg-danger my-4">
                                <div class="col">
                                    <h4 class="title h3 text-center">Agregar paquetes a la orden </h4>
                                </div>
                                @foreach($packages as $package)
                                <div class="row pt-2">
                                    <div class="col-6 align-self-center">
                                        <p>
                                            <b style="font-size: 1.2em">{{ $package->title }}</b>
                                            <br>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="col-12 col-md-6 text-center ">
                                                <button class="btn p-1  btn-success p-0" wire:click="addPackage('{{ $package->id }}')">
                                                    <i class="material-icons">add</i>
                                                    Agergar
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-6 text-center ">
                                                @foreach($PackagesIcluded as $item)
                                                @if($item->id == $package->id )
                                                <button type="submit" class="btn p-1  btn-danger p-0" wire:click="removePackage('{{ $package->id }}')">
                                                    <i class="material-icons">close</i>
                                                    Remover
                                                </button>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @endforeach




                            </div>
                            <div class="col-md-6 shadow rounded border">


                                <div class="col-12">
                                    <h4 class="title h3 text-center">Documentos incluidos</h4>
                                </div>
                                @foreach($productsIncluded as $item)
                                <div class="row pt-2">
                                    <div class="col-md-3 my-1">
                                        <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
                                    </div>
                                    <div class="col-12 col-md-9 align-self-center">
                                        <p>
                                            <b style="font-size: 1.2em">{{ $item->price }} - {{ $item->title }}</b>
                                            <br>
                                        </p>
                                    </div>

                                </div>
                                @endforeach
                                <hr class="bg-danger my-4">
                                <div class="col-12">
                                    <h4 class="title h3 text-center">Paquetes incluidos</h4>
                                </div>
                                @foreach($PackagesIcluded as $item)
                                <div class="row pt-2">
                                    <div class="col-md-3 my-1">
                                        <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
                                    </div>
                                    <div class="col-12 col-md-9 align-self-center">
                                        <p>
                                            <b style="font-size: 1.2em">{{ $item->price }} - {{ $item->title }}</b>
                                            <br>
                                        </p>
                                    </div>

                                </div>
                                @endforeach
                                <hr class="bg-danger my-4">
                                <div class="col-12">
                                    <h4 class="title h3 text-center">Membresías incluidas</h4>
                                </div>
                                @foreach($MembershipsIcluded as $item)
                                <div class="row pt-2">
                                    <div class="col-md-3 my-1">
                                        <img src="{{ Storage::url($item->itemMain) }} " class="img-thumbnail">
                                    </div>
                                    <div class="col-12 col-md-9 align-self-center">
                                        <p>
                                            <b style="font-size: 1.2em">{{ $item->price }} - {{ $item->title }}</b>
                                            <br>
                                        </p>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>