<?php

namespace App\Http\Middleware;

use Closure;

class CheckWorkTime
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
        $isDebug = config('app.debug');

        if(!$isDebug){

            $startWorkTime = strtotime('09:00:00');
            $endtWorkTime = strtotime('21:00:00');

            if(time() >= $startWorkTime && time() <= $endtWorkTime) {
                return $next($request);
            }
            abort(503);
        }

        return $next($request);
    }
}
