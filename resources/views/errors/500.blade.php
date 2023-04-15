@extends('errors.layout', [
'classPage' => 'error-page',
'activePage' => '500',
'pageBackground' => asset("material").'/img/bg-pricing.jpg',
'navbarClass'=>'text-white',
'title'=>'Error 500'
])

@section('content')
<div class="container text-center">
    <div class="row">
        <div class="col-md-12">
        <h1 class="title">500</h1>
        <h2>{{ __('Server Error') }} :(</h2>
        <h4>{{ __('Ooooups! Looks like something went wrong') }}.</h4>
        </div>
        <div class="col-md-12 mt-5">

                <a href="{{ route('home') }}" class="text-white btn btn-rose btn-lg">
                    <i class="material-icons  mr-2 pb-1">home</i>
                    <span>Volver al inicio</span>
                </a>

        </div>
    </div>
</div>
@endsection
