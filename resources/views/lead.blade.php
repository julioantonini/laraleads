@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Leads
</div>

<div class="content__container">

  @include('layouts.flash-message')

  <div class="export__container">

    <a href="{{route('export')}}" title="Exportar leads" class="btn btn-primary"><i class="fas fa-file-excel"></i> Exportar leads</a>

    @if(auth()->user()->privilege_id !== 1)
    <form action="{{route('export.store')}}" method="post">
      @csrf
      <div class="export__lead--user">
        Exportar por corretor
        <div class="form-group export__lead--select">
          <select name="user_id" class="form-control">
            <option value="">Selecione o corretor</option>
            @foreach ($users as $u)
              @if(auth()->user()->privilege_id === 3)
              <option value="{{$u->id}}">{{$u->name}} - {{$u->team ? $u->team->name : 'Sem equipe'}} - {{$u->privilege->name}} - ({{$u->leads_count}})</option>
              @else
              <option value="{{$u->id}}">{{$u->name}}  - {{$u->privilege->name}} - ({{$u->leads_count}})</option>
              @endif
            @endforeach
          </select>
        </div>

        <button type="submit" title="Apagar" class="btn btn-primary"><i class="fas fa-file-excel"></i> Exportar</button>
      </div>
    </form>
    @endif

  </div>

  <div class="table-responsive">
    <table class="datatables table table-hover dataTable table-bordered table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Estágio</th>
          @if(auth()->user()->privilege_id !== 1) <th>Corretor</th> @endif
          @if(auth()->user()->privilege_id === 3) <th>Equipe</th> @endif
          <th>Data de cadastro</th>
          <th style="width:66px">Ações</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($leads as $l)
        <tr>
          <td>{{$l->name}}</td>
          <td>{{$l->email}}</td>
          <td>{{$l->phone}}</td>
          <td>{{$l->funnel ? $l->funnel->name : ''}}</td>
          @if(auth()->user()->privilege_id !== 1) <td>{{$l->user ? $l->user->name : ''}}</td> @endif
          @if(auth()->user()->privilege_id === 3) <td>{{$l->team ? $l->team->name : ''}}</td> @endif
          <td>{{ \Carbon\Carbon::parse($l->created_at)->format('d/m/Y \à\s H:i')}}</td>
          <td>
            <a title="Editar" href="{{route('lead.edit', ['id' => $l->id])}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
            <button type="button" onClick="sweetDelete('Apagar lead','Deseja realmente apagar o lead <br/>{{$l->name}} ?','{{route('lead.destroy', ['id' => $l->id])}}')" title="Apagar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
          </td>
        </tr>
        @endforeach

      </table>
    </div>
  </div>


  @endsection
