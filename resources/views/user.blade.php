@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Usuários
</div>

<div class="content__container">

  @include('layouts.flash-message')

  <div class="table-responsive">
    <table class="datatables table table-hover dataTable table-bordered table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th>E-mail</th>
          <th>Privilégio</th>
          @if(auth()->user()->privilege_id === 3) <th>Equipe</th> @endif
          <th>Leads</th>

          <th style="width:66px">Ações</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($users as $u)
          <tr>
            <td>{{$u->name}}</td>
            <td>{{$u->email}}</td>
            <td>{{$u->privilege->name}}</td>
            @if(auth()->user()->privilege_id === 3) <td>{{$u->team ? $u->team->name : ''}}</td> @endif
            <td>{{$u->leads_count}}</td>
            <td>
              <a title="Editar" href="{{route('user.edit', ['id' => $u->id])}}" class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>
              <button type="button" onClick="handleUserDeletePopup('{{$u->id}}','{{$u->name}}', '{{$u->leads_count}}')" title="Apagar" class="btn btn-primary"><i class="fas fa-trash-alt"></i></button>
            </td>
          </tr>
        @endforeach

      </table>
    </div>
  </div>


  <div class="user-delete__popup">
    <div class="user-delete__popup__flex">
      <div class="user-delete__popup__content">
        <button type="button" onClick="handleClosePopup()"  class="btn btn-primary user-delete__popup__button__close"><i class="fas fa-times"></i></button>
        <p class="user-delete__popup__title">
          Mover leads
        </p>

        <p class="user-delete__popup__desc">Selecione para quem deve ir os (<b id="user-qtd-leads">0</b>) leads do usuário:
          <b id="user-name"></b> antes de deleta-lo.
        </p>

        <form id="form-move-lead" action="{{route('user.movedestroy')}}" method="POST">
          @csrf

          <div class="row">
            <div class="col-md-12 form-group">
              <select id="new_user_id" name="new_user_id" class="form-control" required>
                <option value="">Selecione</option>

                @foreach ($users as $u)
                  @if(auth()->user()->privilege_id === 3)
                    <option value="{{$u->id}}">{{$u->name}} - {{$u->team ? $u->team->name : 'Sem equipe'}} - {{$u->privilege->name}}</option>
                  @else
                    <option value="{{$u->id}}">{{$u->name}}  - {{$u->privilege->name}}</option>
                  @endif
                @endforeach

              </select>
            </div>
            <div class="col-md-12 form-group">
              <div class="text-right">
                <button type="button" onClick="sweetUserDelete('{{url('user/destroy/')}}')" class="btn btn-danger">
                  APAGAR TUDO
                </button>
                <button type="submit" class="btn btn-primary">
                  MOVER E APAGAR
                </button>
              </div>
            </div>
          </div>
          <input type="hidden" id="user_id" name="user_id">
        </form>
      </div>
    </div>
  </div>

  @endsection
