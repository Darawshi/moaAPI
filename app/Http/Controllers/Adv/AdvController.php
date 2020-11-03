<?php

namespace App\Http\Controllers\Adv;

use App\Http\Controllers\Controller;
use App\Models\Adv;
use App\Models\AdvAttach;
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
        try {
            $rules = [
                'title' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp',
                'attachments.*' =>'mimes:pdf,zip,doc,docx,xls,xlsx,png'
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $file=$request->file('image');
            $Image_name= $this->imageUpload($file,'adv',1000,600,400,400);

            $adv = Adv::create(
                $request ->only('title','description')
                +['img_resized' =>$Image_name,'img_thumb' =>$Image_name,'user_id' =>Auth::user()->id]
            );

            if ($request->hasFile('attachments')){

                foreach ($request->attachments as $attach) {

                    $this->advAttachUpload($attach,$adv->id);
                }
            }

            return $this->returnSuccessMessage(__('messages.adv_created'));

        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $adv =Adv::find($id);
            if(!$adv){
                return $this->returnError('E013' ,__('messages.adv_not_found'));
            }

            $rules = [
                'title' => 'string',
                'description' => 'string',
                'image' => 'mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp',
                'attachments.*' =>'mimes:pdf,zip,doc,docx,xls,xlsx,png'
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $image=$request->file('image');
            $file=$request->file('attachments');
            if ($image){
                $Image_name= $this->imageUpload($image,'adv',1000,600,400,400);
                $adv->update(
                    $request ->only('title','description')
                    +['img_resized' =>$Image_name,'img_thumb' =>$Image_name,'user_id' =>Auth::user()->id]
                );

                if ($file){
                    foreach ($request->attachments as $attach) {

                        $this->advAttachUpload($attach,$adv->id);
                    }
                }
            }

            else{
                $adv->update($request ->only('title','description'));
                if ($file){
                    foreach ($request->attachments as $attach) {

                        $this->advAttachUpload($attach,$adv->id);
                    }
                }
            }

            return $this->returnSuccessMessage(__('messages.adv_updated'));

        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public function destroy($id)
    {
        try {
            $adv= Adv::find($id);
            if(!$adv){
                return $this->returnError('E013' ,__('messages.adv_not_found'));
            }
            $attachments =AdvAttach::whereAdvId($id)->get();
            foreach ($attachments as $attachment){
               $attachFile =$attachment->attachment;
                Storage::delete('public/adv/Files/'.$attachFile);
            }
            AdvAttach::whereAdvId($id)->delete();
            //get adv img name
            $imgResized =$adv->img_resized;
            $imgThumb =$adv->img_resized;

            //delete adv img from storage
            Storage::delete('public/adv/image/resized/'.$imgResized);
            Storage::delete('public/adv/image/thumb/'.$imgThumb);
            //delete adv
            Adv::destroy($id);

            return $this->returnSuccessMessage(__('messages.adv_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function userAdv(){
        try {

            $id=Auth::user()->id;
            $adv =Adv::where('user_id',$id)->paginate();

            if(!$adv){
                return $this->returnError('E013' ,__('messages.adv_not_found'));
            }
            return $this->returnData('adv' ,$adv);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
