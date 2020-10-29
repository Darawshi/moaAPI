<?php

namespace App\Traits;

use App\Models\AdvAttach;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic;

trait UploadTrait
{

    public function imageUpload($file,$path,$resizedWidth,$resizedHeight,$thumbWidth,$thumbHeight){
        $imageName = (new DateTime('now'))->format('Y-m-d-His').'-'.$file->getClientOriginalName();
        $imgResized =ImageManagerStatic::make($file)->resize($resizedWidth,$resizedHeight)->save(storage_path('app/public/'.$path.'/image/resized/'.$imageName));
        $imgThumb =ImageManagerStatic::make($file)->resize($thumbWidth,$thumbHeight)->save(storage_path('app/public/'.$path.'/image/thumb/'.$imageName));
//        $img =ImageManagerStatic::make($file)->resize(400, 400, function ($constraint) {
//            $constraint->aspectRatio();
//            $constraint->upsize();
//        })->save('image/thumb/'.$name.'.'.$file->extension());
//        $url=Storage::putFileAs('public/article/image/original',$file,$name .'.' .$file->extension());
        return $imageName;
    }

    public function advAttachUpload($attach,$id){

            $fileName = (new DateTime('now'))->format('Y-m-d-His').'-'.$attach->getClientOriginalName();
            $attach->move(storage_path('app/public/adv/Files'), $fileName);
            AdvAttach::create([
                'adv_id' => $id,
                'attachment' => $fileName,
                'user_id' =>Auth::user()->id
            ]);

    }
}
