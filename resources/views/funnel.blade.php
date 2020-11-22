@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Funil
</div>

@include('layouts.flash-message')



<div class="funnel__container">
  @foreach ($funnels as $f)
  <div class="connected-box">
    <div class="connected-title">
      {{$f->name}}
    </div>

    <ul id="lista-{{$f->id}}" class="connectedSortable">
      @foreach ($f->leads as $l)
      <li class="list-group-item" onClick="handleLoadLeadInfo('{{route('lead.info', ['id' => $l->id])}}')" id="{{$l->id}}">
        <div class="client-line-text">
          <b>{{$l->name}}</b><br/>
          {{$l->phone}}<br />
          {{$l->email}}<br />
          @if(auth()->user()->privilege_id !== 1)
          {{$l->user ? 'Corretor: '.$l->user->name : '' }}
          @endif

        </div>
        <div class="cliente-line-1">

          <div>
            @if(auth()->user()->privilege_id === 3)
            {{$l->team ? 'Equipe: '.$l->team->name : '' }}
            @endif
          </div>
          <div class="cliente-line-1-data"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($l->created_at)->format('d/m/Y \à\s H:i')}}</div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
  @endforeach

</div>


<div class="funnel-loading-popup">
  <div class="funnel-loading-popup__flex">
    <img alt="" class="app-sidebar__logo" src="{{ URL::asset('img/dots.svg') }}">
  </div>
</div>


<div class="funnel-popup">
  <div class="funnel-popup__flex">
    <div class="funnel-popup__content">
      <button type="button" onClick="handleCloseFunnelPopup()"  class="btn btn-primary funnel-popup__button__close"><i class="fas fa-times"></i></button>

      <div class="funnel-popup__lead-info">
        <div class="funnel-popup__lead-info__top">
          <div id="lead-sigla" class="lead-info__avatar">

          </div>
          <p id="lead-nome"></p>
        </div>
        <div class="funnel-popup__lead-info__content">
          <p><b>E-mail:</b><span id="lead-email"></span></p>
          <p><b>Telefone:</b><span id="lead-fone"></span></p>
          <p><b>CPF:</b><span id="lead-cpf"></span></p>
          <p><b>Data de nascimento:</b><span id="lead-data-nasc"></span></p>
          <p><b>Renda:</b><span id="lead-renda"></span></p>
          <p><b>Mensagem:</b><span class="message" id="lead-mensagem"></span></p>
        </div>
      </div>

      <div class="funnel-popup-lead-historic">
        <div class="message-historic">

          <div id="timeline-box" class="timeline-vertical-box">



          </div>


        </div>
        <div class="message-box form-group">
          <textarea id="message" name="message" class="form-control"></textarea>
          <button type="button" onClick="handleSendMessage('{{route('lead.info.create')}}')" class="btn btn-success" title="Enviar">
            <i class="fas fa-paper-plane fa-2x"></i>
          </button>

          <input type="hidden" id="lead_id" name="lead_id"/>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')

<script>
  @foreach ($funnels as $f)
  lista{{$f->id}} = document.getElementById('lista-{{$f->id}}'),
  @endforeach

  @foreach ($funnels as $f)
  new Sortable(lista{{$f->id}}, {
    group: 'shared',
    animation: 200,
    onEnd: function (evt) {
      var itemEl = evt.item; // dragged HTMLElement
      evt.to; // target list
      evt.from; // previous list
      evt.oldIndex; // element's old index within old parent
      evt.newIndex; // element's new index within new parent
      evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
      evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements


      if((evt.oldIndex !== evt.newIndex) || (evt.from.id !== evt.to.id)){
        // console.log("move");
        // console.log('id: ',evt.item.id)
        // console.log('order: ',evt.newIndex)
        // console.log('id-lista: ',evt.to.id)

        var values = [];

        for (let index = 1; index <= 6; index++) {
          let order = 0;
          $("#lista-" + index + " li").each(function() {
            values.push({
              id: $(this).attr('id'),
              funnel_id: index,
              funnel_order: order
            });
            order++;
          });
        }

        let funnelData = JSON.stringify(values);

        $.post( "{{route('funnel.update')}}",  { lead_id: evt.item.id, data : funnelData }, function( data ) {
          console.log(data)
        });

      }


    },
  });
  @endforeach






</script>

<style>

  .sortable-chosen{
    background: #DDEFF7 !important;
  }
  .sortable-drag{
    transition:background 0.2s;
    background: #DDEFF7 !important;
    opacity: 1 !important;
  }
</style>

@endsection
