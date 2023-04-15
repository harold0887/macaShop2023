@extends('layouts.app',[
'title'=>'Grados',
'navbarClass'=>'navbar-transparent',
'activePage'=>'grados',
])
@section('content')
<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">grain</i>
                        </div>
                        <h4 class="card-title font-weight-bold">Grados ({{$degrees->total()}} registros).</h4>
                    </div>
                    <div class="card-body row justify-content-end">
                        <div class="col-3 ">
                            <a class="btn btn-primary btn-block" href="{{ route('degrees.create') }}">
                                <i class="material-icons">add_circle</i>
                                <span>Nuevo grado</span>
                            </a>
                        </div>
                        @if (isset($degrees) && $degrees->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>Grado</th>
                                        <th>Productos</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($degrees as $grade)
                                    <tr>
                                        <td>{{ $grade->name }}</td>
                                        <td>{{ $grade->products->count() }}</td>
                                        <td class="td-actions ">
                                            <a class="btn btn-success btn-link" href="{{ route('degrees.edit', $grade->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form method="post" action=" {{ route('degrees.destroy', $grade->id) }} " style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" rel="tooltip" class="btn btn-danger btn-link" data-original-title="" title="">
                                                    <i class="material-icons">close</i>
                                                </button>
                                            </form>
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


</div>



@endsection
@include('includes.alert-error')