<?php

namespace App\Http\Controllers\Adv;

use App\Http\Controllers\Controller;
use App\Models\AdvAttach;
use App\Traits\GeneralTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdvAttachController extends Controller
{
    use GeneralTrait;
    use UploadTrait;

    public function store(Request $request)
    {
        try {
            $rules = [
                'attachments.*' => 'required|mimes:pdf,zip,doc,docx,xls,xlsx,png,jpg',
                'adv_id' => 'required|numeric',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $advID = $request->adv_id;
            foreach ($request->attachments as $attach) {

                $this->advAttachUpload($attach,$advID);
            }

            return $this->returnSuccessMessage(__('messages.attach_created'));
        }

        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $advAttach= AdvAttach::find($id);
            if(!$advAttach){
                return $this->returnError('E013' ,__('messages.attach_not_found'));
            }
            $attachFile =$advAttach->attachment;
            Storage::delete('public/adv/Files/'.$attachFile);
            AdvAttach::destroy($id);
            return $this->returnSuccessMessage(__('messages.attach_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
