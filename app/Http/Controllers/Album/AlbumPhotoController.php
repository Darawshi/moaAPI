<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Controller;
use App\Models\AlbumPhoto;
use App\Traits\GeneralTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlbumPhotoController extends Controller
{
    use GeneralTrait;
    use UploadTrait;

    public function store(Request $request)
    {
        try {
            $rules = [
                'album_id'=>'required|numeric',
                'photos.*' => 'required|mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp'
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            foreach ($request->photos as $photo) {
                $Image_name= $this->imageUpload($photo,'album',1000,600,400,400);
                AlbumPhoto::create([
                    'album_id' =>$request->album_id,
                    'img_resized' =>$Image_name,
                    'img_thumb' =>$Image_name,
                ]);
            }

            return $this->returnSuccessMessage(__('messages.photo_created'));

        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $albumPhoto= AlbumPhoto::find($id);
            if(!$albumPhoto){
                return $this->returnError('E013' ,__('messages.photo_not_found'));
            }
            $imgResized =$albumPhoto->img_resized;
            $imgThumb =$albumPhoto->img_resized;
            Storage::delete('public/album/image/resized/'.$imgResized);
            Storage::delete('public/album/image/thumb/'.$imgThumb);

            //delete photo from db
            $photoID=$albumPhoto->id;
            AlbumPhoto::destroy($photoID);
            return $this->returnSuccessMessage(__('messages.photo_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
