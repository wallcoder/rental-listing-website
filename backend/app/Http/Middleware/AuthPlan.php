<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthPlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userCurrentPlan = $request->user()->current_plan;
        $userId = $request->user()->id;
    
        if ($userCurrentPlan === 'free') {
    
            $postCount = Post::where('user_id', $userId)
                             ->where('status', 'active')
                             ->count();
    
            if ($postCount >= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'You already have one active post. Upgrade your plan to post more listings.'
                ], 403);
            }
        }
    
        return $next($request);
    }
    
}
