<?php

namespace App\Http\Controllers\Adv;

use App\Http\Controllers\Controller;
use App\Models\Adv;
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
            $adv =Adv::paginate();

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
            $adv =Adv::find($id);

            if(!$adv){
                return $this->returnError('E013' ,__('messages.adv_not_found'));
            }
            return $this->returnData('adv' ,$adv);
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
