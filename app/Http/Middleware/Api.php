<?php

namespace App\Http\Middleware;

use Closure;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $token = "25e5807a7da0425800105c06b65f7c29";
    public function handle($request, Closure $next)
    {
        if($request->token == $this->token)
          return $next($request);
    }
}
