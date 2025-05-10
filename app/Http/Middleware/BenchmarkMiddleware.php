<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class BenchmarkMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        $response = $next($request);
        $duration = microtime(true) - $start;
        
        $response->headers->set('X-Response-Time', $duration * 1000);
        
        if ($duration > 0.5) { // 500ms
            Log::warning("Slow response", [
                'url' => $request->url(),
                'time' => $duration
            ]);
        }
        
        return $response;
    }
}
