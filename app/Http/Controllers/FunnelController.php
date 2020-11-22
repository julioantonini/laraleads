<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funnel;
use App\Lead;

class FunnelController extends Controller
{
  public function index()
  {

    $funnels = Funnel::with('leads')->orderBy('id')->get();
    return view('funnel', compact(['funnels']));
  }


  public function update(Request $request)
  {
    $lead = Lead::find($request->lead_id);
    if(isset($lead)){
      $lead->status = 1;
      $lead->save();
    }


    $data = json_decode($request->data, TRUE);
    foreach($data as $d){
      $d['id'];
      $d['funnel_id'];
      $d['funnel_order'];

      Lead::where('id', $d['id'])->update(['funnel_id' => $d['funnel_id'], 'funnel_order' => $d['funnel_order']]);
    };
  }

}
