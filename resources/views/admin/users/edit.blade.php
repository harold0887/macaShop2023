@extends('layouts.app',[
'title'=>'Usuarios',
'navbarClass'=>'navbar-transparent',
'activePage'=>'users',
])
@section('content')

<div class="content pt-0">

    <div class="container-fluid">

        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">people</i>
                        </div>
                        <h4 class="card-title">Editar - {{ $user->name }}
                            <h4>

                    </div>
                    <div class="card-body ">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="name">Nombre de usuario</label>
                                    <input type="text" class="form-control" name="name" required value="{{ $user->name }}" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-12 col-md-4">
                                    <select name="roles[]" class="selectpicker form-control" data-size="7" data-style="select-with-transition " multiple title="Roles...">

                                        @if (isset($roles) && $roles->count() > 0)
                                        @foreach ($roles as $role)

                                        <option value=" {{ $role->id }}" 
                                        @foreach($user->roles as $rolUser)
                                            @if($rolUser->id == $role->id)
                                            selected
                                            @endif
                                            @endforeach
                                            {{ (collect(old('roles'))->contains($role->id)) ? 'selected':'' }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    @error('roles')
                                    <small class="text-danger"> {{ $message }} </small>
                                    @enderror
                                </div>
                               

                            </div>
                         

                            <div class="col-sm-10  mt-5">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <button type="reset" class="btn">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@include('includes.alert-error')