<?php

namespace App\Http\Middleware;

use Closure;

class HandleCors
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
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, X-Token-Auth, Authorization, X-Requested-With, Accept, Origin, x-xsrf-token, x_csrftoken'
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('OK', 200, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
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
