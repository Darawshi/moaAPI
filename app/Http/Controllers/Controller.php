<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
//    use GeneralTrait;
//
//
//    public function getAllUsers(){
//        $users =User::select('id' ,  'name_'.app() ->getLocale() .' as name') ->get();
//        return $this->returnData('user', $users);
//    }
//
//    public function GetUserByID(Request  $request){
//         $user = User::find($request->id);
//         if (!$user){
//             return $this->returnError('001', 'هذا القسم غير موجد');
//         }
//         else{
//             return $this->returnData('user', $user);
//         }
//
//    }

}
