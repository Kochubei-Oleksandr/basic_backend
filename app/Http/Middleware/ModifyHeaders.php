<?php

namespace App\Http\Middleware;

use Closure;

class ModifyHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        $origin = $request->getHttpHost() === '127.0.0.1:8000' ? 'http://localhost:4200' : 'https://teadmus.org';

        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', $origin);
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Language, Authorization, X-Requested-With, Application');

        return $response;
    }
}
