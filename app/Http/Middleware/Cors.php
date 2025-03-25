<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define allowed origins
        $allowedOrigins = [
            'http://localhost:3001',
            'http://localhost:8000',
            'https://cismo-main-bbgu3m.laravel.cloud',
            '*'
        ];

        $origin = $request->header('Origin');

        if (!$origin || $origin === $request->getSchemeAndHttpHost()) {
            return $next($request);
        }

        if (in_array($origin, $allowedOrigins)) {
            if ($request->isMethod('OPTIONS')) {
                return response('', 204)
                    ->header('Access-Control-Allow-Origin', $origin)
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-Livewire, Accept')
                    ->header('Access-Control-Allow-Credentials', 'true')
                    ->header('Access-Control-Max-Age', '86400'); // Cache preflight for 24 hours
            }

            // Process the actual request
            $response = $next($request);

            // Add CORS headers to the response
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-Livewire, Accept');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');

            return $response;
        }

        // Deny requests from unallowed origins
        return response('Forbidden', 403)
            ->header('Content-Type', 'text/plain');
    }
}
