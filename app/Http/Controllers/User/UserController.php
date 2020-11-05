<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use GeneralTrait;
    use UploadTrait;

    private $UpdateRules = [
        'first_name_ar' => 'string|max:15',
        'last_name_ar' => 'string|max:15',
        'first_name_en' => 'string|max:15',
        'last_name_en' => 'string|max:15',
        'email' => 'string|email|unique:users',
        'emp_id' => 'string|unique:users|max:6',
        'role_id' => 'numeric',
        'photo'=>'mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp'
    ];

    public function index(){
        try {
            $user =User::with(['role'=>function($q){
                return $q->select('name_'.$this->getCurrentLang().' as name','id');
            }] )->select(
                'first_name_'.$this->getCurrentLang().' as first_name',
                'last_name_'.$this->getCurrentLang().' as last_name',
                'email',
                'emp_id',
                'id',
                'role_id',
                'img_thumb',
                'img_resized')
                ->paginate();


            if(!$user){
                return $this->returnError('E013' ,__('messages.user_not_found'));
            }
            return $this->returnData('user' ,$user);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function show($id){
        try {
            $user =User::with(['role'=>function($q){
                return $q->select('name_'.$this->getCurrentLang().' as name','id');
            }] )->select(
                'first_name_'.$this->getCurrentLang().' as first_name',
                'last_name_'.$this->getCurrentLang().' as last_name',
                'email',
                'emp_id',
                'id',
                'role_id',
                'img_thumb',
                'img_resized')
                ->find($id);

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
                'role_id' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            User::create(
                $request ->only('first_name_ar','last_name_ar','first_name_en','last_name_en','email','emp_id','role_id')
                +['password' =>Hash::make('password')

            ]);

            return $this->returnSuccessMessage(__('messages.user_created'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function update(Request $request ,$id){
        try {
            $user =User::find($id);
            if(!$user){
                return $this->returnError('E013' ,__('messages.user_not_found'));
            }

            $validator = Validator::make($request->all(), $this->UpdateRules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user->update($request ->only('first_name_ar','last_name_ar','first_name_en','last_name_en','email','emp_id','role_id'));

            return $this->returnSuccessMessage(__('messages.user_updated'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id){
        try {
           $user= User::find($id);
            if(!$user){
                return $this->returnError('E013' ,__('messages.user_not_found'));
            }
            $imageResized =$user->img_resized;
            $imageThumb =$user->img_thumb;
            Storage::delete('public/user/image/resized/'.$imageResized);
            Storage::delete('public/user/image/thumb/'.$imageThumb);
            User::destroy($id);
            return $this->returnSuccessMessage(__('messages.user_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function profile(){
        try {
            $user =Auth::user();
            if(!$user){
                return $this->returnError('E013' ,__('messages.user_not_found'));
            }
            return $this->returnData('user' ,$user);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function profileUpdate(Request $request){
        try {
            $user =Auth::user();
            if(!$user){
                return $this->returnError('E013' ,__('messages.user_not_found'));
            }

            $validator = Validator::make($request->all(), $this->UpdateRules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            if ($request->hasFile('photo')){
                $file=$request->file('photo');
                $Image_name= $this->imageUpload($file,'user',1000,600,400,400);

                $user->update(
                    $request ->only('first_name_ar','last_name_ar','first_name_en','last_name_en','email','emp_id')
                    +['img_resized' =>$Image_name,'img_thumb' =>$Image_name]
                );
            }
            else{
                $user->update($request ->only('first_name_ar','last_name_ar','first_name_en','last_name_en','email','emp_id'));
            }


            return $this->returnSuccessMessage(__('messages.user_updated'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function profilePassword(Request $request){
        try {
            $user =Auth::user();
            if(!$user){
                return $this->returnError('E013' ,__('messages.user_not_found'));
            }
            $rules = [
                'password' => 'required|string|confirmed',
                //confirmed mean 'password_confirmation'=>'same:password'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $user->update([
                'password' =>Hash::make('password')
            ]);

            return $this->returnSuccessMessage(__('messages.user_updated'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

}
