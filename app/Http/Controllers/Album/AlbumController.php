<?php

namespace App\Http\Controllers\Album;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Traits\GeneralTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    use GeneralTrait;
    use UploadTrait;

    public function index()
    {
        try {
            $album =Album::with(['AlbumPhotos'=>function($q){
                return $q->select('name','album_id');
            }] )->paginate();

            if(!$album){
                return $this->returnError('E013' ,__('messages.album_not_found'));
            }
            return $this->returnData('album' ,$album);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $album =Album::with(['AlbumPhotos'=>function($q){
                return $q->select('name','album_id');
            }] )->find($id);

            if(!$album){
                return $this->returnError('E013' ,__('messages.album_not_found'));
            }
            return $this->returnData('album' ,$album);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string',
                'photos.*' => 'required|mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $album=Album::create(
                $request ->only('name')
                +['user_id' =>Auth::user()->id]
            );

            foreach ($request->photos as $photo) {
                $Image_name= $this->imageUpload($photo,'album',1000,600,400,400);
                AlbumPhoto::create([
                    'album_id' =>$album-> id,
                    'img_resized' =>$Image_name,
                    'img_thumb' =>$Image_name,
                ]);
            }

            return $this->returnSuccessMessage(__('messages.album_created'));

        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $album =Album::find($id);
            if(!$album){
                return $this->returnError('E013' ,__('messages.album_not_found'));
            }

            $rules = [
                'name' => 'string',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $album->update(
                $request ->only('name') +['user_id' =>Auth::user()->id]
            );

            return $this->returnSuccessMessage(__('messages.album_updated'));

        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $album= Album::find($id);
            if(!$album){
                return $this->returnError('E013' ,__('messages.album_not_found'));
            }
            //get the album photo
            $albumPhotos=AlbumPhoto::where('album_id',$id)->get();
            //delete photo from fileSystem
            foreach ($albumPhotos as $photo){
            $imgResized =$photo->img_resized;
            $imgThumb =$photo->img_resized;
            Storage::delete('public/album/image/resized/'.$imgResized);
            Storage::delete('public/album/image/thumb/'.$imgThumb);

            //delete photo from db
            $photoID=$photo->id;
            AlbumPhoto::destroy($photoID);
                return $this->returnSuccessMessage(__('messages.album_deleted'));
            }

            //delete album
            Album::destroy($id);
            return $this->returnSuccessMessage(__('messages.album_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
