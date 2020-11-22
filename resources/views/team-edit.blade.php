@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Equipes <i class="fas fa-angle-right"></i> Edição
</div>

<div class="content__container">

  @include('layouts.flash-message')

  <form action="{{route('team.update', ['id' => $team->id])}}" method="POST">
    @csrf

    <div class="row">
      <div class="col-md-6 col-xl-4 form-group">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="{{$team->name}}" />
      </div>

      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">
          SALVAR
        </button>
      </div>

    </div>
  </form>
</div>

@endsection
