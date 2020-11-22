<div style="font-family: Arial, Helvetica, sans-serif; color:#494949">
  <p>
  Olá {{$user->name}},
</p>

<p>
  Chegou um lead para você.<br/>
  Clique no link abaixo para entrar em contato com o interessado imediatamente<br/>
</p>

<p>
  <a style="display:inline-block; padding: 12px 18px; background:#2B84AA; color: #fff; text-align:center;  text-decoration:none" 
  href="{{route('lead.check', ['user_id' => $user->id, 'lead_id' => $lead->id])}}">
  ACESSAR PAINEL (entrar em contato)
  </a>
</p>

<p>
  Corra! O lead ficará disponível na sua conta nos próximos 15 minutos.
</p>

<hr/>

<p style="color: gray; font-size: 12px;"><i>Mensagem automática. Favor não responder a este e-mail.</i><p>


</div>
