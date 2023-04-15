<nav id="{{$navbarClass}}" class="navbar fixed-top navbar-expand-lg {{$navbarClass}} navbar-transparent " style="{{Request::route()->getName() !='login'? 'background-color: #eee !important': '' }} ">

  <!--    -->
  <!-- navbar fixed-top navbar-expand-lg    {{$navbarClass}} shadow -->
  <div class="container-fluid">
    <div class="navbar-wrapper ">
      <a class="navbar-brand {{ $navbarClass }}" style="padding: 0px !important">


        @if(Request::route()->getName() =='home')
        <img class="d-none d-lg-block " src=" {{ asset('./img/logo2.png') }} " alt="" width="100">
        @else
        <img src=" {{ asset('./img/logo2.png') }} " alt="" width="100">
        @endif
      </a>
    </div>


    <button class="navbar-toggler " type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only ">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar "></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">

      <ul class="navbar-nav">
        <li class="nav-item{{ $activePage == 'home' ? ' active' : '' }}">
          <a href="{{ route('home') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">home</i>Inicio
          </a>
        </li>

        <li class="nav-item{{ $activePage == 'shop' ? ' active' : '' }}">
          <a href="{{ route('shop.index') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">shopping_bag</i>
            Tienda
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'membership' ? ' active' : '' }}">
          <a href="{{ route('membership') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">card_membership</i>
            Membresia vip
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'free' ? ' active' : '' }}">
          <a href="{{ route('free') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">crop_free</i>
            Material gratuito
          </a>
        </li>

        @guest
        <li class="nav-item{{ $activePage == 'register' ? ' active' : '' }}">
          <a href="{{ route('register') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">person_add</i> {{ __('Register') }}
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'login' ? ' active' : '' }}">
          <a href="{{ route('login') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">fingerprint</i> {{ __('Login') }}
          </a>
        </li>
        @endguest




        @role('admin')
        <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
          <a href="{{ route('dashboard') }}" class="nav-link text-primary">
            <i class="material-icons">dashboard</i> dashboard
          </a>
        </li>
        @endrole
        <li class="nav-item{{ $activePage == 'cart' ? ' active' : '' }}">
          <a href="{{ route('free') }}" class="nav-link {{ $navbarClass }}">
            <i class="material-icons">shopping_cart</i>
            <span class="badge rounded-pill badge-notification" style="position: absolute; top:0; left:25px">
              <livewire:cart-count />
            </span>
          </a>
        </li>


        @auth
        <li class="nav-item dropdown">
          <a class="nav-link text-primary dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">logout</i>
            @php
            $name = explode(" ", Auth::user()->name);
            echo $name[0];
            @endphp
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="background:#e9e9e8;">

            <a class="dropdown-item" href="{{route('profile.edit')}}">{{ __('My Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault();
                                      this.closest('form').submit();">Salir</a>
            </form>
          </div>
        </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>