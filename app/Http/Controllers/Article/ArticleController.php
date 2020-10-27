<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;


class ArticleController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        try {
            $article =Article::paginate();

            if(!$article){
                return $this->returnError('E013' ,__('messages.articles_not_found'));
            }
            return $this->returnData('article' ,$article);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $article =Article::find($id);

            if(!$article){
                return $this->returnError('E013' ,__('messages.articles_not_found'));
            }
            return $this->returnData('article' ,$article);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function store(Request $request)
    {

        $file=$request->file('image');
        $name=Str::random(10);
        $imgResized =ImageManagerStatic::make($file)->resize(700,400)->save(storage_path('app/public/article/image/resized/'.$name.'.'.$file->extension()));
        $imgThumb =ImageManagerStatic::make($file)->resize(300,200)->save(storage_path('app/public/article/image/thumb/'.$name.'.'.$file->extension()));
//        $img =ImageManagerStatic::make($file)->resize(400, 400, function ($constraint) {
//            $constraint->aspectRatio();
//            $constraint->upsize();
//        })->save('image/thumb/'.$name.'.'.$file->extension());

        $url=Storage::putFileAs('public/article/image/original',$file,$name .'.' .$file->extension());


        $article=Article::create([
                'title'=>$request->input('title'),
                'description'=>$request->input('description'),
                'image'=>env('APP_URL') .'/'. $url,
                'img_resized'=>env('APP_URL') .'/'. env('ARTICLE_THUMB_IMG').$name .'.' .$file->extension(),
                'img_thumb'=>env('APP_URL') .'/'. env('ARTICLE_THUMB_RESIZED').$name .'.' .$file->extension(),
                'user_id'=> Auth::user()->id,
        ]);

        return response($article,Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        try {
            $article= Article::destroy($id);
            if(!$article){
                return $this->returnError('E013' ,__('messages.articles_not_found'));
            }
            return $this->returnSuccessMessage(__('messages.article_deleted'));
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function userArticle(){
        try {

            $id=Auth::user()->id;
            $article =Article::where('user_id',$id)->paginate();

            if(!$article){
                return $this->returnError('E013' ,__('messages.articles_not_found'));
            }
            return $this->returnData('article' ,$article);
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
}
