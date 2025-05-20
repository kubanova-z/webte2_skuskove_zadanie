<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrashTest
{
    public function handle($request, Closure $next)
    {
        throw new \Exception('🚨 CrashTest middleware is running!');
    }
}
