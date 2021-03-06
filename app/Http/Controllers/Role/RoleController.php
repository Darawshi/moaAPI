<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {
            $role =Role::select('id' ,'name_'.$this->getCurrentLang(). ' as name') ->orderBy('id', 'asc')->get();
            if(!$role){
                return $this->returnError('E006' ,__('messages.role_not_found'));
            }
            return $this->returnData('role' ,$role);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $role =Role::select('id' ,'name_'.$this->getCurrentLang(). ' as name')->find($id);
            if(!$role){
                return $this->returnError('E006' ,__('messages.role_not_found'));
            }
            return $this->returnData('role' ,$role);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name_ar' => 'required|string|unique:roles|max:20',
                'name_en' => 'required|string|unique:roles|max:20',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            Role::create($request ->only('name_ar','name_en'));

            return $this->returnSuccessMessage(__('messages.role_created'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'name_ar' => 'required|string|unique:roles|max:20',
                'name_en' => 'required|string|unique:roles|max:20',
            ];
            $role =Role::find($id);
            if(!$role){
                return $this->returnError('E006' ,__('messages.role_not_found'));
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $role->update($request ->only('name'));

            return $this->returnSuccessMessage(__('messages.role_updated'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role= Role::find($id);
            if(!$role){
                return $this->returnError('E006' ,__('messages.role_not_found'));
            }
            Role::destroy($id);
            return $this->returnSuccessMessage(__('messages.role_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError('E013' ,__('messages.role_Used'));
        }
    }
}
