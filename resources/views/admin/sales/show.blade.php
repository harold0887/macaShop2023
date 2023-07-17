@extends('layouts.app',[
'title'=>'Ventas',
'navbarClass'=>'navbar-transparent',
'activePage'=>'sales',
])
@section('content')

<livewire:show-sales />


@endsection
@include('includes.alert-error')