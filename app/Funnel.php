<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funnel extends Model
{
  public function leads()
  {
    if(auth()->user()->privilege_id === 3){
      return $this->hasMany('App\Lead')->with(['user','team'])->orderBy('funnel_order')->orderByDesc('created_at');
    }
    else if(auth()->user()->privilege_id === 2){
      return $this->hasMany('App\Lead')->where('team_id',auth()->user()->team_id)->with(['user'])->orderBy('funnel_order')->orderByDesc('created_at');
    }
    else if(auth()->user()->privilege_id === 1){
      return $this->hasMany('App\Lead')->where('leads.user_id',auth()->user()->id)->orderBy('funnel_order')->orderByDesc('created_at');
    }
  }

}
