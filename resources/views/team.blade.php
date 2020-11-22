@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Equipes
</div>

<div class="content__container">

  @include('layouts.flash-message')

  <div class="table-responsive">
    <table class="datatables table table-hover dataTable table-bordered table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Usuários</th>
          <th>Leads</th>
          <th style="width:66px">Ações</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($teams as $t)
          <tr>
            <td>{{$t->name}}</td>
            <td>{{$t->users_count}}</td>
            <td>{{$t->leads_count}}</td>
            <td>
              <a title="Editar" href="{{route('team.edit', ['id' => $t->id])}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
              <button type="button" onClick="sweetDelete('Apagar equipe','Deseja realmente apagar a equipe <br/>{{$t->name}} ?','{{route('team.destroy', ['id' => $t->id])}}')" title="Apagar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
            </td>
          </tr>
        @endforeach

      </table>
    </div>
  </div>

  @endsection
