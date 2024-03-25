<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = ['*'];

        $response = $next($request);

        if (in_array($request->header('Origin'), $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Token-Auth, Authorization, Accept, Origin');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }

        return $response;
    }
}

// <?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Http\Response;


// class Cors
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next)
//     {
//         $allowedOrigins = ['http://localhost:3000'];

//         if (in_array($request->header('Origin'), $allowedOrigins)) {
//             return $next($request)
//                 ->header('Access-Control-Allow-Origin', 'http://localhost:3000')
//                 ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
//                 ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//         }

//         return $next($request);
//     }
// }
