<?php

namespace App\Http\Middleware;

use Closure;

class TokenKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function macReverse($data)
    {
        $mac = sha1(strrev($data . 'xsasdasd238@3$**(_+^#%$^'));
        return $mac;
    }

    public function handle($request, Closure $next)
    {
        $token = $request->header('token');
        if ($token != $this->macReverse($request->deviceInfo['mac-address'])) {
        return response()->json(['message'=>'token not found'],401);
        }
        return $next($request);
    }
}
