<?php

declare(strict_types=1);

namespace App\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * This is the access control middleware class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof Response) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
        }

        return $response;
    }
}
