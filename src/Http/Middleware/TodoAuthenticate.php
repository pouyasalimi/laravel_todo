<?php

namespace Psli\Todo\Http\Middleware;

use Illuminate\Foundation\Auth\User;
use Illuminate\Auth\AuthenticationException;

class TodoAuthenticate
{
    public function handle($request, \Closure $next)
    {
        $token = $request->bearerToken();

        if ($user = User::where('token', $token)->first()) {
            $request->merge(['user' => $user]);
            return $next($request);
        }

        throw new AuthenticationException;
    }

}
