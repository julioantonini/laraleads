<p>
  Olá {{$user->name}}, tudo bem?
</p>

<p>
  Conforme solicitado, envio abaixo suas credenciais de acesso ao {{config('app.name')}}<br/>
  Seu acesso será útil para organizar o feedback dos atendimentos conforme a etapa do funil de atendimento.
</p>

<p>
  Endereço de acesso: <a title="" href="{{config('app.app_url')}}">{{config('app.app_url')}}</a><br/>
  Usuário: {{$user->email}} <br/>
  Senha: {{$password}} <br/>
</p>

<p>
Boa sorte nas vendas!<br/>
Abraço
</p>
