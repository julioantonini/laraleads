@extends('layouts.app')
@section('content')



<div class="container">

  <div class="breadcrumps">
    Leads <i class="fas fa-angle-right"></i> Dados do lead
  </div>


  <div class="content__container">
  @include('layouts.flash-message')

  @if(!$lead)

  <div class="alert alert-danger" role="alert">
    <i class="fas fa-times"></i> Este lead não está mais disponível!
  </div>

  @else
    <div class="row">
      <div class="col-md-6 col-xl-4 form-group">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" readOnly value="{{$lead->name}}" />
      </div>

      <div class="col-md-6 col-xl-4  form-group">
        <label>E-mail</label>
        <input type="text" name="email" class="form-control" readOnly value="{{$lead->email}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Telefone</label>
        <input type="text" name="phone" class="form-control" readOnly value="{{$lead->phone}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>CPF</label>
        <input type="text" name="cpf" class="form-control" readOnly value="{{$lead->cpf}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Data de nascimento</label>
        <input type="text" name="birthdate" class="form-control" readOnly value="{{$lead->birthdate}}"  />
      </div>

      <div class="col-md-6 col-xl-4 form-group">
        <label>Renda</label>
        <input type="text" name="income" class="form-control" readOnly value="{{$lead->income}}"  />
      </div>

      <div class="col-lg-12 form-group">
        <label>Mensagem</label>
        <textarea name="comments" readOnly class="form-control">{{$lead->comments}}</textarea>
      </div>

      <div class="col-md-12 lead__contact__buttons">
        <a href="https://api.whatsapp.com/send?phone=+55{{$lead->phone}}" class="btn btn-success btn-lg">
          <i class="fab fa-whatsapp"></i> Falar no WhatsApp
        </a>

        <a href="tel:+55{{$lead->phone}}" class="btn btn-primary btn-lg">
         <i class="fas fa-phone-alt"></i> Ligar agora
        </a>
      </div>
    </div>
  @endif
  

</div>
</div>

@endsection
