<?php
// app/Http/Middleware/TrackVisitor.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);  // Just pass the request without doing anything
    }
}
