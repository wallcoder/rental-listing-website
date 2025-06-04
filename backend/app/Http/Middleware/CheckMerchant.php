<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMerchant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $category = $request->input('category');

        if ($category === 'home_stay' && (!$user || !$user->merchant_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Activate KYC first'
            ], 403);
        }

        return $next($request);
    }
}
