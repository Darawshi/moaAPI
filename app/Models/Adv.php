<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','description','user_id','image'
    ];
    protected $hidden = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }

    public function adv_Attaches(){
        return $this->hasMany(AdvAttach::class,'adv_id' ,'id');
    }


}
