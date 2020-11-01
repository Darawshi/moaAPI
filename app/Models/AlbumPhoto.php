<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AlbumPhoto
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AlbumPhoto query()
 * @mixin \Eloquent
 */
class AlbumPhoto extends Model
{
    use HasFactory;

    protected $table = 'album_photos';

    protected $fillable=[
        'name','album_id',
    ];



    public function adv(){
        return $this->belongsTo(Album::class , 'album_id' ,'id');
    }


}
