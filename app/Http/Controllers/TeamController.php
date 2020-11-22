<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;

class TeamController extends Controller
{
  public function __construct(){
    $this->middleware('teamCheck');
  }

  public function index()
  {
    $teams = Team::withCount(['users','leads'])->orderBy('name')->get();
    return view('team', compact(['teams']));
  }


  public function create()
  {
    return view('team-add');
  }


  public function store(Request $request)
  {
    $rules = [
      'name' => 'required|unique:teams,name',
    ];

    $names = [
      'name' => 'Nome',
    ];

    $request->validate($rules, [], $names);

    Team::create($request->only('name'));

    return redirect()->route('team')->with('success','Equipe cadastrada com sucesso');
  }



  public function edit($id)
  {
    $team = Team::find($id);

    return view('team-edit', compact(['team']));
  }


  public function update(Request $request, $id)
  {
    $rules = [
      'name' => 'required|unique:teams,name,'.$id,

    ];

    $names = [
      'name' => 'Nome',
    ];

    $request->validate($rules, [], $names);

    $team = Team::find($id);
    $team->update($request->only('name'));

    return redirect()->route('team')->with('success','Equipe alterada com sucesso');

  }

  public function destroy($id)
  {
    $team = Team::find($id);
    if(isset($team)){
      $team->delete();
    }
    return back()->with('success','Equipe apagada com sucesso');
  }
}
