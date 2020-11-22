@extends('layouts.app')
@section('content')

<div class="breadcrumps">
  Dashboard <i class="fas fa-angle-right"></i> Relatórios
</div>




<div class="row">
  <div class="col-md-12 col-lg-8 col-xl-6">
    <div class="content__container">

      @include('layouts.flash-message')

      <form action="" method="GET">

        <div class="row">

          <div class="col-sm-5 col-md-4 col-lg-4">
            <label>Data inicial</label>
            <input name="first-date" class="form-control" readonly type="text" id="from" value="{{\Carbon\Carbon::parse($firstDate)->format('d/m/Y')}}" placeholder="Data Inicial" />
          </div>

          <div class="col-sm-5 col-md-4 col-lg-4">
            <label>Data final</label>
            <input name="last-date" class="form-control" readonly type="text" id="to" value="{{\Carbon\Carbon::parse($lastDate)->format('d/m/Y')}}" placeholder="Data Final" />
          </div>


          <div class="col-sm-2 col-md-4 col-lg-4">

            <button style="margin-top:31px;" type="submit" class="btn btn-primary">LISTAR</button>
          </div>

        </div>
      </form>
    </div>
  </div>
  <div class="col-sm-6 col-md-6 col-lg-2 col-xl-3">
    <div class="content__container">
      <div class="dashboard__info">
        <strong>Leads</strong>
        <span>{{$qtdLead}}</span>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-6 col-lg-2 col-xl-3">
    <div class="content__container">
      <div class="dashboard__info">
        <strong>Vendas</strong>
        <span>{{$qtdSell}}</span>
      </div>
    </div>
  </div>
</div>

<div class="content__container">
  <div class="chart__title">
    Leads no período
  </div>
  <div id='chart_leads_periodo'></div>
</div>

<div class="content__container">
  <div class="chart__title">
    Leads por corretor
  </div>
  <div id='chart_leads_users'></div>
</div>

@if(auth()->user()->privilege_id === 3)
<div class="content__container">
  <div class="chart__title">
    Leads por equipe
  </div>
  <div id='chart_leads_team'></div>
</div>
@endif






@endsection

@section('scripts')

<script>
  Morris.Line({
    parseTime:false,
    element: 'chart_leads_periodo',
    data: [

    @foreach ($qtdLeadByDays as $key => $value)
      { day: '{{\Carbon\Carbon::parse($key)->format('d/m')}}', qtd: {{count($value)}} },
    @endforeach

    ],
    xkey: 'day',
    ykeys: ['qtd'],
    labels: ['Leads']
  });




  Morris.Bar({
    element: 'chart_leads_users',
    data: [
    @foreach ($qtdLeadByUser as  $q)
      { user: '{{$q->name}} @if(auth()->user()->privilege_id === 3) \n {{$q->team ? $q->team->name : ''}} @endif', qtd: {{$q->leads_count}} },
    @endforeach
    ],
    xkey: 'user',
    ykeys: ['qtd'],
    labels: ['Leads']
  });

  @if(auth()->user()->privilege_id === 3)

  Morris.Bar({

    element: 'chart_leads_team',
    data: [
    @foreach ($qtdLeadByTeam as  $q)
    { team: '{{$q->name}}', qtd: {{$q->leads_count}} },
    @endforeach

    ],
    xkey: 'team',
    ykeys: ['qtd'],
    labels: ['Leads']
  });
  @endif
</script>


@endsection
