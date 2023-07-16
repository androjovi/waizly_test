<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;

class LogRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $event = "READ";
        if (preg_match('/edit/i', $request->url()) && $request->method() == "POST"){
            $event = "UPDATE";
        }elseif(preg_match('/delete/i', $request->url())  && $request->method() == "GET" ){
            $event = "DELETE";
        }elseif(preg_match('/create/i', $request->url())  && $request->method() == "POST"){
            $event = "CREATE";
        }elseif(preg_match('/login/i', $request->url())){
            $event = "LOGIN";
        }elseif(preg_match('/logout/i', $request->url())){
            $event = "LOGOUT";
        }

        Logs::create(
            [
                'user_id' => Auth::User()->id ?? 0,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_agent' => $request->header('user-agent'),
                'payload' => json_encode($request->all()),
                'event' => $event,
                'extra' => "",
            ]
        );
        return $next($request);
    }
}
