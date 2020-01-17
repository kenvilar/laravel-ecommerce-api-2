<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * This will avoid the issues between Transformer and Validation on POST, UPDATE methods
     *
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
        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErrors = [];
            foreach ($data->error as $field => $error) {
                $transformedField = $transformer::transformedAttribute($field);
                $transformedErrors[$transformedField] = str_replace($field, $transformedField, $error);
            }

            $data->error = $transformedErrors;
            $response->setData($data);
        }

        return $response;
    }
}
