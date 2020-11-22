<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Team;
use App\Privilege;
use App\Lead;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;

class UserController extends Controller
{

  public function __construct(){
    $this->middleware('userCheck');
  }

  public function index()
  {

    if(auth()->user()->privilege_id === 3){
      $users = User::with(['team','privilege'])->withCount(['leads'])->get()->sortBy('name')->sortBy('team_id');
    }

    else if(auth()->user()->privilege_id === 2){
      $users = User::with(['team','privilege'])->withCount(['leads'])->where('team_id', auth()->user()->team_id)->orderBy('name')->get();
    }

    return view('user', compact(['users']));
  }


  public function create()
  {
    if(auth()->user()->privilege_id === 3){
      $privileges = Privilege::get();
      $teams = Team::orderBy('name')->get();
    }else if(auth()->user()->privilege_id === 2){
      $privileges = Privilege::whereNotIn('id', [3])->get();
      $teams = [];
    }

    return view('user-add', compact(['privileges', 'teams']));
  }


  public function store(Request $request)
  {

    if(auth()->user()->team_id !== 3){
      $rules = [
        'name' => 'required|unique:teams,name',
        'email' => 'required|email|unique:users,email',
        'team_id' => 'required_unless:privilege_id,3',
        'privilege_id' => 'required',
        'password' => 'required|min:8|max:20',
      ];
    }else{
      $rules = [
        'name' => 'required|unique:teams,name',
        'email' => 'required|email|unique:users,email',
        'privilege_id' => 'required',
        'password' => 'required|min:8|max:20',
      ];
    }


    $names = [
      'name' => 'Nome',
      'email' => 'E-mail',
      'team_id' => 'Equipe',
      'privilege_id' => 'Privilégio',
      'password' => 'Senha',
    ];

    $request->validate($rules, [], $names);

    if(auth()->user()->privilege_id !== 3){
      $request['team_id'] = auth()->user()->team_id;

      if($request->privilege_id == 3){
        $request['privilege_id'] = 1;
      }
    }

    if($request->privilege_id == 3){
      $request['team_id'] = null;
    }

    $user = User::create($request->only('name','email','team_id','privilege_id','password'));

    Mail::to($request->email)->send(new NewUserMail($user, $request->password));

    return redirect()->route('user')->with('success','Usuário cadastrado com sucesso');
  }


  public function edit($id)
  {
    if(auth()->user()->privilege_id === 3){
      $privileges = Privilege::get();
      $teams = Team::orderBy('name')->get();
    }else if(auth()->user()->privilege_id === 2){
      $privileges = Privilege::whereNotIn('id', [3])->get();
      $teams = [];
    }

    $user = User::find($id);

    return view('user-edit', compact(['user', 'privileges', 'teams']));
  }


  public function update(Request $request, $id)
  {
    if(auth()->user()->privilege_id === 2){
      $rules = [
        'name' => 'required|unique:teams,name',
        'email' => 'required|email|unique:users,email,'.$id,
        'privilege_id' => 'required',
        'password' => 'nullable|min:8|max:20',
      ];
    }else{
      $rules = [
        'name' => 'required|unique:teams,name',
        'email' => 'required|email|unique:users,email,'.$id,
        'team_id' => 'required_unless:privilege_id,3',
        'privilege_id' => 'required',
        'password' => 'nullable|min:8|max:20',
      ];
    }

    $names = [
      'name' => 'Nome',
      'email' => 'E-mail',
      'team_id' => 'Equipe',
      'privilege_id' => 'Privilégio',
      'password' => 'Senha',
    ];

    $request->validate($rules, [], $names);

    if(auth()->user()->privilege_id !== 3){
      $request['team_id'] = auth()->user()->team_id;

      if($request->privilege_id == 3){
        $request['privilege_id'] = 1;
      }
    }

    if($request->privilege_id == 3){
      $request['team_id'] = null;
    }

    $user = User::find($id);
    $user->update($request->only('name','email','team_id','privilege_id'));

    if($request->password){
      $user->update($request->only('password'));
    }




    return redirect()->route('user')->with('success','Usuário alterado com sucesso');
  }


  public function destroy($id)
  {
    if(auth()->user()->id == $id){
      return back()->with('warning','Você não pode apagar o próprio usuário');
    }

    $user = User::find($id);
    if(isset($user)){
      $user->delete();
    }
    return back()->with('success','Usuário apagado com sucesso');
  }

  public function moveAndDestroy(Request $request)
  {

    if(auth()->user()->id == $request->user_id){
      return back()->with('warning','Você não pode apagar o próprio usuário');
    }


    if($request->user_id == $request->new_user_id){
      return back()->with('error','Selecione outro usuário para transferir os leads');
    }




    $user = User::find($request->user_id);

    $newUser = User::find($request->new_user_id);


    $leads = Lead::where('user_id', $request->user_id);
    $leads->update(['team_id' => $newUser->team_id, 'user_id' => $request->new_user_id]);

    if(isset($user)){
      $user->delete();
    }

    return back()->with('success','Usuário apagado com sucesso');
  }


}
