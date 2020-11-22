<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\User;
use App\Lead;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewLeadMail;



class RouletteController extends Controller
{

  public function store(Request $request)
  {
    if(!isset($request->email)){
      return redirect()->away($request->redirect_url);
    }

    $user = $this->verifyLead($request->email);
    if(!isset($user)){
      return redirect()->away($request->redirect_url);
    }

    $lead = new Lead();

    $lead->team_id = $user->team_id;
    $lead->user_id = $user->id;
    $lead->name = $request->name;
    $lead->email = $request->email;
    $lead->phone = $request->phone;
    $lead->comments = $request->comments;
    $lead->cpf = $request->cpf;
    $lead->birthdate = $request->birthdate;
    $lead->income = $request->income;

    $lead->save();

    Mail::to($user->email)->send(new NewLeadMail($user, $lead));


    return redirect()->away($request->redirect_url);
  }

  private function verifyLead($email)
  {
    $leadExists = Lead::where('email', $email)->latest('created_at')->first();

    if(isset($leadExists)){
      $to = Carbon::parse($leadExists->created_at);
      $from = Carbon::now();
      $diffInHours = $to->diffInHours($from);
      if($diffInHours < 24){
        $user = User::where('id', $leadExists->user_id)->first();
      }else{
        $user = $this->selectUser();
      }
      return $user;
    }

    return $this->selectUser();
  }

  private function selectUser()
  {

    $qtdTeams = count(
      DB::table('teams')
      ->join('users', 'teams.id', '=', 'users.team_id')
      ->where('users.privilege_id', 1)
      ->select('teams.id')
      ->groupBy('teams.id')
      ->get()
    );

    if($qtdTeams == 0){
      return;
    }

    $qtdTeamsReceived = count(
      DB::table('teams')
      ->join('users', 'teams.id', '=', 'users.team_id')
      ->where('users.privilege_id', 1)
      ->where('teams.received', 1)
      ->select('teams.id')
      ->groupBy('teams.id')
      ->get()
    );

    if($qtdTeams === $qtdTeamsReceived){
      Team::where('received', 1)->update(['received' => 0]);
    }


    $selectedTeam = DB::table('teams')
    ->join('users', 'teams.id', '=', 'users.team_id')
    ->where('teams.received', 0)
    ->where('users.privilege_id', 1)
    ->select('teams.*')
    ->inRandomOrder()
    ->first();

    Team::where('id', $selectedTeam->id)->update(['received' => 1]);

    $QtdUsersInTeam = User::where('privilege_id', 1)->where('team_id', $selectedTeam->id)->count();
    $QtdUsersInTeamReceived = User::where('privilege_id', 1)->where('team_id', $selectedTeam->id)->where('received', 1)->count();

    if($QtdUsersInTeam === $QtdUsersInTeamReceived){
      User::where('team_id', $selectedTeam->id)->update(['received' => 0]);
    }


    $selectedUser = User::where('team_id', $selectedTeam->id)->where('privilege_id', 1)->where('received', 0)->inRandomOrder()->first();
    $selectedUser->received = 1;
    $selectedUser->save();
    return $selectedUser;
  }
}
