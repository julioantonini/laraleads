@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Usuários <i class="fas fa-angle-right"></i> Cadastro
</div>

<div class="content__container">
  @include('layouts.flash-message')

  <form action="{{route('user.store')}}" method="POST">
    @csrf

    <div class="row">
      <div class="col-md-6 col-xl-4 form-group">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="{{old('name')}}" />
      </div>
      <div class="col-md-6 col-xl-4 form-group">
        <label>E-mail</label>
        <input type="text" name="email" class="form-control" value="{{old('email')}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Privilégio</label>
        <select name="privilege_id" class="form-control">
          <option value="">Selecione</option>

          @foreach ($privileges as $p)
            <option {{$p->id == old('privilege_id') ? 'selected' : ''}} value="{{$p->id}}">{{$p->name}}</option>
          @endforeach

        </select>
      </div>

      @if(auth()->user()->privilege_id === 3)
      <div class="col-md-6 col-xl-4 form-group">
        <label>Equipe</label>
        <select name="team_id" class="form-control">
          <option value="">Selecione</option>

          @foreach ($teams as $t)
            <option {{$t->id == old('team_id') ? 'selected' : ''}} value="{{$t->id}}">{{$t->name}}</option>
          @endforeach

        </select>
      </div>
      @endif

      <div class="col-md-6 col-xl-4 form-group">
        <label>Senha</label>
        <input type="text" name="password" class="form-control" />
      </div>

      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">
          CADASTRAR
        </button>
      </div>
    </div>
  </form>

</div>

@endsection
