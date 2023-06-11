<div class="modal fade" id="loginModal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" id="btn-login-close"></button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" action="{{ route('login') }}" id="loginForm1">
                    @csrf
                    <div class="card card-login card-primary card-hidden mb-3">
                        <div class="card-header card-header-primary text-center flex justify-center items-center">
                            <i class="material-icons px-2">fingerprint</i>
                            <h4 class="card-title pt-2 "><strong>Ingresa con tu cuenta</strong></h4>
                        </div>

                        <div class="card-body pt-5">

                            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">email</i>
                                        </span>
                                    </div>
                                    <input id="login-email" type="email" placeholder="Email..." name="email" class="form-control" required>
                                </div>
                                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                    <strong></strong>
                                </div>
                            </div>
                            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="material-icons">lock_outline</i>
                                        </span>
                                    </div>
                                    <input id="login-password" type="password" placeholder="Contraseña..." name="password" class="form-control">
                                </div>
                                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                    <strong></strong>
                                </div>
                            </div>
                            <div class="form-check mr-auto ml-3 mt-3 ">
                                <label class="form-check-label">
                                    <input id="login-remember" class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    Recordarme en este equipo
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="card-footer justify-content-center">
                            <button type="submit" class="btn btn-primary  btn-lg" id="btn-login-modal">
                                INGRESAR
                            </button>
                        </div>
                        <div class="card-footer justify-content-center">
                            <p class="card-description ">No tienes cuenta todavia? </p>
                        </div>
                        <div class="card-footer justify-content-center">
                        <a href="{{ route('register') }}" class="nav-link  text-primary">
                            <i class="material-icons">person_add</i> REGISTRATE
                        </a>
                    </div>


                    </div>
                </form>
                <div class="row">
                    <div class="col-12">

                        <a href="{{ route('password.request') }}" class="text-muted">
                            <p>Olvidé mi contraseña</p>

                        </a>

                    </div>
                    <div class="col-6 text-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>