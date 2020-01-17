<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TransformInput
{
    /**
     * This will avoid the issues between Transformer and Validation on POST, UPDATE methods
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param $transformer
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        $transformedInput = [];
        foreach ($request->all() as $input => $value) {
            $transformedInput[$transformer::originalAttributes($input)] = $value;
        }
        $request->replace($transformedInput);
        return $next($request);
    }
}
