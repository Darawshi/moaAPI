<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\GeneralTrait;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ArticleController extends Controller
{
    use GeneralTrait;
    use UploadTrait;

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
        try {
            $rules = [
                'title' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $file=$request->file('image');
            $Image_name= $this->imageUpload($file,'article',1000,600,400,400);

            Article::create(
                $request ->only('title','description')
                +['img_resized' =>$Image_name,'img_thumb' =>$Image_name,'user_id' =>Auth::user()->id]
            );

            return $this->returnSuccessMessage(__('messages.article_created'));


        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $article =Article::find($id);
            if(!$article){
                return $this->returnError('E013' ,__('messages.article_not_found'));
            }

            $rules = [
                'title' => 'required|string',
                'description' => 'required|string',
                'image' => 'mimetypes:image/bmp,image/x-icon,image/jpeg,image/png,image/webp',
            ];

            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $file=$request->file('image');
            if ($file){
                $Image_name= $this->imageUpload($file,'article',1000,600,400,400);

                $article->update(
                    $request ->only('title','description')
                    +['img_resized' =>$Image_name,'img_thumb' =>$Image_name,'user_id' =>Auth::user()->id]
                );
            }

            else{
                $article->update($request ->only('title','description'));
            }

            return $this->returnSuccessMessage(__('messages.article_updated'));

        }
        catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $article= Article::find($id);
            if(!$article){
                return $this->returnError('E013' ,__('messages.articles_not_found'));
            }
            $imageName =$article->img_resized;
            Storage::delete('public/article/image/resized/'.$imageName);
            Storage::delete('public/article/image/thumb/'.$imageName);
            Article::destroy($id);
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
