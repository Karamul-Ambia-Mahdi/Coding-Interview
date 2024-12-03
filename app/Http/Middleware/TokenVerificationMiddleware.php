<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use App\Helper\ResponseHelper;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie("token");
        $result = JWTToken::VerifyToken($token);

        if ($result === "unauthorized") {

            return redirect('/login');
        }
        else if($result->userRole === 'admin'){

            $request->headers->set('user_name', $result->userName);
            $request->headers->set('id', $result->userId);

            return $next($request);
        }
        else{
            return redirect('/login');
        }
    }
}
