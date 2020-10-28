<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Adv
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $img_resized
 * @property string $img_thumb
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdvAttach[] $adv_Attaches
 * @property-read int|null $adv__attaches_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Adv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Adv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Adv query()
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereImgResized($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereImgThumb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Adv whereUserId($value)
 * @mixin \Eloquent
 */
class Adv extends Model
{
    use HasFactory;
    protected $fillable=[
        'title','description','user_id','img_resized','img_thumb'
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
