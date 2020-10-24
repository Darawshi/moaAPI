<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use GeneralTrait;


    public function index(){
        try {
            $user =User::all();
            if(!$user){
                return $this->returnError('E013' ,'there is no users');
            }
            return $this->returnData('user' ,$user);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function show($id){
        try {
            $user =User::find($id);
            if(!$user){
                return $this->returnError('E013' ,'User not found');
            }
            return $this->returnData('user' ,$user);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request){
        try {
            $rules = [
                'first_name_ar' => 'required|string|max:15',
                'last_name_ar' => 'required|string|max:15',
                'first_name_en' => 'required|string|max:15',
                'last_name_en' => 'required|string|max:15',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string',
                'emp_id' => 'required|string|unique:users|max:6',

            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            User::create(
                $request ->only('first_name_ar','last_name_ar','first_name_en','last_name_en','email','emp_id')
                +['password' =>Hash::make('password')

            ]);

            return $this->returnSuccessMessage('user created');


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function update(Request $request ,$id){
        try {
            $user =User::find($id);
            if(!$user){
                return $this->returnError('E013' ,'User not found');
            }
            $rules = [
                'first_name_ar' => 'string|max:15',
                'last_name_ar' => 'string|max:15',
                'first_name_en' => 'string|max:15',
                'last_name_en' => 'string|max:15',
                'email' => 'string|email|unique:users',
                'emp_id' => 'string|unique:users|max:6',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user->update($request ->only('first_name_ar','last_name_ar','first_name_en','last_name_en','email','emp_id'));

            return $this->returnSuccessMessage('user updated');


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id){
        try {
           $user= User::destroy($id);
            if(!$user){
                return $this->returnError('E013' ,'User not found');
            }
            return $this->returnSuccessMessage('user deleted');
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }
}
