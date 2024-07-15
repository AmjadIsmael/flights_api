<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SanitizeInput
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
        $this->sanitizeInputFields($request);
        return $next($request);
    }

    protected function sanitizeInputFields(Request $request)
    {
        $input = $request->all();
        array_walk_recursive($input, function (&$value) {
            $value = e($value);
        });
        $request->merge($input);
    }
}
