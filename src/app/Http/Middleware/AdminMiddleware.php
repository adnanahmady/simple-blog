<?php

namespace App\Http\Middleware;

use App\Exceptions\AdminRequiredAccessException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     *
     * @throws AdminRequiredAccessException
     */
    public function handle(Request $request, \Closure $next): Response
    {
        AdminRequiredAccessException::throwUnless(
            $request->user()->isAdmin()
        );

        return $next($request);
    }
}
