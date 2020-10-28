<?php

namespace App\Http\Controllers\Adv;

use App\Http\Controllers\Controller;
use App\Models\Adv;
use App\Traits\GeneralTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdvController extends Controller
{
    use GeneralTrait;
    use UploadTrait;

    public function index()
    {
        try {
            $adv =Adv::with(['adv_Attaches'=>function($q){
                return $q->select('attachment','adv_id');
            }] )->paginate();

            if(!$adv){
                return $this->returnError('E013' ,__('messages.advs_not_found'));
            }
            return $this->returnData('adv' ,$adv);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $adv =Adv::with(['adv_Attaches'=>function($q){
                return $q->select('attachment','adv_id');
            }] )->find($id);

            if(!$adv){
                return $this->returnError('E013' ,__('messages.adv_not_found'));
            }
            return $this->returnData('adv' ,$adv);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
