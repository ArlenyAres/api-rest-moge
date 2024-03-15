<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
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
        $allowedOrigins = ['http://localhost:3000'];

        $response = $next($request);

        if (in_array($request->header('Origin'), $allowedOrigins)) {
            $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Headers','X-Requested-With, Content-Type, X-Token-Auth, Authorization');
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
