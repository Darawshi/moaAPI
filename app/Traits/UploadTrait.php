<?php

namespace App\Traits;

use DateTime;
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


}
