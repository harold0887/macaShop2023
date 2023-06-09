@extends('layouts.app', [
'class' => 'off-canvas-sidebar',
'classPage' => 'login-page',
'activePage' => 'register',
'title' => __('Register'),
'pageBackground' => asset("material").'/img/register.jpg',
'navbarClass'=>'text-white navbar-transparent',
'background'=>'#red !important'
])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-5 ml-auto mr-auto">

            <div class="card card-login card-primary card-hidden mb-3 border border-primary">
                <div class="card-header card-header-primary text-center  justify-center ">

                    <h4 class="card-title "><strong>{{ __('Register') }}</strong></h4>
                </div>

                <div class="card-body ">
                    <div class="row">

                        <div class="col mr-auto">
                            <div class="social text-center">
                                {{-- <button class="btn btn-just-icon btn-round btn-twitter">
                  <i class="fa fa-twitter"></i>
                </button>
                <button class="btn btn-just-icon btn-round btn-dribbble">
                  <i class="fa fa-dribbble"></i>
                </button>
                <button class="btn btn-just-icon btn-round btn-facebook">
                  <i class="fa fa-facebook"> </i>
                </button>
                <h4 class="mt-3"> or be classical </h4> --}}
                            </div>
                            <form class="form" method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="has-default{{ $errors->has('name') ? ' has-danger' : '' }} mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">face</i>
                                            </span>
                                        </div>
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}..." value="{{ old('name') }}" required>

                                    </div>
                                    @if ($errors->has('name'))
                                    <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                                        <strong class="errors-field-name">{{ $errors->first('name') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="has-default{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">mail</i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" name="email" placeholder="{{ __('Email') }}..." value="{{ old('email') }}" required>

                                    </div>
                                    @if ($errors->has('email'))
                                    <div id="email-error" class="error text-danger pl-3" for="name" style="display: block;">
                                        <strong class="errors-field-email">{{ $errors->first('email') }}</strong>
                                    </div>
                                    @endif
                                </div>

                                <div class="has-default{{ $errors->has('password') ? ' has-danger' : '' }} mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" name="password" placeholder="{{ __('Password') }}..." class="form-control" required>

                                    </div>
                                    @if ($errors->has('password'))
                                    <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                        <strong class="errors-field-pass">{{ $errors->first('password') }}</strong>
                                    </div>
                                    @endif
                                </div>
                                <div class="has-default mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}..." required>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label text-xxs">
                                        <input class="form-check-input" type="checkbox" name="policy" value="1" {{ old('policy', 1) ? 'checked' : '' }}>
                                        <span class="form-check-sign">
                                            <span class="check"></span>
                                        </span>
                                        {{ __('I agree to the') }} <a href="{{route('information.terminos')}}">{{ __('terms and conditions') }}</a>
                                    </label>
                                    @if ($errors->has('policy'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('policy') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="text-center mb-3">
                                    <button type="submit" class="btn btn-primary btn-round mt-4 btn-lg">{{ __('Get Started') }}</button>
                                </div>
                                <div class="card-footer justify-content-center  my-0 py-0">
                                    <p class="card-description p-0 my-0">Ya tiene una cuenta? </p>
                                </div>
                                <div class="card-footer justify-content-center  my-0 py-0">
                                    <a href="{{ route('login') }}" class="nav-link  text-primary">
                                        <i class="material-icons">fingerprint</i> INGRESAR
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
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