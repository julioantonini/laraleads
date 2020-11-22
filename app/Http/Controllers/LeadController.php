<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funnel;
use App\Lead;
use App\User;



class LeadController extends Controller
{

    public function index()
    {

      if(auth()->user()->privilege_id === 3){
        $users = User::with(['team','privilege'])->withCount(['leads'])->get()->sortBy('name')->sortBy('team_id');
        $leads = Lead::with(['funnel','team','user'])->orderByDesc('created_at')->get();
      }else if(auth()->user()->privilege_id === 2){
        $users = User::with(['team','privilege'])->withCount(['leads'])->withCount(['leads'])->where('team_id', auth()->user()->team_id)->orderBy('name')->get();
        $leads = Lead::with(['funnel','user'])->where('team_id', auth()->user()->team_id)->orderByDesc('created_at')->get();
      }else {
        $users = [];
        $leads = Lead::with(['funnel','user'])->where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
      }


      return view('lead', compact(['leads', 'users']));
    }


    public function create()
    {
      $funnels = Funnel::get();
      return view('lead-add', compact(['funnels']));
    }


    public function store(Request $request)
    {
      $rules = [
        'name' => 'required|unique:teams,name',
        'email' => 'required|email',
        'funnel_id' => 'required',
      ];

      $names = [
        'name' => 'Nome',
        'email' => 'E-mail',
        'funnel_id' => 'Estágio',
      ];

      $request->validate($rules, [], $names);

      $lead = new Lead();
      $lead->user_id = auth()->user()->id;
      $lead->team_id = auth()->user()->team_id;
      $lead->name = $request->name;
      $lead->email = $request->email;
      $lead->phone = $request->phone;
      $lead->cpf = $request->cpf;
      $lead->birthdate = $request->birthdate;
      $lead->income = $request->income;
      $lead->funnel_id = $request->funnel_id;
      $lead->comments = $request->comments;
      $lead->status = 1;

      $lead->save();



      return redirect()->route('lead')->with('success','Lead cadastrado com sucesso');
    }


    public function show($user_id, $lead_id)
    {

      $lead = Lead::where('id',$lead_id)->where('user_id',$user_id)->first();
      if(isset($lead)){
        $lead->status = 1;
        $lead->save();
      }

      return view('lead-show', compact(['lead']));
    }


    public function edit($id)
    {

      $funnels = Funnel::get();
      $lead = Lead::find($id);
      return view('lead-edit', compact(['funnels', 'lead']));

    }

    public function update(Request $request, $id)
    {

      $rules = [
        'name' => 'required|unique:teams,name',
        'email' => 'required|email',
        'funnel_id' => 'required',
      ];

      $names = [
        'name' => 'Nome',
        'email' => 'E-mail',
        'funnel_id' => 'Estágio',
      ];

      $request->validate($rules, [], $names);

      $lead = Lead::find($id);

      $lead->name = $request->name;
      $lead->email = $request->email;
      $lead->phone = $request->phone;
      $lead->cpf = $request->cpf;
      $lead->birthdate = $request->birthdate;
      $lead->income = $request->income;
      $lead->funnel_id = $request->funnel_id;
      $lead->comments = $request->comments;
      $lead->status = 1;

      $lead->save();

      return redirect()->route('lead')->with('success','Lead alterado com sucesso');
    }


    public function destroy($id)
    {
      $lead = Lead::find($id)->first();

      if(isset($lead)){
        $lead->delete();
      }

      return back()->with('success','Lead apagado com sucesso');
    }
}
