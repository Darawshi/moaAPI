<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvAttach extends Model
{
    use HasFactory;
    protected $table = 'adv_attaches';

    protected $fillable=[
        'attachment','adv_id','user_id'
    ];
    protected $hidden = [
        'user_id','adv_id'
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }

    public function adv(){
        return $this->belongsTo(Adv::class , 'adv_id' ,'id');
    }


}
