<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadHistoric extends Model
{
  public function user()
  {
    return $this->belongsTo('App\User')->with('privilege');
  }

}
