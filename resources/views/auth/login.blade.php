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

  @if (app()->environment() === 'production')
    <link href="{{ URL::asset('build/style-login.min.css') }}" rel="stylesheet">
  @else
    <link href="{{ URL::asset('css/style-login.css') }}" rel="stylesheet">
  @endif

</head>
<body>

  <div class="login_container">
    <div class="login_container__content">

      <img alt="" class="login_container__img" src="{{ URL::asset('img/logo.png') }}">

      <form method="POST" action="{{ route('login') }}" autocomplete="off">
        @csrf

        @include('layouts.flash-message')

        <div class="form-group">
          <input id="email" type="email" class="form-control"  name="email" value="{{ old('email') }}" placeholder="E-mail" autofocus>
        </div>

        <div class="form-group">
          <input id="password" type="password" class="form-control" name="password" placeholder="Senha">
        </div>



        <div class="form-group row">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-primary">
              ENTRAR
            </button>

          </div>
        </div>
      </form>

    </div>
  </div>

  <script src="{{ asset('build/app.js') }}" defer></script>
</body>
</html>
