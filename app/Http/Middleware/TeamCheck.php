<?php

namespace App\Http\Middleware;

use Closure;

class TeamCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(auth()->user()->privilege_id !== 3){
          return redirect('/')->with('error','Você não pode fazer isso');
        }

        return $next($request);
    }
}
