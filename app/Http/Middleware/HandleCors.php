<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleCors
{
    public function handle($request, Closure $next)
    {

        if ($request->isMethod('OPTIONS') || $request->method() === 'PUT') {
            // Permitir la solicitud OPTIONS o el método PUT
            return $next($request);

        }
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept, Origin, Accept-Encoding');
        $response->headers->set('Access-Control-Allow-Credentials', 'true'); 

        
        return $response;
    }
}