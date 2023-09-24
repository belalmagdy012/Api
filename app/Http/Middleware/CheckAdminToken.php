<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   $user = null;
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e)
        {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('E3001','Invalid Token');
            }elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001','Expired Token');
            }else{
                return $this->returnError('E3001','Token Not Found');
            }
        }catch(\Throwable $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('E3001','Invalid Token');
            }elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001','Expired Token');
            }else{
                return $this->returnError('E3001','Token Not Found');
            }
        }
        if(!$user){
         return $this->returnError('E3001','Unauthenticated');
         return $next($request);
        }

    }










    }

