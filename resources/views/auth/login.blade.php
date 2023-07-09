@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'login',
'title' => __('Login'),
'pageBackground' => asset("material").'/img/markus-spiske-187777.jpg',
'navbarClass'=>'text-white navbar-transparent',
'background'=>''
])

@section('content')
<div class="container">

    <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="card card-login card-primary card-hidden mb-3 border border-primary">
                    <div class="card-header card-header-primary text-center flex justify-center items-center">
                        <i class="material-icons px-2 my-0 py-0">fingerprint</i>
                        <h4 class="card-title my-0 px-0"><strong>Ingresa con tu cuenta</strong></h4>
                    </div>

                    <div class="card-body">
                        <span class="form-group  bmd-form-group email-error {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">email</i>
                                    </span>
                                </div>
                                <input type="email" class="form-control err-email" id="exampleEmails" name="email" placeholder="{{ __('Email...') }}" value="{{ old('email', '') }}" required>
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </span>
                        <span class="form-group bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="material-icons">lock_outline</i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" id="examplePassword" name="password" placeholder="{{ __('Password...') }}" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </span>
                        <div class="form-check mr-auto ml-3 mt-3">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : 'checked' }}> {{ __('Remember me') }}
                                <span class="form-check-sign">
                                    <span class="check"></span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" class="btn btn-primary   btn-lg">
                            INGRESAR
                        </button>
                    </div>
                    <div class="card-footer justify-content-center my-0 py-0">
                        <p class="card-description p-0 my-0">No tiene cuenta todavia? </p>
                    </div>
                    <div class="card-footer justify-content-center my-0 py-0">
                        <a href="{{ route('register') }}" class="nav-link  text-primary">
                            <i class="material-icons">person_add</i> REGISTRATE
                        </a>
                    </div>


                </div>

            </form>
            <div class="row">
                <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-light">
                        <small>{{ __('Forgot password') }} ?</small>
                    </a>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        md.checkFullPageBackgroundImage();
        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700);
    });
</script>
@endpush