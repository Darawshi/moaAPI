<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable=[
      'title','description','image','user_id','img_resized','img_thumb'
    ];
    protected $hidden = [
        'user_id',
    ];


    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }

}