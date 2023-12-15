<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class EnsureApiTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        if(env("API_SERVER_HEADER_TOKENS") != null){
            $tokens = explode(",", env("API_SERVER_HEADER_TOKENS"));
            foreach($tokens as $token){
               
                if($token === $request->header("Api-Token")){
                    return $next($request);
                }
            }
            return response()->json(['error' => 'Unauthorized.'], 401);

        }
        else {
            return response()->json(['error' => 'API Server Header Token no configurado en servidor.'], 401);
        }
    }
}
