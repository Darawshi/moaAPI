<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereNameEn($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function users(){
        return $this->hasMany(User::class,'role_id' ,'id');
    }
}
