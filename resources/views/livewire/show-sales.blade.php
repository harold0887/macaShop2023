<div class="content p-0">

    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header card-header-primary card-header-icon ">
                        <div class="card-icon">
                            <i class="material-icons">receipt</i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title font-weight-bold">Resumen de compra - {{$order->id}}
                                    <a class="btn  btn-link  p-0" href="{{ route('sales.edit', $order->id) }}" target="_blank">
                                        <i class="material-icons text-success">edit</i>
                                    </a>
                                </h4>
                                <span class="text-muted">Email: <b>{{ $order->user->email }}</b></span>

                                <br>
                                <span class="text-muted">Fecha: <b>{{ date_format($order->created_at, 'd-M-Y H:i') }}</b></span>
                                <br>
                                <span class="text-muted">Total: <b>{{ $order->amount }} MXN</b></span>
                                <br>
                                <span class="text-muted">Pago: <b>{{ $order->payment_type }}</b></span>
                                <br>
                                <span class="text-muted">Status de pago: <b>


                                        @if($order->status == 'create')
                                        <a class="text-warning">
                                            <i class="material-icons">pending_actions</i>Pendiente de pago.
                                        </a>
                                        @elseif ($order->status == 'approved')
                                        <a class="text-success">
                                            <i class="material-icons">check_circle</i> Aprobado.
                                        </a>
                                        @elseif($order->status == 'pending')
                                        <a class="text-warning">
                                            <i class="material-icons">pending</i> Pendiente de confirmación.
                                        </a>
                                        @elseif($order->status == 'in_process')
                                        <a class="text-warning">
                                            <i class="material-icons">watch_later</i> En proceso.
                                        </a>
                                        @elseif($order->status == 'cancelled')
                                        <a class="text-warning">
                                            <i class="material-icons">cancel</i>Cancelado
                                        </a>
                                        @elseif($order->status == 'rejected')
                                        <a class="text-danger">
                                            <i class="material-icons">cancel</i>Rechazado
                                        </a>
                                        @elseif($order->status == 'refund')
                                        <a class="text-danger">
                                            <i class="material-icons">settings_backup_restore</i>Reembolsado
                                        </a>
                                        @else
                                        <a>
                                            <i class="material-icons">warning</i>{{ $order->status }}
                                        </a>
                                        @endif

                                    </b>
                                </span>
                                <br>
                                <span class="text-muted">Contacto: <b>{{ $order->contacto }}</b></span>
                                <br>
                                <div class="togglebutton">
                                    <label>
                                        <span class="text-muted">Active:
                                            <input disabled type="checkbox" wire:click="activeOrder()" {{ $order->active == 1 ? 'checked ' : '' }}>
                                            <span class="toggle"></span>
                                        </span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body row ">
                        <div class="col-12 col-lg-9 ">
                            <div class="row">
                                <!-- Content -->
                                <div class="rgba-black-strong ">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12">

                                            <!--Accordion wrapper-->
                                            <div class="accordion md-accordion accordion-5 " id="accordionEx5" role="tablist" aria-multiselectable="true">

                                                <!-- Accordion card -->
                                                <div class="card mb-4  mt-0">

                                                    <!-- Card header -->
                                                    <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading30">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse30" aria-expanded="true" aria-controls="collapse30">
                                                            <i class="fa-solid fa-book fa-2x p-3 mr-4 float-left black-text"></i>
                                                            <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                                                Cuadernillos ({{$purchases->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>
                                                    <!-- Card body -->
                                                    <div id="collapse30" class="collapse {{$purchases->count() > 0 ?'show':''}}  " role="tabpanel" aria-labelledby="heading30" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if (isset($purchases) && $purchases->count() > 0)

                                                            @foreach($purchases as $product)


                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($product->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $product->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $product->price }} </b> <br>
                                                                    </p>
                                                                </div>

                                                                <div class="col-12 col-md-2 text-center align-self-center">

                                                                    @if($product->folio == 1 && $product->active == 0 )
                                                                    <small>Este documento requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $product->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>

                                                                    @else

                                                                    @if(Storage::exists('public/'.$product->document))
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click.prevent="download('{{ $product->id }}')">
                                                                            <i class="material-icons">download</i> Descargar
                                                                        </button>
                                                                    </div>
                                                                    <button class="btn btn-outline-primary btn-round w-100" type="button" disabled wire:loading wire:target="resend">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        enviando...
                                                                    </button>

                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>
                                                                    @else

                                                                    <div>
                                                                        <button class="btn btn-link btn-round w-100 btn-danger" disabled>
                                                                            <i class="material-icons">file_download_off</i> Expired
                                                                        </button>
                                                                    </div>
                                                                    @endif



                                                                    @endif




                                                                </div>

                                                                <div class="col-12">
                                                                    @if(isset($enviados) && $enviados->count() > 0)

                                                                    <table class="table table-hover table-responsive ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><b>Email</b></th>
                                                                                <th><b>Fecha de envio</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="h5 ">
                                                                            @foreach($enviados as $enviado)
                                                                            @if ($enviado->product_id== $product->id && $enviado->order_id== $order->id)
                                                                            <tr>
                                                                                <td>{{$enviado->emal}}</td>
                                                                                <td>{{$enviado->created_at}}</td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    @endif
                                                                </div>


                                                            </div>
                                                            <hr style="border: solid 1px red;">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->

                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading31">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse31" aria-expanded="true" aria-controls="collapse31">
                                                            <i class="fas fa-light fa-cubes fa-2x p-3 mr-4 float-left black-text"></i>

                                                            <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                                                Paquetes ({{$packages->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse31" class="collapse {{$packages->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading31" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($packages) && $packages->count() > 0)
                                                            @foreach($packages as $package)
                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($package->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $package->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $package->price }} </b> <br>
                                                                    </p>
                                                                </div>
                                                                <div class="col-12 col-md-2 text-center align-self-center">

                                                                    @if($package->active == 0 )
                                                                    <small>Este paquete requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $package->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click="showPackages('{{ $package->id }}')">
                                                                            ver materiales
                                                                        </button>
                                                                    </div>

                                                                    @else
                                                                    <div wire:loading.remove>
                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click="showPackages('{{ $package->id }}')">
                                                                            ver materiales
                                                                        </button>
                                                                    </div>
                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>

                                                                    @endif





                                                                </div>

                                                            </div>
                                                            {{$package->products1}}
                                                            <hr class="text-muted">

                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->

                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading32">
                                                        <a data-toggle="collapse" data-parent="#accordionEx5" href="#collapse32" aria-expanded="true" aria-controls="collapse32">
                                                            <i class="fas fa-duotone fa-id-card fa-2x p-3 mr-4 float-left black-text"></i>
                                                            <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                                                Membresías ({{$memberships->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse32" class="collapse {{$memberships->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx5">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($memberships) && $memberships->count() > 0)
                                                            @foreach($memberships as $membership)


                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($membership->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $membership->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $membership->price }} </b> <br>
                                                                    </p>

                                                                </div>
                                                                <div class="col-12 col-md-2 text-center align-self-center">
                                                                    @if($membership->active == 0 )
                                                                    <small>Esta membresía requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $membership->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>


                                                                    @else


                                                                    @endif

                                                                </div>

                                                            </div>
                                                            <hr class="text-muted">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->
                                                <!-- Accordion card -->
                                                <div class="card mb-4">

                                                    <!-- Card header -->
                                                    <div class="card-header p-0 z-depth-1 shadow" role="tab" id="heading32">
                                                        <a data-toggle="collapse" data-parent="#accordionEx6" href="#collapse33" aria-expanded="true" aria-controls="collapse33">
                                                            <i class="fas fa-duotone fa-list fa-2x p-3 mr-4 float-left black-text"></i>
                                                            <h4 class="text-uppercase white-text mb-0 py-3 mt-1 ">
                                                                Productos del paquete ({{$productsPackagesOrder->count()}})
                                                            </h4>
                                                        </a>
                                                    </div>

                                                    <!-- Card body -->
                                                    <div id="collapse33" class="collapse {{$productsPackagesOrder->count() > 0 ?'show':''}}" role="tabpanel" aria-labelledby="heading32" data-parent="#accordionEx6">
                                                        <div class="card-body rgba-black-light white-text z-depth-1">
                                                            @if(isset($productsPackagesOrder) && $productsPackagesOrder->count() > 0)
                                                            @foreach($productsPackagesOrder as $product)
                                                            <div class="row pt-2">
                                                                <div class="col-md-2 my-1">
                                                                    <img src="{{ Storage::url($product->itemMain) }} " class="img-thumbnail w-75">
                                                                </div>
                                                                <div class="col-12 col-md-6 align-self-center">
                                                                    <p>
                                                                        <b style="font-size: 1.2em">{{ $product->title }}</b>
                                                                        <br>
                                                                        <b class="text-muted">Precio: ${{ $product->price }} </b> <br>
                                                                        @if($product->status==0)
                                                                        <b class="text-danger">Product disabled </b> <br>
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="col-12 col-md-2 text-center align-self-center">

                                                                    @if($product->folio == 1 && $order->active == 0 )
                                                                    <small>Este documento requiere activación.</small>
                                                                    <br><br>

                                                                    <a href="https://api.whatsapp.com/send?phone=+9981838908&text=Quiero%20activar%20mi%20orden%20de%20compra%20web: {{ $product->order_id }}" target="_blank">
                                                                        <img src="{{ asset('img/whatsapp1.png') }}" alt="logo WhatsApp" width="60">
                                                                    </a>

                                                                    @else
                                                                    <div wire:loading.remove>

                                                                        <button class="btn btn-outline-info btn-round w-100" wire:click.prevent="download('{{ $product->id }}')">
                                                                            <i class="material-icons">download</i> Descargar
                                                                        </button>
                                                                    </div>
                                                                    <button class="btn btn-outline-info btn-round w-100" type="button" disabled wire:loading wire:target="download">
                                                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                                        Descargando...
                                                                    </button>
                                                                    @endif




                                                                </div>
                                                                <div class="col-12">
                                                                    @if(isset($enviados) && $enviados->count() > 0)

                                                                    <table class="table table-hover table-responsive ">
                                                                        <thead>
                                                                            <tr>
                                                                                <th><b>Email</b></th>
                                                                                <th><b>Fecha de envio</b></th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="h5 ">
                                                                            @foreach($enviados as $enviado)
                                                                            @if ($enviado->product_id== $product->id )
                                                                            <tr>
                                                                                <td>{{$enviado->emal}}</td>
                                                                                <td>{{$enviado->created_at}}</td>
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    @endif
                                                                </div>


                                                            </div>
                                                            <hr style="border: solid 1px red;">
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion card -->
                                            </div>
                                            <!--/.Accordion wrapper-->

                                        </div>
                                    </div>
                                </div>
                                <!-- Content -->

                            </div>


                        </div>





                    </div>
                </div>
            </div>

        </div>

    </div>



</div>