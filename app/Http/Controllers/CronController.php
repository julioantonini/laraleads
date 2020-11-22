<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Lead;

use Illuminate\Support\Facades\Mail;
use App\Mail\NewLeadMail;


class CronController extends Controller
{

  public function index()
  {

    $leads =  Lead::where('status', 0)->where('created_at', '<=', Carbon::now()->subMinutes(15))->get();

    $qtdUpdates = 0;
    foreach($leads as $l){
      $newUser = $this->selectUserInTeam($l->team_id);
      if($l->user_id !== $newUser->id){

        $l->user_id = $newUser->id;
        $l->save();

        Mail::to($newUser->email)->send(new NewLeadMail($newUser, $l));

        $qtdUpdates++;
      }
    }

    echo "Updates: ".$qtdUpdates;

  }

  private function selectUserInTeam($team_id)
  {

    //conta todos os corretores da equipe
    $QtdUsersInTeam = User::where('privilege_id', 1)->where('team_id', $team_id)->count();

    if($QtdUsersInTeam == 0){
      return "00";
    }

    //conta todos os corretores da equipe que ja receberam lead
    $QtdUsersInTeamReceived = User::where('privilege_id', 1)->where('team_id', $team_id)->where('received', 1)->count();

    //se todos os corretores da equipe ja tiverem recebido, reseta a contagem
    if($QtdUsersInTeam === $QtdUsersInTeamReceived){
      User::where('team_id', $team_id)->update(['received' => 0]);
    }

    //pego o corretores que irá receber o lead
    $selectedUser = User::where('team_id', $team_id)->where('privilege_id', 1)->where('received', 0)->inRandomOrder()->first();

    //marco que ele recebeu o lead
    $selectedUser->received = 1;
    $selectedUser->save();

    return $selectedUser;
  }
}
