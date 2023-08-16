<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyArticleAccess
{
    
    public function handle($request, Closure $next)
    {
       
        
        if (auth()->user()->isAdmin()) {
            return $next($request);
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}