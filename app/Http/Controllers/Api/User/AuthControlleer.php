<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;
use Auth;
class AuthControlleer extends Controller
{
    use GeneralTrait;
    public function login(Request $request){
        try {
            $rules = [
                "email" => "required",
                "password" => "required"

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            //login

            $credentials = $request->only(['email', 'password']);

            $token = Auth::guard('user_api')->attempt($credentials);

            if (!$token)
                return $this->returnError('E001', 'بيانات الدخول غير صحيحة');

            $user = Auth::guard('user_api')->user();
            $user->api_token = $token;
            //return token
            return $this->returnData('user', $user  );

        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
       $token= $request->auth_token;
      // return $token= $request->header('auth_token');
      if($token)
      {
        try{
        JWTAuth::setToken($token)->invalidate(); //logout
        return $this->returnSuccessMessage('Logged Out Successfuly','e003');
    }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
        return $this->returnError('','som thing went wrong');
    }

      }else{
        return $this->returnError('','som thing went wrong');
      }

    }
}
