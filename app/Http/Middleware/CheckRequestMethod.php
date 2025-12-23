<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRequestMethod
{
    protected array $allowedMethods;

    public function __construct(array $methods = ['GET'])
    {
        $this->allowedMethods = $methods;
    }

    public function handle(Request $request, Closure $next, ...$methods)
    {
        $allowed = !empty($methods) ? $methods : $this->allowedMethods;

        if (!in_array($request->method(), $allowed)) {
            $response = [
                'success' => false,
                'message' => 'Method Not Allowed',
                'status_code' => 405,
            ];
            return response()->json($response, $response['status_code']);
        }

        return $next($request);
    }
}
