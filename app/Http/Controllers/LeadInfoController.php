<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\LeadHistoric;

class LeadInfoController extends Controller
{



  public function show($id)
  {
    $lead = Lead::where('id', $id)->with(['historics'])->first();
    return $lead;
  }


  public function store(Request $request)
  {
    $ls = new LeadHistoric();
    $ls->user_id = auth()->user()->id;
    $ls->lead_id = $request->lead_id;
    $ls->message = $request->message;
    $ls->save();
    $ls->load('user');
    return $ls;
  }



}
