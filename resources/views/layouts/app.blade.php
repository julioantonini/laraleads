<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <link href="{{ asset('build/app.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('build/vendor.min.css') }}" rel="stylesheet">

  @if (app()->environment() === 'production')
    <link href="{{ URL::asset('build/style.min.css') }}" rel="stylesheet">
  @else
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
  @endif

</head>

<body>

  <div class="app-container">
    <aside class="app-sidebar">
      <button type="button" class="btn btn-primary app-sidebar__toggle-button"><i class="fas fa-bars"></i></button>
      <div id="app-sidebar__content" class="app-sidebar__content">
        <img alt="" class="app-sidebar__logo" src="{{ URL::asset('img/logo-white.png') }}">

      @if(auth()->user())
        <ul class="app-menu">
        <li>
          <div class="app-menu__separator app-menu__separator--first">Olá <br />
            <strong>
              @php $name = explode(' ',auth()->user()->name); echo $name[0]; @endphp
            </strong>
          </div>
        </li>

        @if(auth()->user()->privilege_id !== 1)
        <li><a class="app-menu__link {{request()->segment(1) == 'dashboard' ?  'app-menu__link--active' : ''}}" title="" href="{{route('dashboard')}}"><i class="fas fa-chart-bar"></i>Dashboard</a></li>
        @endif
        <li>
          <div class="app-menu__separator @if(auth()->user()->privilege_id === 1)app-menu__separator--none @endif">Leads</div>
        </li>
        <li><a class="app-menu__link {{(request()->segment(1) == 'funnel' || request()->segment(1) == '') && request()->segment(2) == '' ?  'app-menu__link--active' : ''}}" title="" href="{{route('funnel')}}"><i class="fas fa-filter"></i>Funil</a></li>
        <li><a class="app-menu__link {{request()->segment(1) == 'lead' && request()->segment(2) == '' ?  'app-menu__link--active' : 'list'}}" title="" href="{{route('lead')}}"><i class="fas fa-list"></i>Listar</a></li>
        @if(auth()->user()->privilege_id === 1)
          <li><a class="app-menu__link {{request()->segment(1) == 'lead' && request()->segment(2) == 'add' ?  'app-menu__link--active' : 'add'}}" title="" href="{{route('lead.create')}}"><i class="fas fa-user-plus"></i>Cadastrar</a></li>
        @endif

        @if(auth()->user()->privilege_id === 3)
          <li>
            <div class="app-menu__separator">Equipes</div>
          </li>
          <li><a class="app-menu__link {{request()->segment(1) == 'team' && request()->segment(2) == '' ?  'app-menu__link--active' : ''}}" title="" href="{{route('team')}}"><i class="fas fa-list"></i>Listar</a></li>
          <li><a class="app-menu__link {{request()->segment(1) == 'team' && request()->segment(2) == 'add' ? 'app-menu__link--active' : ''}}" title="" href="{{route('team.create')}}"><i class="fas fa-user-plus"></i>Cadastrar</a></li>
        @endif

        @if(auth()->user()->privilege_id !== 1)
          <li>
            <div class="app-menu__separator">Usuários</div>
          </li>
          <li><a class="app-menu__link {{request()->segment(1) == 'user' && request()->segment(2) == '' ?  'app-menu__link--active' : ''}}" title="" href="{{route('user')}}"><i class="fas fa-list"></i>Listar</a></li>
          <li><a class="app-menu__link {{request()->segment(1) == 'user' && request()->segment(2) == 'add' ?  'app-menu__link--active' : ''}}" title="" href="{{route('user.create')}}"><i class="fas fa-user-plus"></i>Cadastrar</a></li>
        @endif

        <li>
          <div class="app-menu__separator app-menu__separator--last"></div>
        </li>
        <li><a class="app-menu__link" title="" href="{{route('logout')}}"><i class="fas fa-sign-in-alt"></i>Sair</a></li>
      </ul>
    @endif

      </div>
    </aside>

    <main class="app-content">
      <div class="app-content__container">

        @yield('content')

      </div>
      <footer class="app-footer">
        <a title="Desenvolvido por Liv Digital" target="_blank" href="https://www.julioantonini.com.br/">
          Desenvolvido por  www.julioantonini.com.br
        </a>
      </footer>

    </main>


  </div>





  <script src="{{ asset('build/app.js') }}"></script>
  <script src="{{ asset('build/vendor.min.js') }}"></script>

  @if (app()->environment() === 'production')
    <script src="{{ asset('build/scripts.min.js') }}"></script>
  @else
    <script src="{{ asset('js/scripts.js') }}"></script>
  @endif

  @yield('scripts')
</body>

</html>
