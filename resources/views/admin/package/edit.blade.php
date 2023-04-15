@extends('layouts.app',[
'title'=>'Paquetes',
'navbarClass'=>'navbar-transparent',
'activePage'=>'package',
])
@section('content')
<div class="content pt-0">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">library_add</i>
                        </div>
                        <h4 class="card-title">Editar {{ $package->title }}</h4>
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('package.update',$package->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="title">Titulo</label>
                                    <input type="text" class="form-control" name="title" value=" {{old('title')?:$package->title}} ">
                                    @error('title')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="title">Precio</label>
                                    <input type="text" class="form-control" name="price" value="{{old('price')?:$package->price}}">
                                    @error('price')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>

                            </div>

                            <div class=" row">
                                <div class="col-12 col-md-6 col-lg-3 text-center">
                                    <h4 class="title">Imagen principal</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="height:300px !important">
                                            @if ($package->itemMain)
                                            <img src="{{ Storage::url($package->itemMain)  }}" alt="...">
                                            @else
                                            <img src="{{ asset('material') }}/img/image_placeholder.jpg" alt="...">
                                            @endif

                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-round btn-file">
                                                <span class="fileinput-new">Selecciona una nueva portada</span>
                                                <span class="fileinput-exists">Cambiar</span>
                                                <input type="file" name="itemMain" accept="image/*" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                        </div>
                                    </div>
                                    <div>
                                        @error('itemMain')
                                        <small class=" text-danger"> {{ $message }} </small>
                                        @enderror
                                    </div>

                                </div>

                                <hr>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary"><i class="material-icons">autorenew</i>
                                        Actualizar</button>
                                </div>
                            </div>
                        </form>

                        

                    </div>
                    <div class="card-body ">
                    <livewire:admin.edit-packages />

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@include('includes.alert-error')