<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;




class UserAuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
    {

        try {
            $rules = [
                'email' => 'required|string|email',
                'password' => 'required|string',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credentials = $request -> only('email' ,'password');
            if (Auth::attempt($credentials)){
                /** @var User $user */
                $user =Auth::user();
                $token = $user ->createToken('user-Access-Token') ->accessToken;
                $user -> api_token =$token;
                return $this->returnData('user' ,$user);
            }
            return $this->returnError('E001','username or password are invalid');

        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }


    }

}
