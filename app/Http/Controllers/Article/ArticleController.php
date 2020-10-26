<?php

namespace App\Http\Controllers\Article;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
