<?php

declare(strict_types=1);

namespace App\Middleware;

use AltThree\Throttle\ThrottlingMiddleware;
use Closure;
use Illuminate\Http\Request;

/**
 * This is the global rate limiter middleware.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class GlobalRateLimiter extends ThrottlingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param int                      $limit
     * @param int                      $decay
     * @param bool                     $global
     * @param bool                     $headers
     *
     * @throws \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $limit = 120, $decay = 1, $global = true, $headers = true)
    {
        return parent::handle($request, $next, $limit, $decay, $global, $headers);
    }
}
