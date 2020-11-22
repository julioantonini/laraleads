@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Leads <i class="fas fa-angle-right"></i> Edição
</div>

<div class="content__container">
  @include('layouts.flash-message')

  <form action="{{route('lead.update', ['id' => $lead->id])}}" method="POST">
    @csrf


    <div class="row">
      <div class="col-md-6 col-xl-4 form-group">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="{{$lead->name}}" />
      </div>

      <div class="col-md-6 col-xl-4  form-group">
        <label>E-mail</label>
        <input type="text" name="email" class="form-control" value="{{$lead->email}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Telefone</label>
        <input type="text" name="phone" class="form-control" value="{{$lead->phone}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>CPF</label>
        <input type="text" name="cpf" class="form-control" value="{{$lead->cpf}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Data de nascimento</label>
        <input type="text" name="birthdate" class="form-control" value="{{$lead->birthdate}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Renda</label>
        <input type="text" name="income" class="form-control" value="{{$lead->income}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Estágio</label>
        <select name="funnel_id" class="form-control">
          <option value="">Selecione</option>

          @foreach ($funnels as $f)
            <option {{$f->id == $lead->funnel_id ? 'selected' : ''}} value="{{$f->id}}">{{$f->name}}</option>
          @endforeach

        </select>
      </div>

      <div class="col-lg-12 form-group">
        <label>Mensagem</label>
        <textarea name="comments" class="form-control">{{$lead->comments}}</textarea>
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
