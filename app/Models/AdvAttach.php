<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdvAttach
 *
 * @property int $id
 * @property string $attachment
 * @property int $user_id
 * @property int $adv_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Adv $adv
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach whereAdvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvAttach whereUserId($value)
 * @mixin \Eloquent
 */
class AdvAttach extends Model
{
    use HasFactory;
    protected $table = 'adv_attaches';

    protected $fillable=[
        'attachment','adv_id','user_id'
    ];
    protected $hidden = [
        'user_id','created_at','updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }

    public function adv(){
        return $this->belongsTo(Adv::class , 'adv_id' ,'id');
    }


}
