<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Album
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Album newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Album query()
 * @mixin \Eloquent
 */
class Album extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','user_id'
    ];
    protected $hidden = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' ,'id');
    }

    public function AlbumPhotos(){
        return $this->hasMany(AlbumPhoto::class,'album_id' ,'id');
    }

}
