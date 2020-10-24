<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name_ar'=> $this ->name_ar,
            'name_en'=> $this ->name_en,
            'emp_id'=> $this ->emp_id,
            'name'=> $this ->name_ar,
            'email'=> $this ->email
        ];
    }
}
