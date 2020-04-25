<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class JwtAuthMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = null;

        // with bearer token
        // if ($type == 'bearer'){
            $token= str_replace('Bearer ', "" , $request->header('Authorization'));
        // } // with GET method
        // else if ($type == 'get'){
        //     $token = $request->get('token');
        // }

        try {
            JWTAuth::setToken($token);

            if (!JWTAuth::getPayload()) {
                throw new HttpResponseException(response()->json([
                    'message' => 'User not found'
                ], JsonResponse::HTTP_UNAUTHORIZED));
            }
        } catch (TokenExpiredException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Token expired'
            ], JsonResponse::HTTP_UNAUTHORIZED));
        } catch (TokenInvalidException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Invalid token'
            ], JsonResponse::HTTP_UNAUTHORIZED));
        } catch (JWTException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Token not provided'
            ], JsonResponse::HTTP_UNAUTHORIZED));
        } catch (TokenBlacklistedException $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Token blacklisted'
            ], JsonResponse::HTTP_UNAUTHORIZED));
        }

        return $next($request);
    }
}